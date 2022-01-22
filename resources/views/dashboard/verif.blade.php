
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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <p><i class="fas fa-envelope-open-text"></i> Verification E-Mail</p>
    @if ($messege = Session::get("pesan"))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 20px">
        <strong>Sukses!</strong> {{ Session::get("pesan") }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    @if ($messege = Session::get("eror"))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 20px">
        <strong>Peringatan!</strong> {{ Session::get("eror") }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <p style="font-size: 25px">Akun Email anda belum diverifikasi</p>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">{{Auth::user()->pegawai->nama}}</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" method="POST" action="{{ route('valided_email') }}">
        @csrf
      <div class="input-group">
        <input type="text" name="kode" class="form-control" placeholder="Kode Akses">

        <div class="input-group-append">
          <button type="submit" class="btn">
            <i class="fas fa-arrow-right text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Masukkan Kode Akses anda sekarang
  </div>
  <div class="lockscreen-footer text-center">
    <strong>Copyright &copy; 2020-now.</strong>
    <p>Bagus Cahyo Sulistiyo.</p>
    Version 1.0.0
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
