<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $data['users']      = User::where('is_admin',0)->count();
        $data['quizzes']    = Quiz::count();
        $data['finished']   = Quiz::where('status',2)->count();
        $data['active']     = Quiz::where('status',1)->count();
        $data['title']      = 'Dashboard - Hiring portal';
        return view('backend.index',$data);
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
                'name'                  => 'required',
                'username'              => 'unique:users,username',
                'phone'                 => 'required',
                'email'                 => 'unique:users,email',
                'password'              => 'string|min:8|confirmed',
            ]);
            $admin = Auth::guard('admin')->user();
            $admin->name           = $request->name;
            $admin->phone          = $request->phone;
            if($request->email != '')
            {
                $admin->email      = $request->email;
            }
            if($request->username != '')
            {
                $admin->username   = $request->username;
            }
            if (isset($request->password) && $request->password != '')
            {
                $admin->password    = Hash::make($request->password);
            }
            if($admin->update())
            {
                return redirect('/admin/profile')->with('success', 'Successfully Updated');
            }else{  
                return redirect('/admin/profile')->with('error', 'Updated failed!');
            }
        }
        return view('backend.profile',['title'=> 'Profile - Hiring Portal']);
    }
}
