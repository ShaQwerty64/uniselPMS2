<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Unisel Project Managment System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito';
            background: #ffffff;
        }
    </style>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <div class="container-fluid fixed-top p-4">
        <div class="col-12">
            <div class="d-flex justify-content-end">
            </div>
        </div>
    </div>

<div>
    <h1 class="text-center"><p><strong>WELCOME TO UNISEL PROJECT MANAGEMENT SYSTEM</strong></p></h1>
</div>
<div class="position-relative">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('pic/1-1024x576 - Copy.png')}}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{asset('pic/bcNew.png')}}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{asset('pic/canseleri2.png')}}" class="d-block w-100" alt="...">
        </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>



      <div class="position-absolute w-100 d-flex" style="top: 48%;">
        <div class="w-50"></div>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-success btn-lg mr-3"><h1 class="m-1 font-weight-bolder">Dashboard</h1></a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mr-3"> <h1 class="m-1 font-weight-bolder">Login</h1></a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-warning btn-lg mr-3"><h1 class="m-1 font-weight-bolder">Register</h1></a>
                @endif
            @endif
        @endif
        <div class="w-50"></div>
    </div>
</div>




</body>
</html>
