<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // admin login page view 
    public function index()
    {
        return view('backend.login',['title'=>'Login - Hiring Portal']);
    }

    //admin input authentication
    public function Auth(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email_or_username' => 'required|max:120|min:6',
            'password'          => 'required|max:20|min:8'
        ]);

        if($validator->passes())
        {
            $email_or_username = '';
            if (filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL)) {
                $user      = User::where('email',$request->email_or_username)->where('is_admin',1)->first();
                $email_or_username = 'email';
            }else{
                $user      = User::where('username',$request->email_or_username)->where('is_admin',1)->first();
                $email_or_username = 'username';
            }
            if($user != false){
                if($user->status == 1)
                {
                    if (Auth::guard('admin')->attempt(['email' => $user->email, 'password' => $request->password,'is_admin'=>1])) {
                        return response()->json(array('error' => false,'check' => false, 'message' => 'Successfully logged in.','url'=> route('admin.dashboard') )); 
                    }
                    return response()->json(array('error' => true,'check' => true, 'message' => array('password' => 'Invalid Password!')));
                }else{
                    return response()->json(array('error' => true,'check' => false, 'message' => 'Your Account Is Deactivated. Please Contact With your Admin!'));
                }
            }else{
                return response()->json(array('error' => true,'check' => true, 'message' => array('email_or_username' => 'Invalid '.$email_or_username.'!')));
            }
        }else{
            return response()->json(array('error' => true,'check' => true, 'message' => $validator->errors()->getMessages()));
        }
    }

    public function forget(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);

            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );
      
            
            try {

                Mail::send('emails.reset-link', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password Notification');
                });
                return back()->with('success', 'We have e-mailed your password reset link!');
              } catch (\Exception $e) {

                    return redirect('/admin/forget-password')->with(['error'=> $e->getMessage()]);
              }
              return redirect('/admin/forget-password')->with(['error'=>'Something wrong! contact to admin.']);
        }
        return view('backend.forgot',['title'=>'Forgot Password - Hiring Portal']);
    }

    public function reset($token)
    {
        return view('backend.password-reset',['token'=>$token,'title'=>'Password Reset']);
    }

    public function ChangePassword(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
                'email'                 => 'required|email|exists:users',
                'password'              => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);
          
            $get_reset_data = DB::table('password_resets')
                                ->where(['email' => $request->email, 'token' => $request->token])
                                ->first();
            if(!$get_reset_data)
                return back()->withInput()->with('error', 'Invalid token!');
          
              $user = User::where('email', $request->email)
                          ->update(['password' => Hash::make($request->password)]);
          
              DB::table('password_resets')->where(['email'=> $request->email])->delete();
          
              return redirect('/admin')->with('success', 'Your password has been changed!');
          
        }
    }
    // admin session destroy
    public function logout()
    {
        Session::flush();
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
