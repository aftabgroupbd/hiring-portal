@extends('frontend.master')
@section('body')
<!-- Portfolio Grid-->
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center pt-5">
            <h2 class="section-heading text-uppercase">Login</h2>
        </div>
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
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
                    <div class="card-body">
                      <form method="post" action="{{route('login')}}" id="login_form">
                        @csrf
                        <div class="mb-3">
                          <label for="email" class="form-label">Email <span class="text-danger" title="This field is required">*<span></label>
                          <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="Enter Your Email" required />
                          @error('email')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password <span class="text-danger" title="This field is required">*<span></label>
                          <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" placeholder="Enter Your Pasword" required />
                          @error('password')
                                <small class="form-text  text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('extra_js')
<script>
    $("#login_form").on('submit', function() {
        let spinner = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...`;
        $("#submit_btn").html(spinner);
        $('#submit_btn').prop('disabled', true);
    });
    </script>
@endsection