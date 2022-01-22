@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Pasokan Barang</h1>
            </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pasokan') }}">Pasokan</a></li>
                    <li class="breadcrumb-item active">Tambah Pasokan</li>
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
                    <form method="POST" action="{{ route('post_pasokan') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <input type="text" name="barang" value="{{old('barang')}}" required class="form-control" placeholder="Nama Barang" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Jumlah</label>
                                      <input type="number" name="jumlah" value="{{old('jumlah')}}" class="form-control" placeholder="Jumlah Barang" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Detail Barang</label>
                                        <textarea name="detail" placeholder="Detail Barang" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" id="rupiah" name="total" value="{{old('total')}}" required class="form-control" placeholder="Total Harga Pembelian">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customFile">Bukti Pembelian / Nota</label>
                                        <div class="custom-file">
                                            <input type="file" value="{{old('bukti')}}" name="bukti" required class="custom-file-input" id="imgInp">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <h6 class="txt-info">file extensi : jpg,jpeg,png</h6>
                                            <h6 class="txt-info">maximal size file : 1mb</h6>
                                        </div>
                                        @error('bukti')
                                        <div class="alert alert-danger" style="margin-top: 10px">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        <div class="imgWrap">
                                            <img src="{{ asset('images/no-pict.png') }}" id="img" class="card-img-top img-fluid">
                                        </div>
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
    <style>
        .btn-valid{
            margin-top: 20px;
        }
        .txt-info{
            font-size: 15px;
            text-transform: uppercase;
            color: grey;
            margin-top: 0px;
        }
        #img{  
            padding:5px;
            width: 45%;
            margin-left: 120px;
        }
        #img_ktp{  
            padding:5px;
            width: 45%;
            margin-left: 120px;
        }
        .loadAnimate{
            animation:setAnimate ease 2.5s infinite;
        }
        .select2{
            width: 100%!important;
        }
        @keyframes setAnimate{
            0%  {color: #000;}     
            50% {color: transparent;}
            99% {color: transparent;}
            100%{color: #000;}
        }
        .custom-file-label{
            cursor:pointer;
        }
        .custom-select{
            width: 98%;
        }
    </style>
@endpush
@push('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img').attr('src', e.target.result);
                }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });
</script>
<script>
    var rupiah = document.getElementById('rupiah');
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
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