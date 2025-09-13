<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyVerification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Submission Page 
    public function companyDocumentSubmission() {
        $companies_document = Company::with("verification")->whereHas("verification", fn ($q) => $q->where("status", "waiting"))->get();
        return view("admin.company-verification-submission", compact('companies_document'));
    }

    // Submission Page Post
    public function companyDocumentSubmissionPOST(Request $request) {
        $validated = $request->validate([
            "id" => "required",
            "type" => ["required", Rule::in("review")]
        ]);

        $res = CompanyVerification::where("company_id", $validated['id'])->update([
            "status" => "under-review"
        ]);

        if($res){
            return redirect()->back();
        }
    }

    public function category() {    
        $tags = Tag::paginate(3);
        return view("admin.category", compact("tags"));
    }

    public function companyDocumentInReview() {
        $companies_document = Company::with("verification")->whereHas("verification", fn ($q) => $q->where("status", "in-review"))->get();
        return view("admin.company-verification-in-review", compact('companies_document'));
    }

    public function companyDocumentInReviewPOST(Request $request){

        $validated = $request->validate([
            "id" => "required",
            "type" => ["required", Rule::in(["rejected", "approved"])]
        ]);

        // $res = Company::where("id", $validated['id'])->first();

        $res = CompanyVerification::where("company_id", $validated["id"])->update([
            "status" => $validated["type"]
        ]);

        if($res){
            return redirect("/");
        }
        dd($validated, $res);
    }

    public function companyDetail(string $id) {
        if(isset($id)){
            $company = Company::with(["verification", "link"])->where("id", $id)->first();
            return view("admin.components.company-detail", compact('company'));
        }
    }

    // tag/category created by related company
    public function deleteCategoryPOST(Request $request) {

        $validated = $request->validate([
            "id" => "required",
        ]);

        $res = Tag::where("id", $validated["id"])->delete();

        if($res >= 1){
            return redirect()->to("/admin/category");
        }
    }

    public function reportedJobs() {
        return view("admin.reported-job");
    }

    public function reportedJobDetail(string $id) {
        return view("admin.components.reported-job-detail");
    }
}
