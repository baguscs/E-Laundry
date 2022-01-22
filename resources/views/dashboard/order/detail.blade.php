@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detail Pesanan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('order') }}">Pesanan</a></li>
              <li class="breadcrumb-item active">Detail Pesanan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                @foreach ($data as $item)
                    <form action="">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Customer</label>
                                    <input type="text" value="{{$item->customer->nama}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" value="{{$item->customer->alamat}}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>E-Mail</label>
                                    <input type="text" value="{{$item->customer->email}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Mencuci</label>
                                    <input type="text" value="{{$item->customer->wash}}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>No. Resi</label>
                                    <input type="text" value="{{$item->resi}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Estimasi</label>
                                    <input type="text" value="{{$item->estimasi}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" value="{{$item->kategori}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Berat Cucian (Kg)</label>
                                    <input type="text" value="{{$item->jumlah}}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Menu Yang Dipilih</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($work as $num => $value)
                                                <tr>
                                                    <td>{{$num+1}}</td>
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
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Total Bayar</label>
                                    @php
                                        $total = "Rp. ". number_format($item->total,0,'.','.');
                                    @endphp
                                    <input type="text" value="{{$total}}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Metode Pembayaran</label>
                                    @php
                                        if($item->bayar >= $item->total){
                                            $method = 'Cash';
                                        }
                                        else{
                                            $method = 'Down Payment';
                                        }
                                    @endphp
                                    <input type="text" value="{{$method}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Pembayaran</label>
                                    @php
                                        $bayar = "Rp. ". number_format($item->bayar,0,'.','.');
                                    @endphp
                                    <input type="text" value="{{$bayar}}" class="form-control" readonly>
                                </div>
                            </div>
                            @if ($item->bayar >= $item->total)
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kembalian</label>
                                        @php    
                                            $kembali = $item->bayar - $item->total;
                                            $sisa = "Rp. ". number_format($kembali,0,'.','.');
                                        @endphp
                                        <input type="text" value="{{$sisa}}" class="form-control" readonly>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kekurangan</label>
                                        @php    
                                            $kurang = $item->total - $item->bayar;
                                            $sisa = "Rp. ". number_format($kurang,0,'.','.');
                                        @endphp
                                        <input type="text" value="{{$sisa}}" class="form-control" readonly>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Status Pesanan</label>
                                    @php
                                        if ($item->status == 'good') {
                                            $status = 'Telah Dikonfirmasi';
                                        }
                                        elseif ($item->status == 'bad') {
                                            $status = 'Dibatalkan';
                                        }
                                        elseif ($item->status == 'non confirm') {
                                            $status = 'Belum Tekonfirmasi';
                                        }
                                        else{
                                            $status = 'Telah Diambil';
                                        }
                                    @endphp
                                    <input type="text" value="{{$status}}" class="form-control" readonly>
                                    @if ($item->status == 'bad')   
                                        <p>Pesan : {{$item->pesan}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Waktu Pesanan</label>
                                    <input type="text" value="{{$item->created_at}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Petugas Kasir</label>
                                    <input type="text" value="{{$item->pegawai->nama}}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
</div>
@endsection
