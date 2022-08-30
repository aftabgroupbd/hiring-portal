<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post'))
        {
            
            $request->validate([
                'email'                 => 'required|email',
                'password'              => 'required|string|min:8',
            ]);

            $credentials = $request->only('email', 'password');

            if(Auth::guard('user')->attempt(['email'=>$request->email,'password'=>$request->password,'is_admin' => 0,'status' => 1])) {
                return redirect('/user/dashboard')->with(['success'=>'Successfully logged in.']);
            }
            return redirect("login")->with(['error'=>'Login details are not valid or your account status is pending!']);
        }
        return view('frontend.auth.login',['title'=>'Login - Hiring Portal']);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post'))
        {
            
            $request->validate([
                'name'                  => 'required',
                'phone'                 => 'required',
                'cv_link'               => 'required',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);

            $user = new User();
            $user->name         = $request->name;
            $user->phone        = $request->phone;
            $user->email        = $request->email;
            $user->cv_link      = $request->cv_link;
            $user->password     = Hash::make($request->password);

            if($user->save())
            {
                try {

                    Mail::send('emails.register', ['user' => $user], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('Register Mail');
                    });
                    return back()->with('success', 'Successfully registered. Your account status is pending! Please wait for your account to be approved.');
                  } catch (\Exception $e) {
    
                        return redirect('/register')->with(['error'=> $e->getMessage()]);
                  }
            }else{
                return redirect('/register')->with(['error'=> 'Something wrong!']);
            }
        }
        return view('frontend.auth.register',['title'=>'Register - Hiring Portal']);
    }
    // user session destroy
    public function logout()
    {
        Session::flush();
        Auth::guard('user')->logout();
        return redirect('/login');
    }
}
