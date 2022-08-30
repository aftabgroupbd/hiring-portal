<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuizController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Quiz::latest();
            $datatables =  DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('questions', function($row){
                        return count($row->questions);
                    })
                    ->editColumn('created_by', function($row){
                        return $row->user->name;
                    })
                    ->editColumn('status', function($row){
                        if($row->status == 1)
                        {
                            return $status = '<span class="text-warning">Active</span>';
                        }elseif($row->status == 2)
                        {
                            return $status = '<span class="text-success">Finished</span>';
                        }else{
                            return $status = '<span class="text-danger">Deactive</span>';
                        }
                    });
                    $datatables = $datatables->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="'.route('admin.quizes.edit',$row->id).'" class="btn btn-primary btn-sm m-1">Edit</a>';
                        $btn .= '<a href="#" onClick="delete_content('.$row->id.')" class="btn btn-danger btn-sm m-1">Delete</a>';
                        return $btn;
                    });
            return $datatables->rawColumns(['action','status','questions','created_by'])
                    ->make(true);
        }
        return view('backend.quizes.index',['title'=>'Quiz List']);
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.quizes.create',['title'=>'Create Quiz']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'           => 'required',
            'status'          => 'required|numeric',
            'quiz'            => 'required|array'
        ]);
        if($validator->passes())
        {
            $quiz = new Quiz();
            $quiz->title        = $request->title;
            $quiz->description  = $request->description;
            $quiz->user_id      = Auth::guard('admin')->user()->id;
            $quiz->status       = $request->status;
            if($quiz->save())
            {
                $records   = [];
                $questions = $request->quiz;
                foreach($questions as $key=>$item)
                {
                    $answer = isset($item['answer']) ? $item['answer'] : '';
                    if($item['question'] != '' && $item['option'] != '' && $answer != '')
                    {
                        $records[$key]['question']  = $item['question'];
                        $records[$key]['options']   = json_encode($item['option']);
                        $records[$key]['answer']    = $answer;
                        $records[$key]['quiz_id']   = $quiz->id;
                    }
                }
                if(count($records) > 0)
                {
                    Question::insertOrIgnore($records);
                }
                return response()->json(array('error' => false,'check' => false, 'message' => 'Successfully saved.')); 
            }
            return response()->json(array('error' => true,'check' => false, 'message' => 'Quiz saved failed!'));
        }else{
            return response()->json(array('error' => true,'check' => true, 'message' => $validator->errors()->getMessages()));
        }    
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!is_numeric($id)){
            return redirect()->back()->with(['error' => 'Undefined data!']);
        }
        $quiz = Quiz::where('id',$id)->first();
        if($quiz == false )
        {
            return redirect()->back()->with(['error' => 'Data not found!']);
        }
        $data['title']     = 'Edit Quiz';
        $data['quiz']      = $quiz;
        return view('backend.quizes.edit',$data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!is_numeric($id)){
            return response()->json(array('error' => true,'check' => false, 'message' => 'Invalid id!'));
        }  
        $quiz = Quiz::where('id',$id)->first();
        if($quiz == false )
        {
            return response()->json(array('error' => true,'check' => false, 'message' => 'Data not found!'));
        }
        $validator = Validator::make($request->all(),[
            'title'           => 'required',
            'status'          => 'required|numeric',
            'quiz'            => 'required|array'
        ]);
        if($validator->passes())
        {
            $quiz->title        = $request->title;
            $quiz->description  = $request->description;
            $quiz->status       = $request->status;
            $quiz->update();
            if (isset($request->question_id)) {
                if(count($request->question_id) > 0)
                {
                    Question::where('quiz_id',$quiz->id)->whereNotIn('id',$request->question_id)->delete();
                }
            }
            foreach($request->quiz as $key=>$quiz_data)
            {
                $question_id    = isset($quiz_data['id'])  ? $quiz_data['id'] : '';
                $answer         = isset($quiz_data['answer']) ? $quiz_data['answer'] : '';
                if($question_id)
                {
                    $ex_question = Question::where('quiz_id',$quiz->id)->where('id',$quiz_data['id'])->first();
                    if($ex_question != false)
                    {
                        $ex_question->question  = $quiz_data['question'];
                        $ex_question->options   = json_encode($quiz_data['option']);
                        $ex_question->answer    = $answer;
                        $ex_question->quiz_id   = $quiz->id;
                        $ex_question->update();
                    }
                }else{
                    
                    if($quiz_data['question'] != '' && $quiz_data['option'] != '' && $answer != '')
                    {
                        $question = new Question();
                        $question->question  = $quiz_data['question'];
                        $question->options   = json_encode($quiz_data['option']);
                        $question->answer    = $answer;
                        $question->quiz_id   = $quiz->id;
                        $question->save();
                    }
                }
            }
            return response()->json(array('error' => false,'check' => false, 'message' => 'Successfully updated.')); 
        }else{
            return response()->json(array('error' => true,'check' => true, 'message' => $validator->errors()->getMessages()));
        }   
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!is_numeric($id)){
            return response()->json(array('error' => true,'check' => false, 'message' => 'Invalid id!'));
        }  
        $quiz =     Quiz::where('id',$id)->first();
        if($quiz != false){
            if($quiz->delete())
            {
                Question::where('quiz_id',$id)->delete();
                return response()->json(array('error' => false,'check' => false, 'message' => 'Successfully Deleted.'));
            }else{
                return response()->json(array('error' => true,'check' => false, 'message' => 'Delete failed!'));
            }
        }else{
            return response()->json(array('error' => true,'check' => false, 'message' => 'Data not found!'));
        }
    }
}
