@extends('backend.master')
@section('body')
<div class="row">
    <div class="col-md-12">
        <form>
            @csrf
            <div class="tile">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive text-center">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{$user->name}}</td>
                                        <th>Email:</th>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{$user->phone}}</td>
                                        <th>Cv Link:</th>
                                        <td><a href="{{$user->cv_link}}" target="_blank">Open</a></td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            @if($user->status == 1)
                                            <span class="text-success">Approved</span>
                                            @elseif ($user->status == 2)
                                            <span class="text-danger">Rejected</span>
                                            @else   
                                            <span class="text-warning">Pending</span>
                                            @endif
                                        </td>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
@endsection