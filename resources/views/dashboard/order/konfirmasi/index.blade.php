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
    .button{
        margin-top: 20px;
    }
</style>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo"></div>
  <div class="card">
    <div class="card-body register-card-body">
        <p class="head">Konfirmasi Pesanan Anda</p>
        <p class="head">Laundry Mitra Jaya</p>
        <p class="login-box-msg">Detail Pesanan Anda :</p>

        @foreach ($data as $item)  
            <table cellpadding="10" cellspacing="5">
                <tr>
                    <td>Nomor Pesanan</td>
                    <td>:</td>
                    <td>{{$item->resi}}</td>
                </tr>
                <tr>
                    <td>Nama Customer</td>
                    <td>:</td>
                    <td>{{$item->customer->nama}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{$item->customer->alamat}}</td>
                </tr>
                <tr>
                    <td>Berat Cucian</td>
                    <td>:</td>
                    <td>{{$item->jumlah. " Kg"}}</td>
                </tr>
                <tr>
                    <td>Kategori Pesanan</td>
                    <td>:</td>
                    <td>{{$item->kategori}}</td>
                </tr>
                <tr>
                    <td>Menu Yang dipilih</td>
                    <td>:</td>
                    <td>
                        @foreach ($work as $value)
                            {{$value->menuku->nama.". "}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>:</td>
                    <td>
                        @if ($item->bayar >= $item->total )
                            Cash
                        @else
                            Down Payment
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Total Bayar</td>
                    <td>:</td>
                    @php
                        $total = "Rp " . number_format($item->total,0,'.','.');
                    @endphp
                    <td>{{$total}}</td>
                </tr>
                <tr>
                    <td>Telah Dibayar</td>
                    <td>:</td>
                    @php
                        $bayar = "Rp " . number_format($item->bayar,0,'.','.');
                    @endphp
                    <td>{{$bayar}}</td>
                </tr>
                <tr>
                    <td>Dapat diambil pada</td>
                    <td>:</td>
                    <td>{{$item->estimasi}}</td>
                </tr>
                <tr>
                    <td>Petugas</td>
                    <td>:</td>
                    <td>{{$item->pegawai->nama}}</td>
                </tr>
            </table>
        
            @php
                $parameter = [
                    'id' => $item->id,
                ];
                $id = Crypt::encrypt($parameter);
            @endphp
        @endforeach
        <div class="social-auth-links text-center">
            <p>Apakah Pesanan Anda Telah Benar ?</p>
            <form action="{{ route('confirmed', $id) }}" method="POST">
                @csrf
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" required id="inlineRadio1" value="good">
                    <label class="form-check-label" for="inlineRadio1">Benar</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" required id="inlineRadio2" value="bad">
                    <label class="form-check-label" for="inlineRadio2">Salah</label>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="text" class="form-controll" id="alasan" name="pesan"  placeholder="keterangan" hidden>
                    </div>
                </div>
                <div class="button">
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block btn-success">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            </form>
      </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".form-check-input").change(function() {
			if ($("input[type='radio']:checked").val() == 'good') {
                $('#alasan').prop('required', false);
				$('#alasan').attr('hidden', 'true');
			} else {
                $('#alasan').prop('required', true);
				$('#alasan').prop('hidden', false);
			}
		});
    });
</script>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
</body>
</html>
