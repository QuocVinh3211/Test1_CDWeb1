<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flights - Worldskills Travel</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/bootstrap/css/bootstrap.css')}}">
  
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/style.css')}}">

    <style>
        .invalid-feedback {
            color: red;
        }
    </style>


    <script type="text/javascript">

// ẩn hiện 1 thẻ html
function myFunction() {
    document.getElementById("hide").style.display = document.getElementById("hide").style.display = "block";
}
function myFunction1() {
    document.getElementById("hide").style.display = document.getElementById("hide").style.display = "none";
}

// validate
 function validateForm() {
    //& validateTime()
        if (validateCity() & validateTime()) {
            return true;
        }
        else {
            return false;
        }
    }

function validateCity() {
        var form = $('#from').val();
        var to = $('#to').val();

        if(form == to)
        {
          alert("Điểm khởi hành phải khác điểm đến, xin chọn lại!");         
          return false;
        }
        else
        {
            return true;
        }          
    }
    //departure
    function validateTime() {
        var time_departure = $('#departure').val();
        var time_return = $('#return').val();

        var re = new Date(time_return);

        var date = new Date(time_departure);
        var d = new Date();

        // lấy ngày, tháng năm để so sánh ( lấy từ 0 - 30 đối với ngày...)
        if(date.getDate() < d.getDate() || date.getMonth() < d.getMonth() || date.getFullYear() < d.getFullYear())
        {
            alert("Ngày khởi hành phải lớn hơn hoặc bằng ngày hiện tại, xin chọn lại!");           
            return false;
        }
        else if(re.getDate() < d.getDate() || re.getMonth() < d.getMonth() || re.getFullYear() < d.getFullYear())
        {
            alert("Ngày khứ hồi phải lớn hơn hoặc bằng ngày hiện tại, xin chọn lại!");           
            return false;
        }
        else
        {                            
            return true;
        }          
    }
</script>
   
</head>
<body>
<div class="wrapper">
    <header>
        <nav class="navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{{ route('home') }}" class="navbar-brand">Worldskills Travel</a>
                </div>
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav navbar-right">
                         <!-- Authentication Links -->
                        
                         @guest
                         <li><a href="">Welcom message</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Welcome {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <li><a href="{{ url('/') }}">Flights</a></li>
                       <?php
                            if(Auth::check())
                            {                            
                        ?>
                            <li><a href="{{ url('getEdit') }}">Profile</a></li>
                            <?php } ?>
                       
                    </ul>
                </div>
            </div>
        </nav>
    </header>