@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Pegawai Kasir</h1>
            </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('show_pegawai') }}">Pegawai</a></li>
                    <li class="breadcrumb-item active">Tambah Pegawai</li>
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
                    <form method="POST" action="{{ route('post_pegawai') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Depan</label>
                                        <input type="text" name="first" value="{{old('first')}}" required class="form-control" placeholder="Nama Depan" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="form-control" value="{{old('second')}}" name="second" placeholder="Nama Belakang (Opsional)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" value="{{old('alamat')}}" class="form-control" placeholder="Alamat" required>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="number" name="telpon" value="{{old('telpon')}}" required class="form-control" placeholder="Nomor Telepon">
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>E-Mail</label>
                                      <input type="email" name="email" value="{{old('email')}}" required class="form-control" placeholder="E-Mail">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleSelectBorder">Jenis Kelamin</label>
                                        <select name="kelamin" value="{{old('kelamin')}}" required class="custom-select form-control-border" id="exampleSelectBorder">
                                          <option selected disabled>Pilih Jenis Kelamin</option>
                                          <option value="Laki-Laki">Laki-Laki</option>
                                          <option value="Perempuan">Perempuan</option>
                                        </select>
                                      </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Sekolah Terakhir</label>
                                      <input type="text" name="sekolah" value="{{old('sekolah')}}" required class="form-control" placeholder="Sekolah Terakhir">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customFile">Ijazah Terakhir</label>
                                        <div class="custom-file">
                                            <input type="file" name="ijazah"value="{{old('ijazah')}}" required class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <h6 class="txt-info">file extensi : pdf</h6>
                                            <h6 class="txt-info">maximal size file : 400kb</h6>
                                        </div>
                                        @error('ijazah')
                                        <div class="alert alert-danger" style="margin-top: 10px">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customFile">Foto Pegawai</label>
                                        <div class="custom-file">
                                            <input type="file" value="{{old('foto')}}" name="foto" required class="custom-file-input" id="imgInp">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <h6 class="txt-info">file extensi : jpg,jpeg,png</h6>
                                            <h6 class="txt-info">maximal size file : 1mb</h6>
                                        </div>
                                        @error('foto')
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customFile">Foto KTP</label>
                                        <div class="custom-file">
                                            <input type="file" name="ktp" value="{{old('ktp')}}" required class="imgFile custom-file-input" accept="image/*" onchange="loadFile(event)">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <h6 class="txt-info">file extensi : jpg,jpeg,png</h6>
                                            <h6 class="txt-info">maximal size file : 1mb</h6>
                                        </div>
                                        @error('ktp')
                                        <div class="alert alert-danger" style="margin-top: 10px">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        <div class="imgWrap">
                                            <img src="{{ asset('images/no-pict.png') }}" id="img_ktp" class="card-img-top img-fluid">
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
        var loadFile = function(event) {
            var output = document.getElementById('img_ktp');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
  };
</script>
@endpush