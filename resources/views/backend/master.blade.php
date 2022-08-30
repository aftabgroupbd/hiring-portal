<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/backend/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('extra_css')
  </head>
  <body class="app sidebar-mini">

    <!-- Navbar-->
    @include('backend.layouts.header')
    <!-- Sidebar menu-->

    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>

    @include('backend.layouts.sidebar')

    <main class="app-content">
      @yield('body')
    </main>


    <!-- Essential javascripts for application to work-->
    <script src="{{asset('assets/backend/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{asset('assets/backend/js/plugins/pace.min.js')}}"></script>
    <script>
        const logout = (e) => {
                if(confirm("Are you sure you want to logout?")){
                    var url = '{{route('admin.logout')}}';
                    window.location = url;
                }
            }
    </script>
    @yield('extra_js')
  </body>
</html>