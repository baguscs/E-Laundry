@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pasokan Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Pasokan</li>
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
                @if ($messege = Session::get("pesan"))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sukses</h5>
                    {{Session::get("pesan") }}
                  </div>
                @endif
                <table id="pegawai" class="table table-bordered table-striped">
                  @if (Auth::user()->pegawai->role_id == 2)
                    <a href="{{ route('add_pasokan') }}" class="btn btn-success" ><i class="fa fa-plus-square"></i> Tambah Pasokan</a>
                  @endif
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Jumlah</th>
                      <th>Total</th>
                      <th width='100px'>Status</th>
                      <th>Pendata</th>
                      <th width='110px'>Opsi</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    @foreach ($data as $item)    
                      <tr>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->jumlah}}</td>
                        <td>{{'Rp '.$item->total}}</td>
                        <td>
                          @if ($item->verif == 'verif')
                            <button data-name="{{$item->nama}}" type="button" class="btn btn-sm btn-success swalDefaultSuccess">
                              <i class="fa fa-check"></i> Terverifikasi
                            </button>
                            @elseif($item->verif =='not valid')
                              <button data-name="{{$item->nama}}" type="button" class="btn btn-sm btn-danger swalDefaultError">
                                <i class="fa fa-exclamation-circle"></i> Tidak Valid
                              </button>
                            @else
                              <button data-name="{{$item->nama}}" type="button" class="btn btn-sm btn-info swalDefaultInfo">
                                <i class="fa fa-star-of-life"></i> Data Baru
                              </button>
                          @endif
                        </td>
                        <td>{{$item->pegawai->nama}}</td>
                        <td>
                          @if (Auth::user()->pegawai->role_id == 2 && $item->verif == null)
                            @php
                              $parameter = [
                                'id' => $item->id,
                              ];
                              $id = Crypt::encrypt($parameter);
                            @endphp
                            <button title="Edit Pasokan Barang" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-xl{{$loop->iteration}}">
                              <i class="fa fa-edit"></i>
                            </button>

                            <div class="modal fade" id="modal-xl{{$loop->iteration}}">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Edit Pasokan Barang {{$item->nama}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="POST" action="{{ route('edited_pasokan', $id) }}" enctype="multipart/form-data">
                                      @csrf
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" name="barang" value="{{$item->nama}}" required class="form-control" placeholder="Nama Barang" required>
                                          </div>
                                      </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="jumlah" value="{{$item->jumlah}}" class="form-control" placeholder="Jumlah Barang" required>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label>Detail Barang</label>
                                            <textarea name="detail" placeholder="Detail Barang" class="form-control" cols="30" rows="10">{{$item->detail}}</textarea>
                                          </div>
                                      </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" id="rupiah" name="total" value="{{$item->total}}" required class="form-control" placeholder="Total Harga Pembelian">
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label for="customFile">Bukti Pembelian / Nota</label>
                                            <div class="custom-file">
                                            <input type="file" value="{{old('bukti')}}" name="bukti" class="custom-file-input" id="imgInp">
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
                                              <a href="{{ asset('storage/nota/'. $item->nota) }}" target="_blank"><img src="{{ asset('storage/nota/'. $item->nota) }}" id="img" class="card-img-top img-fluid"></a>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" required class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Saya telah membaca serta memeriksa kebenaran dari data tersebut</label>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->

                            <button title="Hapus Pasokan Barang" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default{{$loop->iteration}}">
                              <i class="fa fa-trash"></i>
                            </button>

                            <div class="modal fade" id="modal-default{{$loop->iteration}}">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Hapus Pasokan Barang</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Yang ingin menghapus pasokan barang {{$item->nama}}?</p>
                                  </div>
                                  <form action="{{ route('delete_pasokan', $id) }}" method="POST">
                                    @csrf
                                      <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                      </div>
                                  </form>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            @elseif(Auth::user()->pegawai->role_id == 1 && $item->verif == null)
                            @php
                              $parameter = [
                                'id' => $item->id,
                              ];
                              $id = Crypt::encrypt($parameter);
                            @endphp
                            <button title="Verifikasi Pasokan Barang" type="button" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#modal-xl{{$loop->iteration}}">
                              <i class="fa fa-clipboard-check"></i>
                            </button>

                            <div class="modal fade" id="modal-xl{{$loop->iteration}}">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Verifikasi Pasokan Barang {{$item->nama}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="POST" action="{{ route('verif_pasokan', $id) }}">
                                      @csrf
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" name="barang" readonly value="{{$item->nama}}" required class="form-control" placeholder="Nama Barang" required>
                                          </div>
                                      </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="jumlah" readonly value="{{$item->jumlah}}" class="form-control" placeholder="Jumlah Barang" required>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Detail Barang</label>
                                            <textarea name="detail" readonly placeholder="Detail Barang" class="form-control" cols="30" rows="10">{{$item->detail}}</textarea>
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label>Total</label>
                                          <input type="text" id="rupiah" readonly name="total" value="{{$item->total}}" required class="form-control" placeholder="Total Harga Pembelian">
                                        </div>
                                      </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label for="customFile">Bukti Pembelian / Nota</label>
                                            <div class="input-group mb-3">
                                              <input type="text" class="form-control" readonly value="{{$item->nota}}">
                                              <span class="input-group-append">
                                                <a target="_blank" href="{{ asset('storage/nota/'. $item->nota) }}" type="button" class="btn btn-info btn-flat">Lihat Foto</a>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Pendata</label>
                                            <input type="text"  readonly value="{{$item->pegawai->nama}}" required class="form-control" placeholder="Total Harga Pembelian">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label for="custom-control-input">Verifikasi Pasokan Barang</label>
                                            <div class="custom-control custom-radio">
                                              <input class="custom-control-input" value ="verif" required type="radio" id="customRadio1" name="input" >
                                              <label for="customRadio1" class="custom-control-label">Verifikasi</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                              <input class="custom-control-input" value="not valid" required type="radio" id="customRadio2" name="input" >
                                              <label for="customRadio2" class="custom-control-label">Tidak Valid</label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" required class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Saya telah membaca serta memeriksa kebenaran dari data tersebut</label>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            @else
                            <button title="Info Pasokan Barang" type="button" class="btn btn-sm btn-block btn-info" data-toggle="modal" data-target="#modal-xl{{$loop->iteration}}">
                              <i class="fa fa-info-circle"></i>
                            </button>

                            <div class="modal fade" id="modal-xl{{$loop->iteration}}">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Informasi Pasokan Barang {{$item->nama}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form>
                                      @csrf
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" name="barang" readonly value="{{$item->nama}}" required class="form-control" placeholder="Nama Barang" required>
                                          </div>
                                      </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="jumlah" readonly value="{{$item->jumlah}}" class="form-control" placeholder="Jumlah Barang" required>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Detail Barang</label>
                                            <textarea name="detail" readonly placeholder="Detail Barang" class="form-control" cols="30" rows="10">{{$item->detail}}</textarea>
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label>Total</label>
                                          <input type="text" id="rupiah" readonly name="total" value="{{$item->total}}" required class="form-control" placeholder="Total Harga Pembelian">
                                        </div>
                                      </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label for="customFile">Bukti Pembelian / Nota</label>
                                            <div class="input-group mb-3">
                                              <input type="text" class="form-control" readonly value="{{$item->nota}}">
                                              <span class="input-group-append">
                                                <a target="_blank" href="{{ asset('storage/nota/'. $item->nota) }}" type="button" class="btn btn-info btn-flat">Lihat Foto</a>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label>Pendata</label>
                                            <input type="text"  readonly value="{{$item->pegawai->nama}}" required class="form-control" placeholder="Total Harga Pembelian">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
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
@push('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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
    <script>
        $(function () {
      
          $('#pegawai').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>
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
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: true,
      timer: 5000
    });

      $('.swalDefaultSuccess').click(function() {
        var nama = $(this).attr("data-name");
        Toast.fire({
          icon: 'success',
          title: 'Status Pasokan Barang '+nama+' Telah Diverifikasi Admin'
        })
      });

      $('.swalDefaultError').click(function() {
        var nama = $(this).attr("data-name");
        Toast.fire({
          icon: 'error',
          title: 'Status Pasokan Barang '+nama+' Tidak Valid'
        })
      });

      $('.swalDefaultInfo').click(function() {
        var nama = $(this).attr("data-name");
        Toast.fire({
          icon: 'info',
          title: 'Status Pasokan Barang '+nama+' Belum Diverifikasi Admin'
        })
      });
  });
</script>
@endpush