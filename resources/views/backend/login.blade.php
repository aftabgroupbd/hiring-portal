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
        <form class="login-form" method="post" id="login_form" action="{{route('admin.login')}}">
            @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
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
            <label class="control-label">EMAIL OR USERNAME</label>
            <input class="form-control" type="text" placeholder="Enter Email OR Username" autofocus name="email_or_username" />
            <small class="text-danger error_email_or_username"></small>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" placeholder="Enter Password" name="password" />
            <small class="text-danger error_password"></small>
          </div>
          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="{{route('admin.forget.password')}}">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button type="submit" id="submit_btn" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('assets/backend/js/jquery-3.3.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
        $("#login_form").on('submit', function(e) {
            e.preventDefault();
            let spinner = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...`;
            $("#submit_btn").html(spinner);
            $('#submit_btn').prop('disabled', true);
            $("#login_form small").html('');
            $.ajax({
                method: "POST",
                url: $(this).prop('action'),
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data)
                {
                    $('#submit_btn').html('<i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN');
                    $("#login_form small").html('');
                    if (data.error == true) {
                        if(data.check ==  true)
                        {
                            $.each(data.message, function( key, value ) {
                                $(".error_"+key).html(value);
                            });
                        }else{
                            swal({
                                text: data.message,
                                icon: "error",
                            });
                        }
                    }else{
                        swal({
                            text: data.message,
                            icon: "success",
                        });
                        window.location = "{{route('admin.dashboard')}}";
                    }
                    $('#submit_btn').prop('disabled', false);
                }
            });
        });
    </script>
  </body>
</html>