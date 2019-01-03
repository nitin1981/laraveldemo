<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | Merrchant</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ruda:400,700,900">
    <meta name="robots" content="index, follow" />
    <link rel="publisher" href="https://plus.google.com/103645854063547939782" />
    <link rel="author" href="https://plus.google.com/103645854063547939782"/>
    <meta name="p:domain_verify" content="c4d6898bb6114a2980c4657d7c1b7a32"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->    
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="{{ asset('public/homeasset/css/bootstrap.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('public/homeasset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/AdminLTE.css') }}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111453649-1"></script>
    <link rel="stylesheet" href="{{ asset('public/bootstrap/css/font-awesome.min.css') }}">
</head>
<body>
<!--container-->       
<div class="container homapage-center-div" style="margin-top: 5%;margin-bottom: 5%" >
    <div class=" ">
        <div class="col-md-12" style="text-align: center;">
            <div class="col-md-12 center">
                <img class="logo-hover" src="https://www.merrchant.com/public/homeasset/img/Merrchant_iconH.png" style="width: 62px;"><img class="logo" src="https://www.merrchant.com/public/homeasset/img/Merrchant_LogoH.png" style="width: 250px">
            </div>
            <div style="text-align: center;" class="col-md-12">
                <h2>Sorry, something went wrong</h2>
                <h5><a href="{{url('home')}}">Go Back</a> and try again.</h5>

            </div>
        </div>
    </div>
</div>        
   @include('layouts.includes.footer')
        <!--/footer-->
        <!-- jquery min js -->
        <script src="{{ asset('public/homeasset/js/jquery.min.js') }}"></script>
        <!-- bootstrap js -->
        <script src="{{ asset('public/homeasset/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
            $(".sub_tab li").click(function(e){
                var thisId = $(this).attr("id");
                $(".sub_tab li").removeClass("active");
                $(this).addClass("active");
                $(".sub_info_both").hide();
                $("."+thisId).show();
            })
        </script>
  </body>
</html>