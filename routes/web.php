<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplyingJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', [JobListingController::class,"index"])->name("home");

Route::get("/detail/{id}", [JobListingController::class, "detailJob"])->name("detail");
Route::get("/company/{id}", [CompanyController::class, 'index'])->name("company");


Route::middleware("auth")->group(function() {

    Route::get("/application/{id?}", [ApplyingJobController::class, "myApplication"])->name("my-application");

    Route::put('/job/update/{id}',[JobListingController::class, "updateJob"]);
    
    Route::delete('/job/delete/{id}',[JobListingController::class, "deleteJob"]);
    
    Route::get("/profile", [ProfileController::class, "index"])->name("profile");
    Route::patch("/profile/update/{id}", [ProfileController::class, "updateProfilePOST"]);
    
    Route::post("/logout",[AuthController::class, "logout"]);

    Route::post("/profile/user/cv/upload", [ProfileController::class, "updateUserCVPOST"])->name("upload-user-cv");

    Route::post("/apply/cv/upload", [ApplyingJobController::class, "applyJobPOST"])->name("upload-user-cv-apply");

    Route::get("/profile/user/cv/show", [ProfileController::class, "displayProfileCVPOST"])->name("user-cv-file");

    // message method features
    Route::post("/send-message", [ApplyingJobController::class, "sendMessage"])->name("send-message");
    Route::post("/send-edited-message", [ApplyingJobController::class, "sendEditedMessage"])->name("send-edited-message");
    Route::post("/delete-message", [ApplyingJobController::class, "DeletedMessage"])->name("delete-message");

    Route::get("/job/message/{job_id}", [ApplyingJobController::class, "getMessage"]);

    Route::middleware("recruiter")->group(function() {  

        Route::get("/reported/jobs",[JobListingController::class, "reportedJobPosted"])->name("reported-job-posted");

        // create new job 
        Route::get("/job/create",[JobListingController::class, "createJob"])->name("new-job");
        Route::post('/job/create',[JobListingController::class, "createJobPOST"])->name("new-job-post");

        Route::get("/profile/company", [CompanyController::class, "recruiterCompanyProfile"])->name("company-profile-update");
        Route::post("/profile/company-verification/file", [CompanyController::class, "companyVerificationAddPOST"])->name("upload-company-verifiction-file");

        Route::patch("/company/update/{id}", [CompanyController::class, "updateCompanyProfilePOST"]);
        Route::get("/profile/company/verification", [CompanyController::class, "companyVerificationInfo"])->name("company-verification-info");
        
        Route::get("/profile/company/verification/document/show", [CompanyController::class, "getCompanyVerificationDocument"])->name("company-verification-file");
    });

    Route::prefix("admin")->group(function() { 
        Route::get("/", fn () => redirect("admin/company/document/verification"));
        Route::get("/category", [AdminController::class, "category"])->name("category");

        Route::post("/company/document/verification", [AdminController::class, "companyDocumentInReviewPOST"])->name("verification-in-review-post");
        Route::get("/company/document/verification", [AdminController::class, "companyDocumentInReview"])->name("verification-in-review");

        Route::post("/company/document/submission", [AdminController::class, "companyDocumentSubmissionPOST"])->name("verification-submission-post");
        Route::get("/company/document/submission", [AdminController::class, "companyDocumentSubmission"])->name("verification-submission");

        Route::get("/reported", [AdminController::class, "reportedJobs"])->name("reported-jobs");

        Route::get("/company/{id}", [AdminController::class, "companyDetail"])->name("company-detail");

        Route::get("/reported/job/{id}", [AdminController::class, "reportedJobDetail"])->name("reported-job-detail");

        Route::post("/company/document/status/in-review/{id}", [CompanyController::class, "updateCompanyVerificationPOST"])->name("update-status-in-review");
        
        // Applications 
        Route::name("user-jobs-applications.")->group(function () {
            Route::get("/application/jobs", [ApplyingJobController::class, "userJobsApplications"])->name("jobs");
            Route::get("/application/applicants/{job_id}/{application_id?}", [ApplyingJobController::class, "userApplications"])->name("applicants");
        });

    });
});


Route::middleware('guest')->group(function () {
    Route::get("/login", [AuthController::class,"login"])->name("login");
    Route::get("/register", [AuthController::class,"register"])->name("register");

    Route::post("/auth/register", [AuthController::class, "registerPOST"]);
    Route::post("/auth/login", [AuthController::class, "loginPOST"]);
    
    Route::post("/auth/recruiter-register",[AuthController::class, "recruiterRegisterPOST"]);
    Route::get("/recruiter-register",[AuthController::class, "recruiterRegister"]);
});


