<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>{{$title}}</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Hiring Portal</h1>
      </div>
      <div class="login-box">
        <form class="forget-form" method="post" action="{{route('admin.forget.password')}}">
            @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
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
            <div class="form-group">
              <label class="control-label">EMAIL</label>
              <input class="form-control" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Enter Email">
              @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group btn-container">
              <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
            </div>
            <div class="form-group mt-3">
              <p class="semibold-text mb-0"><a href="{{route('admin.login')}}"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
            </div>
        </form>
      </div>
    </section>
  </body>
</html>