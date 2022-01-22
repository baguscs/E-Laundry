<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Laundry Mitra Jaya</title>
  
  <link rel="shortcut icon" href="{{ asset('images/icon.jpg') }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<style>
    .head{
        font-size: 25px;
        text-align: center;
        font-weight: bold;
    }
</style>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo"></div>
  <div class="card">
    <div class="card-body register-card-body">
        @foreach ($data as $item)
            <p class="head">Mohon Maaf, {{$item->customer->nama}}</p>
                Konfirmasi anda telah terkirim
                <p>Hormat Kami, Mitra Jaya</p>
        @endforeach
    </div>
    <!-- /.form-box -->
    
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
</body>
</html>
