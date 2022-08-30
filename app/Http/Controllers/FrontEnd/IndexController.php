<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('status',1)->paginate(10);
        return view('frontend.index',['title'=>'Hiring Portal','quizzes'=>$quizzes]);
    }
}
