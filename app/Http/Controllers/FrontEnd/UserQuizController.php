<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
{
    public function index()
    {
        return view('frontend.pages.quiz',['title'=>'Quiz List - Hiring Portal']);
    }

    public function quiz($id)
    {
        if(!is_numeric($id)){
            return redirect()->back()->with(['error' => 'Undefined data!']);
        }
        $quiz = Quiz::where('id',$id)->first();
        if($quiz == false )
        {
            return redirect()->back()->with(['error' => 'Data not found!']);
        }
        if(count($quiz->questions) == 0)
        {
            return redirect()->back()->with(['error' => 'Something wrong']);
        }
        if(QuizSubmission::where('user_id',Auth::guard('user')->user()->id)->where('quiz_id',$id)->first())
        {
            return redirect('/user/dashboard')->with(['error' => 'You have already sumitted your answer!']);
        }
        return view('frontend.pages.quiz',['title'=> $quiz->title,'quiz'=>$quiz]);
    }

    public function quizSubmition(Request $request,$id)
    {
        if(!is_numeric($id)){
            return response()->json(array('error' => true,'check' => false, 'message' => 'Invalid id!'));
        }  
        $quiz = Quiz::where('id',$id)->first();
        if($quiz == false )
        {
            return response()->json(array('error' => true,'check' => false, 'message' => 'Data not found!'));
        }
        if(QuizSubmission::where('user_id',Auth::guard('user')->user()->id)->where('quiz_id',$id)->first())
        {
            return response()->json(array('error' => true,'check' => false, 'message' => 'You have already sumitted your answer!'));
        }
        $answers             = array();
        $total_mark          = 0;
        foreach($quiz->questions as $key=>$question)
        {
            $question_index_name =  'answer_'.$question->id;
            
            $options             = json_decode($question->options);

            $answers[$key]['answer']        = $options[$question->answer - 1];
            $answers[$key]['mark']          = 0;
            $answers[$key]['std_answer']    = '';
            if(isset($request->$question_index_name))
            {
                $answers[$key]['std_answer']    = $request->$question_index_name;
                if($question->answer == $request->$question_index_name)
                {
                    $answers[$key]['mark']          = 1;
                    $total_mark += 1;
                }
            }
        }
        $submission = new QuizSubmission();
        $submission->user_id        = Auth::guard('user')->user()->id;
        $submission->quiz_id        = $quiz->id;
        $submission->total_marks    = $total_mark;
        $submission->answers        = json_encode($answers);
        if($submission->save())
        {
            return response()->json(array('error' => false,'check' => false, 'message' => 'Successfully submit your answer.','url'=>route('score',$id))); 
        }
        return response()->json(array('error' => true,'check' => false, 'message' => 'Something wrong.Try again!')); 
    }

    public function score($id)
    {
        if(!is_numeric($id)){
            return redirect('/user/dashboard')->with(['error' => 'Undefined data!']);
        }
        $submission = QuizSubmission::where('user_id',Auth::guard('user')->user()->id)->where('quiz_id',$id)->first();
        if($submission == false )
        {
            return redirect('/user/dashboard')->with(['error' => 'Data not found!']);
        }
        $quiz = Quiz::where('id',$id)->first();
        $data['title']      = 'User Details';
        $data['submission'] = $submission;
        $data['quiz']       = $quiz;
        return view('frontend.pages.score',$data);
    }
}
