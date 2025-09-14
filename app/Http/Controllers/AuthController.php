<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }

    public function register(){
        return view("auth.register");
    }

    public function recruiterRegister() {
        return view("auth.recruiter-register");
    }

    public function admin() {
        return view("auth.admin-login");
    }

    public function registerPOST(Request $request){

        $validated = $request->validate([
            "name" => "required|min:5",
            "email" => "required|min:5|email:rfc.dns|unique:users",
            "password" => "required|min:10|confirmed:repeat_password",
            "repeat_password" => "required|min:10"
        ]);

        User::create($validated);
        return redirect("/login")->with("success", "Successfully registered");
    }

    public function loginPOST(Request $request){
        $validated = $request->validate([
            "email" => "required|min:5|email:rfc.dns",
            "password" => "required|min:10",
        ]);

        if (Auth::attempt(['email' => $validated["email"], 'password' => $validated["password"]])) {
            return redirect("/")->with("success", "Successfully login!");
        }

        return redirect("/login")->with("error", "Failed to login!");
    }
    
    // Recruiter POST process
    public function recruiterRegisterPOST(Request $request){

        $validated_recruiter = $request->validate([
            "name" => "required|min:5",
            "email" => "required|min:5|email:rfc.dns|unique:users",
            "password" => "required|min:10|confirmed:repeat_password",
            "repeat_password" => "required|min:10",
        ]);

        $validated_company = $request->validate([
            "company_name" => "required|min:5",
            "company_email" => "required|min:5|email:rfc.dns|unique:users"
        ]);

        $company = Company::create([
            "name"=> $validated_company["company_name"],
            "email"=> $validated_company["company_email"],
        ]);
        
        User::create([...$validated_recruiter,"is_recruiter" => true, "company_id" => $company->id]);
        
        return redirect("/login")->with("success", "Successfully register as recruiter!");
    }

    public function adminLoginPOST(Request $request){
        $validated = $request->validate([
            "email" => "required|min:5|email:rfc.dns",
            "password" => "required|min:10",
        ]);

        if (Auth::guard('admin')->attempt(['email' => $validated["email"], 'password' => $validated["password"]])) {
            return redirect("/admin")->with("success", "Successfully admin login!");
        }

        dd($validated);
    }

    public function logout(Request $request){
        Auth::logout();

        return $this->sessionRemove($request);
    }

    public function adminLogout(Request $request) {
        Auth::guard("admin")->logout();

        return $this->sessionRemove($request);
    }

    private function sessionRemove($request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
