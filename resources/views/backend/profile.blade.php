@extends('backend.master')
@section('body')
<div class="row">
    <div class="col-md-12">
        <form method="post" action="{{route('admin.profile')}}">
            @csrf
            <div class="tile">
                @if(Session::get('error'))
                <div class="alert alert-danger">
                {{Session::get('error')}}
                </div>
            @endif
            @if(Session::get('success'))
                <div class="alert alert-success">
                {{Session::get('success')}}
                </div>
            @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{auth()->guard('admin')->user()->name}}">
                            @error('name')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" id="username" name="username" type="text" placeholder="{{auth()->guard('admin')->user()->username}}">
                            @error('username')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="{{auth()->guard('admin')->user()->email}}">
                            @error('email')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control" id="phone" name="phone" type="text" value="{{auth()->guard('admin')->user()->phone}}">
                            @error('phone')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" type="password" placeholder="Enter password">
                            @error('password')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input class="form-control" id="confirm_password" type="confirm_password" placeholder="Enter confirm password">
                            @error('confirm_password')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="tile-footer text-right">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
  </div>
@endsection