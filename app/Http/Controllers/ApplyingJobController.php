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
        $jobs_applications = JobListing::withCount("application")->get();
        return view("admin.jobs-applications.jobs-applications", compact("jobs_applications"));
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
        return view("admin.jobs-applications.applicants", compact("job_applications"), compact("selected_application"));
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

    public function getMessage(string $job_id) {

        $messages = Message::withTrashed()->with(["user"])->where("job_id", $job_id)->get();

        if($messages->count() >= 1){
            
            $user = User::where("id", $messages->first()->user_id)->first();
            
            $result = $messages->map(function($message) use ($user) {
                return [
                    "id" => $message->id,
                    "message" => ($message->deleted_at) ? null : $message->message,
                    "user_id" => $message->user->id,
                    "user_name" => $message->user->name,
                    "user_avatar" => ($user["avatar_path"]) ? $user["avatar_path"] : "/storage/avatars/no-avatar.svg",
                    "sender_id" => $message->sender_id,
                    "receiver_id" => $message->receiver_id,
                    "is_edited" => $message->is_edited,
                    "is_deleted" => $message->is_deleted,
                    "created_at" => Carbon::parse($message->created_at)->timezone("Asia/Jakarta")->toDayDateTimeString(),
                    "updated_at" => Carbon::parse($message->updated_at)->timezone("Asia/Jakarta")->toDayDateTimeString(),
                    "deleted_at" => ($message->deleted_at) ? Carbon::parse($message->deleted_at)->timezone("Asia/Jakarta")->toDayDateTimeString() : null
                ];
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
            "jobId" => "required|exists:job_listings,id",
            "senderId" => "required|exists:users,id",
            "receiverId" => "required|exists:users,id"
        ]);

        $result = Message::create([
            "user_id" => Auth::user()->id,
            "job_id" => $validated["jobId"],
            "message" => $validated["message"],
            "sender_id" => $validated["senderId"],
            "receiver_id" => $validated["receiverId"]
        ]);

        if($result){
            $sender = User::where("id", $result["user_id"])->first();
            
            $rearrange_message = [
                "id" => $result["id"],
                "message" => $result["message"],
                "user_id" => $sender["id"],
                "user_name" => $sender["name"],
                "user_avatar" => ($sender["avatar_path"]) ? $sender["avatar_path"] : "/storage/avatars/no-avatar.svg",
                "sender_id" => $result["sender_id"],
                "receiver_id" => $result["receiver_id"],
                "is_edited" => $result["is_edited"],
                "is_deleted" => $result["is_deleted"],
                "created_at" => Carbon::parse($result["created_at"])->timezone("Asia/Jakarta")->toDayDateTimeString(),
                "updated_at" => Carbon::parse($result["updated_at"])->timezone("Asia/Jakarta")->toDayDateTimeString()
            ];
            broadcast(new ChatEvent($rearrange_message))->toOthers();

            return response()->json($rearrange_message);
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
            
            $rearrange_message = [
                "id" => $message->id,
                "message" => $message->message,
                "user_id" => $message->user->id,
                "user_name" => $message->user->name,
                "user_avatar" => ($message->user->avatar_path) ? $message->user->avatar_path : "/storage/avatars/no-avatar.svg",
                "sender_id" => $message->sender_id,
                "receiver_id" => $message->receiver_id,
                "is_edited" => $message->is_edited,
                "is_deleted" => $message->is_deleted,
                "created_at" => Carbon::parse($message->created_at)->timezone("Asia/Jakarta")->toDayDateTimeString(),
                "updated_at" => Carbon::parse($message->updated_at)->timezone("Asia/Jakarta")->toDayDateTimeString()
            ];   
            return $rearrange_message;
        }
    }

    public function DeletedMessage(Request $request) 
    {
        $validated = $request->validate([
            "messageId" => "required|exists:messages,id",
        ]);

        $result = Message::where("id", $validated["messageId"])->delete();

        return $result;

    }
}


// created_at : "2025-08-28T07:45:26.000000Z"
// id: "0198efa3-8026-7080-84ff-a20c8d10894a"
// message: "glad is here"
// updated_at: "2025-08-28T07:45:26.000000Z"
// user_id: "0198cb5e-f6f0-7055-b263-12e98dd6fa61"
// user: 

// avatar_path: null
// company_id :null
// created_at : "2025-08-21T06:44:15.000000Z"
// email : "jackson@gmail.com"
// email_verified_at : null
// id : "0198cb5e-f6f0-7055-b263-12e98dd6fa61"
// is_recruiter : 0
// name : "jackson"
// updated_at : "2025-08-21T06:44:15.000000Z"