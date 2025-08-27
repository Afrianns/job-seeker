<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyLink;
use App\Models\CompanyVerification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index(string $id) {
        $company = Company::with("jobs")->where("id", $id)->first();
        return view("company", compact("company"));
    }

    public function companyVerificationInfo(){
        if(!Gate::allows("is_a_recruiter")){
            return redirect("/profile");
        }
        $company = Company::where("id", Auth::user()->company_id)->first();
        return view("profile.company-verifiction",compact("company"));
    }

    
    public function companyVerificationAddPOST(Request $request){
        
        $validated = $request->validate([
            "file_approval" => "required|file|mimes:pdf|max:5024"
        ]);

        $file_origin_name = $request->file("file_approval")->getClientOriginalName();
        $file_mimetype = $request->file("file_approval")->getMimeType();
        $file_size = number_format($request->file('file_approval')->getSize()/1048576, 2). "MB";
        
        $path = Storage::putFile('companies-verification-doc', $validated['file_approval']);

        if(isset($path)){
            $result = CompanyVerification::create([
                "name" => $file_origin_name,
                "size" => $file_size,
                "type" => $file_mimetype,
                "document_path" => $path,
                "company_id" =>  Auth::user()->company_id
            ]);

            return redirect()->back()->with(["success", "Successfully upload your company document"]);
            // dd($result,$file_mimetype,$file_origin_name, $file_size, $path);
        }
        
        return redirect()->back()->with(["error", "Failed to upload your company document"]);
       
    }
    
    public function getCompanyVerificationDocument(){
        if(!Gate::allows("is_a_recruiter")){
            return redirect("/profile");
        }

        $verification = CompanyVerification::where("company_id", Auth::user()->company_id)->first();

        $file_exist = Storage::exists($verification->document_path);

        if($verification && $file_exist){
            return response()->file(Storage::path($verification->document_path));
        } else{
            return redirect("/profile/company-verification")->with(["error", "there is an error with your company document file"]);
        }
    }

    public function recruiterCompanyProfile() {
        
        if(!Gate::allows("is_a_recruiter")){
            return redirect("/profile");
        } 

        $company = Company::where("id", Auth::user()->company_id)->first();

        $links = [
            "facebook_link" => null,
            "instagram_link" => null,
            "twitter_link" => null,
            "website_link" => null
        ];
        
        if($company->link){
            $exist_links = $company->link;
            $links = [
                "facebook_link" => $exist_links->facebook_link,
                "instagram_link" => $exist_links->instagram_link,
                "twitter_link" => $exist_links->twitter_link,
                "website_link" => $exist_links->website_link
            ];
        }

        return view("profile.company", ["company" => $company,"links" => $links]);
    }


    public function updateCompanyProfilePOST(Request $request, string $id){
     
        $validated_company = $request->validate([
            "company_name" => "required|min:5",
            "company_email" => ["required","min:5","email:rfc.dns", Rule::unique("users")->ignore($id)],
            "company_description" => "nullable|min:20",
            "company_logo" => "file|mimes:jpg,jpeg,png|max:5000",
            "facebook_company_link" => ["nullable",'regex:/[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/'],
            "instagram_company_link" => ["nullable",'regex:/[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/'],
            "twitter_company_link" => ["nullable",'regex:/[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/'],
            "website_company_link" => ["nullable",'regex:/[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/'],

        ]);

    
        // mapped request so it match with db structure
        // only for required data
        
        $updated_company_profile = [
            "name" => $validated_company["company_name"],
            "email" => $validated_company["company_email"],
        ];

        
        if(isset($validated_company["facebook_company_link"]) || isset($validated_company["instagram_company_link"]) || isset($validated_company["twitter_company_link"]) || isset($validated_company["website_company_link"])){
            
            $company_links = CompanyLink::upsert([
                [
                    "facebook_link" => $validated_company["facebook_company_link"],
                    "instagram_link" => $validated_company["instagram_company_link"],
                    "twitter_link" => $validated_company["twitter_company_link"],
                    "website_link" => $validated_company["website_company_link"],
                    "company_id" => $id
                ]
            ], ["company_id"], ["facebook_link","instagram_link","twitter_link","website_link"]);
        }

        // if logo image exist update the logo
        if(isset($validated_company["company_logo"])){

            $current_company_data = Company::where("id", $id)->first();
            
            // delete old image if there is an upadated
            if(isset($current_company_data)){
                Storage::disk("public")->delete($current_company_data->logo_path);
            }
        
            // storage new image update to public disk
            // marge image path to user data array
            $path = Storage::disk("public")->putFile('companies_logo', $validated_company["company_logo"]);
            $updated_company_profile = [...$updated_company_profile, "logo_path" => $path];
            
        }


        // if company desc exist then marge to $update_company_profile
        if(isset($validated_company["company_description"])){
            $updated_company_profile = [...$updated_company_profile, 'description' => $validated_company["company_description"]];
        }

        // update all data to db
        Company::where("id", $id)->update($updated_company_profile);

        // redirect 
        return Redirect::route("company-profile-update")->with("success", "Successfully updated company");
    }

    public function updateCompanyVerificationPOST(string $id) {
        dd($id);
    }
}
