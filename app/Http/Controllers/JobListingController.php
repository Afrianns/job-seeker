<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class JobListingController extends Controller
{
    public function index() {
        $jobs = JobListing::with(["company","company.verification", "application" => function ($q) {
                    if(Auth::check()){
                        $q->where("user_id", Auth::user()->id);
                    }
                }])->get();

        return view("home", ["jobs" => $jobs]);
    }
    public function createJob() {
        $tags_mapped = Arr::map(Tag::get()->toArray(), function(array $tag){
            return $tag['name'];
        });
        return view("new-job",["tags" => $tags_mapped]);
    }

    public function createJobPOST(Request $request) {
        
        $total_tags = [];

        $validated = $request->validate([
            "title" => "required|min:5",
            "description" => "required|min:25"
        ]);

        $auth_user = Auth::user();

        if(!$auth_user->is_recruiter){
            return Redirect::route("home")->with("error", "you aren't allowed to post a job");
        }

        $validated = [...$validated, "company_id" => $auth_user->company->id];

        // check if tags exist (tags are not required)

        // separate input tag not yet in db (then store it in db) and already in db
        // then join them in single array $total_tags
        
        if($request->get("tags") != null){
            $splitted_tag = $this->getAlreadyExistTagFromDB($request->get("tags"));   

            $total_tags = array_merge($splitted_tag[0], $this->getNewlyTagToDB($splitted_tag[1]));
        }
        
        $job = JobListing::create($validated);
    
        // if job id exist and $total_tags not empty then store it into jobTag model db
        if($job->id && count($total_tags) >= 1){

            $job_tag = Arr::map($total_tags, function (string $tag) use ($job) {
                return ["tag_id" => $tag, "job_listing_id" => $job->id];
            });

            JobTag::upsert($job_tag, ["id"], ["tag_id", "job_listing_id"]);
        }

        return Redirect::route("home")->with("success", "Successfully created job");
    }


    public function detailJob(string $id) {
        if(isset($id)){
            $job = JobListing::with(["company","company.verification", "application" => function ($q) {
                if(Auth::check()){
                    return $q->where("user_id", Auth::user()->id);
                }
            }])->where("id", $id)->first();
            
            $tags_mapped = Arr::map(Tag::get()->toArray(), function(array $tag){
                return $tag['name'];
            });

            // $current_user_application = Arr::map($job->application->toArray(), function($a){
            //     dump($a["user_id"]);
            // });

            // dd($current_user_application);

            return view("detail", ["job" => $job, "tags" => $tags_mapped]);
        }
    }

    public function updateJob(Request $request, string $id) {


        $newly_tag_by_user = [];
        $tag_already_exist_in_db = [];

        $tags = [];
        
        if(isset($id)){

            if($request->get("tags") != null){

                $splitted_tag = $this->getAlreadyExistTagFromDB($request->get("tags"));
                
                $tag_already_exist_in_db = $splitted_tag[0];
                $newly_tag_by_user = $splitted_tag[1];

                $tags = Arr::map(array_merge($tag_already_exist_in_db, $newly_tag_by_user), function (string $tag) use ($id) {
                    return ["tag_id" => $tag, "job_listing_id" => $id];
                });
                
            }
            
            
            $job_tags = JobTag::where("job_listing_id", $id);
           
            // delete job tag that relate to id
            if($job_tags->count() >= 1){
                $job_tags->delete();
            }

            // add job tag to DB if user input tag
            if(count($tags) >= 1){
                JobTag::upsert($tags, ["id"], ["tag_id", "job_listing_id"]);
            }

            $validated = $request->validate([
                "title" => "required|min:5",
                "description" => "required|min:25"
            ]);

            JobListing::where("id", $id)->update($validated);

            return redirect("/detail/{$id}")->with("success", "Successfully updated job");
        } else{
            return redirect("/detail/{$id}")->with("error", "Failed to delete job");
        }
    }

    public function deleteJob(string $id) {
        if(isset($id)){
            JobListing::where("id", $id)->delete();
            return Redirect::route("home")->with("success", "Successfully deleted job");
        }
    }


    // Separate/split between tag that already exist in DB and not
    private function getAlreadyExistTagFromDB($tags) {
        $all_db_tag = Tag::all();

        $tag_in_db = [];
        $newly_tag = [];

        foreach (json_decode($tags, true) as $input_value) {
            $is_exist = false;

            foreach ($all_db_tag as $db_value) {
                if(strtolower($input_value["value"]) == strtolower($db_value->name)){
                    $tag_in_db[] = $db_value->id;
                    $is_exist = true;
                }
            }
            
            if(!$is_exist){
                $newly_tag[] = $input_value["value"];
            }
        }

        return [$tag_in_db, $newly_tag];
    }
    
    // store all newly tags didnt exist in db and get all those tags id
    private function getNewlyTagToDB($newly_tag_by_user){
        $newly_tag_by_user_mapped = Arr::map($newly_tag_by_user, function (string $value) {
            return ["name" => $value];
        });
        
        Tag::upsert($newly_tag_by_user_mapped, ['id'], ['name']);

        $tag = Tag::whereIn("name", $newly_tag_by_user)->get();

        return $tag->map(function (object $value) {
            return $value->id;
        })->all(); 
    }

    
    public function reportedJobPosted() {
        if(!Gate::allows("is_a_recruiter")){
            return Redirect::route("home");
        }
        $jobs = JobListing::all();
        return view("reported-jobs", compact("jobs"));
    }
}
