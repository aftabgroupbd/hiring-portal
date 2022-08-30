<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{$title}}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{asset('assets/frontend/favicon.ico')}}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('assets/frontend/css/styles.css')}}" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        @include('frontend.layouts.navbar')

        @yield('body')

        <!-- Footer-->
        @include('frontend.layouts.footer')

        <!-- start js --> 
        <script src="{{asset('assets/backend/js/jquery-3.3.1.min.js')}}"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('assets/frontend/js/scripts.js')}}"></script>
        @yield('extra_js')
        <script>
            const Logout = (e) => {
                    if(confirm("Are you sure you want to logout?")){
                        var url = '{{route('user.logout')}}';
                        window.location = url;
                    }
                }
        </script>
    </body>
</html>
