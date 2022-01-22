<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Laundry Mitra Jaya</title>
    <link rel="shortcut icon" href="{{ asset('images/icon.jpg') }}">

    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    
</head>
<body>
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12" style="margin-top: 10px">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Silahkan Reset Password Anda</h3>
                            
                        </div>
                        <div class="card-body p-0">
                            <div class="bs-stepper">
                                @if ($messege = Session::get("pesan"))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
                                            {{Session::get("pesan") }}
                                    </div>
                                @endif
                                <div class="bs-stepper-header" role="tablist">
                                <!-- your steps here -->
                                    <div class="step" data-target="#confirm">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Konfirmasi</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#reset">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Reset Password</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <!-- your steps content here -->
                                    <div id="confirm" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                        <div class="form-group">
                                            <p>Hai, {{$nama}} <br>
                                                Apakah anda yakin untuk mereset password anda?
                                            </p>
                                            <p>Jika anda yakin silahkan klik tombol next dibawah</p>
                                        </div>
                                        <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                                    </div>
                                    <div id="reset" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                        @php
                                            $parameter = Crypt::encrypt($id);
                                        @endphp
                                        <form action="{{ route('change', $parameter) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Password Baru</label>
                                                <input type="password" name="password" required class="form-control" id="exampleInputEmail1" placeholder="Enter new password">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Konfirmasi Password</label>
                                                <input type="password" name="password_confirmation" required class="form-control" id="exampleInputPassword1" placeholder="Password Confirmation">
                                            </div>
                                            <button class="btn btn-danger" type="button" onclick="stepper.previous()">Previous</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /.card-body -->
                    </div>
                <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>

<!-- BS-Stepper -->
<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
    // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })
</script>
</body>
</html>