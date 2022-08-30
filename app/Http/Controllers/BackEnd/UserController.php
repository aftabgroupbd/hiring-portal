<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $data = User::latest();
            $datatables =  DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == 1)
                        {
                            return $status = '<span class="text-success">Approved</span>';
                        }elseif($row->status == 2)
                        {
                            return $status = '<span class="text-danger">Rejected</span>';
                        }else{
                            return $status = '<span class="text-warning">Pending</span>';
                        }
                    });
                    $datatables = $datatables->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="'.route('users.edit',$row->id).'" class="btn btn-primary btn-sm m-1">Edit</a>';
                        $btn .= '<a href="#" onClick="delete_content('.$row->id.')" class="btn btn-danger btn-sm m-1">Delete</a>';
                        $btn .= '<a href="'.route('users.show',$row->id).'" target="_blank" class="btn btn-warning btn-sm m-1">Details</a>';
                        return $btn;
                    });
            return $datatables->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('backend.users.index',['title'=>'User List']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)){
            return redirect()->back()->with(['error' => 'Undefined data!']);
        }
        $user = User::where('id',$id)->first();
        if($user == false )
        {
            return redirect()->back()->with(['error' => 'Data not found!']);
        }
        $data['title']     = 'User Details';
        $data['user']      = $user;
        return view('backend.users.show',$data);
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
        $user = User::where('id',$id)->first();
        if($user == false )
        {
            return redirect()->back()->with(['error' => 'Data not found!']);
        }
        $data['title']     = 'Edit User';
        $data['user']      = $user;
        return view('backend.users.edit',$data);
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
            return redirect()->back()->with(['error' => 'Undefined data!']);
        }  
        $user = User::where('id',$id)->first();
        if($user == false )
        {
            return redirect()->back()->with(['error' => 'Data not found!']);
        }

        $request->validate([
            'email'         => 'unique:users,email',
            'name'          => 'required',
            'phone'         => 'required',
            'cv_link'       => 'required',
            'status'        => 'required|numeric',
        ]);

        if($request->email != '')
        {
            $user->email        = $request->email;
        }
        $user->name             = $request->name;
        $user->phone            = $request->phone;
        $user->cv_link          = $request->cv_link;
        $user->status           = $request->status;
        if($user->update())
        {
            $status = 'Pending';
            if($user->status == 1)
            {
                $status = 'Approved';
            }
            if($user->status == 2)
            {
                $status = 'Rejected';
            }
            try {

                Mail::send('emails.update-user', ['status' => $status], function($message) use($user){
                    $message->to($user->email);
                    $message->subject('Update Your Account');
                });
            } catch (\Exception $e) {

                return redirect('/admin/forget-password')->with(['error'=> 'Successfully Updated.But Send Mail error message is '.$e->getMessage()]);
            }
            return redirect()->back()->with(['success' => 'Successfully Updated']);
        }else{ 
            return redirect()->back()->with(['success' => 'Updated failed!']);
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
        $user = User::where('id',$id)->where('is_admin',0)->first();
        if($user != false){
            if($user->delete())
            {
                return response()->json(array('error' => false,'check' => false, 'message' => 'Successfully Deleted.'));
            }else{
                return response()->json(array('error' => true,'check' => false, 'message' => 'Delete failed!'));
            }
        }else{
            return response()->json(array('error' => true,'check' => false, 'message' => 'Data not found!'));
        }
    }
}
