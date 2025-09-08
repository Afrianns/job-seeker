<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Application;
use App\Models\JobListing;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ApplyingJobController extends Controller
{
    public function myApplication(?string $id = null)
    {
        $selected_application = null;
        if(isset($id)){
            $application = Application::with("job", "job.company")->where("user_id", Auth::user()->id)->firstWhere("id", $id);
        
            $selected_application = [
                'sender_id' => Auth::user()->id,
                'receiver_id' => $application->job->company->recruiter->id,
                "application" => $application
            ];
        }

        $applications = Application::with("job")->where("user_id", Auth::user()->id)->get();
        return view("my-application", compact("applications"), compact("selected_application"));
    }

    // Admin application display
    public function userJobsApplications(){
        $jobs_applications = JobListing::withCount("application")->where("company_id", Auth::user()->company->id)->get();
        
        $total_applications = false;
        $count_applications = 0;
        
        foreach ($jobs_applications as $key => $value) {
            $count_applications += $value->application_count;
        }

        if($count_applications > 0){
            $total_applications = true;
        }

        return view("recruiter.jobs-applications", compact("jobs_applications"), compact("total_applications"));
    }

    public function userApplications(string $job_id, ?string $application_id = null){
        $selected_application = null;
        
        if(isset($application_id)){

            $application = Application::with("job")->firstWhere("id", $application_id);
            $selected_application = [
                'sender_id' => Auth::user()->id,
                'receiver_id' => $application->user->id,
                'application' => $application
            ];
        }

        // $applications = Application::with("job")->get();

        $job_applications = JobListing::with("application")->where("id", $job_id)->first();
        return view("recruiter.applicants", compact("job_applications"), compact("selected_application"));
    }

    public function applyJobPOST(Request $request) 
    {
        if(Gate::allows("is_a_recruiter")){
            return redirect()->back();
        }

        $validated = $request->validate([
            "job_id" => "required",
            "cv_file" => "file|mimes:pdf|max:5024",
        ]);

        $cv_data = [            
            "name" => "",
            "type" => "",
            "size" => "",
            "cv_path" => ""
        ];

        // check if there is an uploaded cv
        if(isset($validated["cv_file"])){
            
            // then store it to applied Cv folder
            $cv_path = Storage::putFile('applied-cv', $validated['cv_file']);

            // if success save data to variable $cv_data
            if($cv_path) {
                $cv_data = [...$this->getCVData($validated["cv_file"]), "cv_path" => $cv_path];
            } else{
                // or redirect with error
               return redirect("/detail/{$validated['job_id']}")->with("error", "There is an error while get file"); 
            }
        } else{
            // if not uploaded cv use profile cv
            if(Auth::user()->documentCV()->exists()){
                // copy profile cv to applied cv folder
                if(Storage::copy(Auth::user()->documentCV->cv_path, 'applied-cv/'. basename(Auth::user()->documentCV->cv_path))){
                    
                    // get cv data then store it to $cv_data
                    $profile_CV_data = Auth::user()->documentCV;
                    
                    $cv_data = [
                        "name" => $profile_CV_data->name,
                        "type" => $profile_CV_data->type,
                        "size" => $profile_CV_data->size,
                        "cv_path" => 'applied-cv/'. basename(Auth::user()->documentCV->cv_path)
                    ];

                } else{
                    // if copy failed then redirect with error
                    return redirect("/detail/{$validated['job_id']}")->with("error", "There is an error while get file");
                }
            } else{
                // if profile cv not exist then redirect with error 
                return redirect("/detail/{$validated['job_id']}")->with("error", "No CV provided");
            }
        }

        Application::create([...$cv_data, "user_id" => Auth::user()->id, "job_listing_id" => $validated["job_id"]]);
        
        return redirect("/detail/{$validated['job_id']}")->with("success", "Application successfully sent");
        // dd($request->all(), count($validated));
    }


    public function getCVData($cv_file) {
        $file_origin_name = $cv_file->getClientOriginalName();
        $file_mimetype = $cv_file->getMimeType();
        $file_size = number_format($cv_file->getSize()/1048576, 2). "MB";

        return [
            "name" => $file_origin_name,
            "type" => $file_mimetype,
            "size" => $file_size
        ];
    }


    public function setApplicationStatus($type, $application_id) 
    {
        $set_status = "";

        if($type == "approve"){
            $set_status = "approved";
        } 
        
        if($type == "reject"){
            $set_status = "rejected";
        } 
        if ($set_status != '') {
            Application::where("id", $application_id)->update([
                "status" => $set_status
            ]);
            return redirect()->back();
        }
    }

    // Message functionality 

    public function getMessage(string $job_id) {

        $messages = Message::withTrashed()->with(["user"])->where("job_id", $job_id)->get();

        if($messages->count() >= 1){
            
            $result = $messages->map(function($message) {
                return $this->rearrangeMessage($message);
            });

            return $result;
        } else{
            return throw new Exception("No Message Exist");
        }
    }

    public function sendMessage(Request $request)
    {

        $validated = $request->validate([
            "message" => "required|min:5",
            "messageId" => "exists:messages,id",
            "appId" => "required|exists:applications,id",
            "jobId" => "required|exists:job_listings,id",
            "senderId" => "required|exists:users,id",
            "receiverId" => "required|exists:users,id"
        ]);

        $result = Message::create([
            "user_id" => Auth::user()->id,
            "job_id" => $validated["jobId"],
            "application_id" => $validated["appId"],
            "message" => $validated["message"],
            "message_id" => $validated["messageId"] ?? null,
            "sender_id" => $validated["senderId"],
            "receiver_id" => $validated["receiverId"]
        ]);

        if($result){
            $rearrange_message = $this->rearrangeMessage($result);
           
            broadcast(new ChatEvent([...$rearrange_message, "event_type" => "sending"]));
        }
    }

    public function sendEditedMessage(Request $request)
    {
        $validated = $request->validate([
            "message" => "required|min:5",
            "messageId" => "required|exists:messages,id",
        ]);

        $result = Message::where("id", $validated["messageId"])->update(["message" => $validated["message"], "is_edited" => true]);
        
        if($result == 1) {

            $message = Message::firstWhere("id", $validated["messageId"]);
            
            $rearrange_message = $this->rearrangeMessage($message);
            broadcast(new ChatEvent([...$rearrange_message, "event_type" => "editing"]));
        }
    }

    public function DeletedMessage(Request $request)
    {
        $validated = $request->validate([
            "messageId" => "required|exists:messages,id",
        ]);

        $row_effected = Message::where("id", $validated["messageId"])->delete();
        
        if($row_effected){
            $message = Message::withTrashed()->firstWhere("id", $validated); 

            $rearrange_message = $this->rearrangeMessage($message);
            broadcast(new ChatEvent([...$rearrange_message, "event_type" => "deleting"]));
        }

    }


    private function rearrangeMessage($message) 
    {
        $rearrange_message = [
            "id" => $message->id,
            "message" => $message->message,
            "user_id" => $message->user->id,
            "user_name" => $message->user->name,
            "user_avatar" => ($message->user->avatar_path) ? $message->user->avatar_path : "/storage/avatars/no-avatar.svg",
            "sender_id" => $message->sender_id,
            "message_id" => $message->message_id,
            "receiver_id" => $message->receiver_id,
            "is_edited" => $message->is_edited,
            "application_id" => $message->application_id,
            "created_at" => Carbon::parse($message->created_at)->timezone("Asia/Jakarta")->toDayDateTimeString(),
            "updated_at" => Carbon::parse($message->updated_at)->timezone("Asia/Jakarta")->toDayDateTimeString(),
            "deleted_at" => ($message->deleted_at) ? Carbon::parse($message->deleted_at)->timezone("Asia/Jakarta")->toDayDateTimeString() : null
        ];

        return $rearrange_message;
    }
}

