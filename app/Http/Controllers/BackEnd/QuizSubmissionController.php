<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizSubmissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $data = QuizSubmission::with('quiz')->latest();
            $datatables =  DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('title', function($row){
                        return $row->quiz->title;
                    })
                    ->editColumn('obtain_marks', function($row){
                        return $row->total_marks;
                    })
                    ->editColumn('total_marks', function($row){
                        return count($row->quiz->questions);
                    })
                    ->editColumn('submitted_by', function($row){
                        return $row->user->name;
                    });
                    $datatables = $datatables->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a target="_blank" href="'.route('admin.submissions.show',$row->id).'" class="btn btn-primary btn-sm m-1">Details</a>';
                        return $btn;
                    });
            return $datatables->rawColumns(['action','submitted_by','title','obtain_marks','total_marks'])
                    ->make(true);
        }
        return view('backend.submissions.index',['title'=>'Submission List']);
    }

    public function show($id)
    {
        if(!is_numeric($id)){
            return redirect()->back()->with(['error' => 'Undefined data!']);
        }
        $submission = QuizSubmission::where('id',$id)->first();
        if($submission == false )
        {
            return redirect()->back()->with(['error' => 'Data not found!']);
        }
        $data['title']     = $submission->quiz->title;
        $data['submission']      = $submission;
        return view('backend.submissions.show',$data);
    }
}
