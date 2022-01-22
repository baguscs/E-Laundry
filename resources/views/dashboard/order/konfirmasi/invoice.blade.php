
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Laundry Mitra Jaya</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="shortcut icon" href="{{ asset('images/icon.jpg') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
        <div class="col-12">
            <h2 class="page-header">
            <i class="fas fa-globe"></i> E-Laundry Mitra Jaya.
            <small class="float-right">Date: {{$date}}</small>
            </h2>
        </div>
        <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
            <strong>E-Laundry Mitra Jaya.</strong><br>
            Jl. Sawo Bringin Gg: 6 No: 35<br>
            Sambikerep, Surabaya<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
            </address>
        </div>
        <!-- /.col -->
        @foreach ($data as $item)
            <div class="col-sm-4 invoice-col">
                To
                <address>
                <strong>{{$item->customer->nama}}</strong><br>
                Email: {{$item->customer->email}}<br>
                Alamat: {{$item->customer->alamat}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice {{$item->resi}}</b><br>
                <br>
                <b>Payment Due:</b> {{$item->estimasi}}<br>
                <b>Staff:</b> {{$item->pegawai->nama}}
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered border-primary">
                    <thead>
                    <tr>
                        <th>Berat Cucian</th>
                        <th>Kategori</th>
                        <th>Selesai</th>
                        <th>Menu</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="{{$row+1}}">{{$item->jumlah}} Kg</td>
                        <td rowspan="{{$row+1}}">{{$item->kategori}}</td>
                        <td rowspan="{{$row+1}}">{{$item->estimasi}}</td>
                        
                        
                    </tr>
                    @foreach ($work as $value)
                        <tr>
                            <td>{{$value->menuku->nama}}</td>
                            @php
                                $sum = $value->menuku->harga * $item->jumlah;
                                $subtotal = "Rp " . number_format($sum,0,'.','.');
                            @endphp
                            <td>{{$subtotal}}</td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                    </table>
                </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead">Payment Methods: 
                    @if ($item->bayar >= $item->total )
                        <b>Cash</b>
                    @else
                        <b>Down Payment</b>
                    @endif
                </p>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead">Pembayaran</p>

                <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Total:</th>
                        @php
                            $total = "Rp " . number_format($item->total,0,'.','.');
                        @endphp
                        <td>{{$total}}</td>
                    </tr>
                    <tr>
                        <th>Terbayar:</th>
                        @php
                            $bayar = "Rp " . number_format($item->bayar,0,'.','.');
                        @endphp
                        <td>{{$bayar}}</td>
                    </tr>
                    @if ($item->total > $item->bayar)
                        <tr>
                            <th>Sisa:</th>
                            @php
                                $sisa = $item->total - $item->bayar;
                                $konversi = "Rp " . number_format($sisa,0,'.','.');
                            @endphp
                            <td>{{$konversi}}</td>
                        </tr>
                    @else
                        <tr>
                            <th>Kembalian:</th>
                            @php
                                $kembali = $item->bayar - $item->total;
                                $konversi = "Rp " . number_format($kembali,0,'.','.');
                            @endphp
                            <td>{{$konversi}}</td>
                        </tr>
                    @endif
                </table>
                </div>
            </div>
            <!-- /.col -->
            </div>
        @endforeach
        <!-- /.row -->
        
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
