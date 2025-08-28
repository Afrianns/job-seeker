<?php

namespace App\Http\Controllers;

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
            $selected_application = Application::with("job")->where("user_id", Auth::user()->id)->firstWhere("id", $id);
        }

        $applications = Application::with("job")->where("user_id", Auth::user()->id)->get();
        return view("my-application", compact("applications"), compact("selected_application"));
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

        $messages = Message::with(["user"])->where("job_id", $job_id)->get();

        if($messages->count() >= 1){
            
            $user = User::where("id", $messages->first()->user_id)->first();
            
            $result = Arr::map($messages->toArray(), function($message) use ($user) {
                return [
                    "id" => $message["id"],
                    "message" => $message["message"],
                    "user_id" => $user["id"],
                    "user_name" => $user["name"],
                    "user_avatar" => ($user["avatar_path"]) ? $user["avatar_path"] : "/storage/avatars/no-avatar.svg",
                    "is_user_recruiter" => $user["is_recruiter"],
                    "created_at" => Carbon::parse($message["created_at"])->timezone("Asia/Jakarta")->toDayDateTimeString()
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
            "jobId" => "required|exists:job_listings,id"
        ]);

        $result = Message::create([
            "user_id" => Auth::user()->id,
            "job_id" => $validated["jobId"],
            "message" => $validated['message']
        ]);

        if($result){

            $sender = User::where("id", $result["user_id"])->first();

            return response()->json([
                "id" => $result["id"],
                "message" => $result["message"],
                "user_id" => $sender["id"],
                "user_name" => $sender["name"],
                "user_avatar" => ($sender["avatar_path"]) ? $sender["avatar_path"] : "/storage/avatars/no-avatar.svg",
                "is_user_recruiter" => $sender["is_recruiter"],
                "created_at" => Carbon::parse($result["created_at"])->timezone("Asia/Jakarta")->toDayDateTimeString()
            ]);
        }
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