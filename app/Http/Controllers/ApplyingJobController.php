<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
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
}
