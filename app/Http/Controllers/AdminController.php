<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyVerification;
use App\Models\MessageToRecruiter;
use App\Models\Report;
use App\Models\ReportMessage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        $reports = Report::withCount("reportMessage")->get();
        $total_report = ReportMessage::count();
        return view("admin.reported-job", compact("reports"), compact("total_report"));
    }

    public function listReportMessage(string $id) {
        
        $report = Report::with("reportMessage.user")->where("id", $id)->first();
        return view("admin.list-report", compact("report"));
    }

    public function messageToRecruiter(Request $request) {

        $validated = $request->validate([
            "report_id" => "required|exists:reports,id",
            "type" => ["required", Rule::in("warning", "info")],
            "message" => "required|min:5",
        ]);

        $result = MessageToRecruiter::create([
            "report_id" => $validated["report_id"],
            "type" => $validated["type"],
            "message" => $validated["message"],
        ]);

        if($result){
            return redirect()->back();
        }
    }   

    public function adminReportResolved(Request $request){
        $validated = $request->validate([
            "report_id" => "required|exists:reports,id",
        ]);

        $update_result = Report::where("id", $validated["report_id"])->update([
            "is_resolved_by_recruiter" => false
        ]);
        
        if($update_result){
            $delete_result = ReportMessage::where("report_id", $validated["report_id"])->delete();
            $delete_result_recruiter = MessageToRecruiter::where("report_id", $validated["report_id"])->delete();

            if($delete_result && $delete_result_recruiter){
                return Redirect::route("reported-jobs");
            }
        }
    }

    public function reportedJobDetail(string $id) {
        return view("admin.components.reported-job-detail");
    }
}


