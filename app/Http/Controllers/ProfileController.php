<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobSeekerData;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    
    public function index() {
        if(Gate::allows("is_a_recruiter")){
            return view("profile.recruiter-profile");
        }
        return view("profile.profile");
    }

    public function updateUserCVPOST(Request $request) {

        
        $validated = $request->validate([
            "cv_file" =>  "required|file|mimes:pdf|max:5024"
        ]);

        $file_origin_name = $validated["cv_file"]->getClientOriginalName();
        $file_mimetype = $validated["cv_file"]->getMimeType();
        $file_size = number_format($validated['cv_file']->getSize()/1048576, 2). "MB";
        
        $path = Storage::putFile('job-seeker-cv-doc', $validated['cv_file']);

        if(isset($path)){
            JobSeekerData::create([
                "name" => $file_origin_name,
                "size" => $file_size,
                "type" => $file_mimetype,
                "cv_path" => $path,
                "user_id" =>  Auth::user()->id
            ]);

            return redirect()->back()->with(["success", "Successfully upload your cv file document"]);
        }
        
        return redirect()->back()->with(["error", "Failed to upload your cv file document"]);
    }
    
    public function updateProfilePOST(Request $request, string $id){

        $validated = $request->validate([
            "name" => "required|min:5",
            "email" => ["required","min:5","email:rfc.dns", Rule::unique("users")->ignore($id)],
        ]);
        
        $updated_user_profile = $validated;
        $auth_user = Auth::user()->avatar_path;
        
        // if no image upadate skip
        if($request->file("profile_image") != null){

            // delete old image if there is an upadated
            if(isset($auth_user)){
                Storage::disk("public")->delete($auth_user);
            }

            // storage new image update to public disk
            // marge image path to user data array
            $path = Storage::disk("public")->putFile('avatars', $request->file('profile_image'));
            $updated_user_profile = array_merge($validated, ["avatar_path" => $path]);
        }

        // update all data to db
        User::where("id", $id)->update($updated_user_profile);

        // redirect 
        return Redirect::route("profile")->with("success", "Successfully updated users");
    }

    public function displayProfileCVPOST() 
    {
        if(Gate::allows("is_a_recruiter")){
            return redirect("/profile");
        }

        $data = JobSeekerData::where("user_id", Auth::user()->id)->first();

        $file_exist = Storage::exists($data->cv_path);

        if($data && $file_exist){
            return response()->file(Storage::path($data->cv_path));
        } else{
            return back()->with(["error", "there is an error with your cv document file"]);
        }
    }
}
