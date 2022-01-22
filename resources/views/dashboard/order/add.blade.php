@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                @if ($parameter == 'new')
                    <h1>Tambah Pesanan Customer Baru</h1>
                @else
                    <h1>Tambah Pesanan Customer Lama</h1>
                @endif
            </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order') }}">Pesanan</a></li>
                    <li class="breadcrumb-item active">Tambah Pesanan</li>
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
                  <div class="card-body">
                    @if ($messege = Session::get("pesan"))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
                            {{ Session::get("pesan") }}
                        </div>
                    @endif
                    <form id="myForm" method="POST" action="{{ route('post_orderan', $parameter) }}">
                        @csrf
                        @if ($parameter == 'new')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Customer</label>
                                        <input type="text" name="nama" value="{{old('nama')}}" required class="form-control" placeholder="Nama Customer" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" name="alamat" value="{{old('alamat')}}" required class="form-control" placeholder="Alamat Customer" required>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="row">
                                @if ($parameter == 'new')
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label>E-Mail</label>
                                        <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email Customer" required>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nama Customer</label>
                                            <select class="form-control select2bs4" style="width: 100%; " name="nama" id="customer">
                                                <option selected="selected" disabled>Pilih Nama Customer</option>
                                                @foreach ($customer as $value)
                                                    <option value="{{$value->id}}">{{$value->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Berat Cucian</label>
                                        <input type="number" id="berat" name="berat" value="{{old('berat')}}" class="form-control" placeholder="Berat Cucian Dalam (Kg)" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="custom-control-input">Kategori Pesanan</label>
                                        <div class="custom-control custom-radio">
                                          <input class="custom-control-input" value ="Standart" required type="radio" id="customRadio1" name="kategori">
                                          <label for="customRadio1" class="custom-control-label">Standart</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" value="Express" required  type="radio" id="customRadio2" name="kategori" >
                                            <label for="customRadio2"  class="custom-control-label">Express</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Menu Laundry</label>
                                        <select name="menu[]" id="menu" class="form-control" multiple="multiple">
                                            @foreach ($menu as $item)
                                                <option harga="{{$item->harga}}" value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" id="rupiah" readonly name="total" value="" required class="form-control" placeholder="Total Bayar">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Uang Pembayaran</label>
                                        <input type="text" min="" id="bayar" name="bayar" required class="form-control" placeholder="Uang Pembayaran">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check">
                                <input type="checkbox" required class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Saya telah membaca serta memeriksa kebenaran dari data tersebut</label>
                            </div>
                            <div class="btn-valid">
                                <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-danger">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                  </div>
              </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        //multiple select2
        $(document).ready(function() {
            $('#customer').select2();
            $('#menu').select2();

            //total bayar
            var harga = [];
            var total = 0;
            $('#menu').change(function(event){
                
                harga = [];
                total = 0;
                    $('#menu option:selected').each(function(){
                        harga.push($(this).attr('harga'));
                    });
                    for(var i = 0;i<harga.length;i++) {
                        total += parseInt(harga[i]);
                    }
                //ambil kategori
                var x = $("input[type='radio']:checked").val();

                if (x == "Standart") {
                    var y = 0;
                }
                else{
                    var y = 10000;
                }

                    //ambil berat
                    var berat = $('#berat').val();

                    var harga = total * berat + y;

                    //setting atribut min pada input bayar
                    var uang = document.getElementById('bayar');
                    uang.setAttribute('min', harga);
                
                    var	reverse = harga.toString().split('').reverse().join(''),
                        ribuan 	= reverse.match(/\d{1,3}/g);
                        ribuan	= ribuan.join('.').split('').reverse().join('');

                    $('#rupiah').val(ribuan);
            });
        });
        

    </script>
    <script>
        //konfersi uang
        var rupiah = document.getElementById('bayar');
            rupiah.addEventListener('keyup', function(e){
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah.value = formatRupiah(this.value, '');
            });
    
            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
    
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }
    </script>
@endpush