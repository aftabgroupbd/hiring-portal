<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('status',1)->paginate(10);
        return view('frontend.pages.dashboard',['title'=>'Dashboard - Hiring Portal','quizzes'=>$quizzes]);
    }
}
