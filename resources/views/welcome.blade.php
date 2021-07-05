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
    <div class="container-fluid fixed-top p-4">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                @if (Route::has('login'))
                    <div class="">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-muted"><h2 class="text"><p><strong>Dashboard </strong></p></h2></a>
                        @else
                            <a href="{{ route('login') }}" class="text-muted"><h2 class="text-info"><p><strong>Login </strong></p></h2></a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-muted"><h2 class="text-danger"><p><strong>Register </strong></p></h2></a>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

<div>
    <h1 class="text-center"><p><strong>WELLCOME TO UNISEL PROJECT MANAGEMENT SYSTEM</strong></p></h1>
</div>
<div>
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
          <img src="https://www.unisel.edu.my/wp-content/uploads/2020/11/1-1024x576.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3ytI8UmfvuN-9uYL4R84kw-TNm_pocJY19K9wu_yo3G-3ZAWrtM6lsxGslTAiEI90gX4&usqp=CAU" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="https://kualaselangor.selangor.gov.my/kualaselangor/resources/File%20upload/umum/unisel-chancellery-building-photo-friday.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
  </div>
</div>

</body>
</html>
