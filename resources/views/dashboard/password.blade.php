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
  #head{
    margin-top: 70px;
  }
</style>
<body class="hold-transition login-page">
<div class="col-md-6" id="head">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h3>Registrasi Password Baru</h3>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Silahkan Masukkan Password Baru Anda, agar privasi anda tetap</p>
      @if ($messege = Session::get("eror"))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
            {{ Session::get("eror") }}
        </div>
      @endif
      <form method="post" action="{{ route('update_password') }}">
        @csrf
        <div class="input-group mb-3">
          <input name="old_password" id="old_pass" type="password" class="form-control" required autocomplete="off" placeholder="Password Lama">
          <div class="input-group-append">
            <div class="input-group-text">
              <input style="float: left;" type="checkbox" class="form-checkbox">&nbsp;&nbsp; Lihat 
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" id="new_password" type="password" class="form-control" required autocomplete="off" placeholder="Password Baru">
        </div>
        <div class="input-group mb-3">
          <input name="password_confirmation" type="password" class="form-control" required autocomplete="off" placeholder="Konfirmasi Password">
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Daftarkan Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  $(document).ready(function () {
    $('.form-checkbox').click(function () {
      if($(this).is(':checked')){
        $('#old_pass').attr('type','text');
      }else{
        $('#old_pass').attr('type','password');
          }
      })
  })
</script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
</body>
</html>
