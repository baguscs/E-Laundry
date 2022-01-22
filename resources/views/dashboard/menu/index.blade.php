@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Menu Laundry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Menu</li>
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
                <table id="menu" class="table table-bordered table-striped">
                  @if (Auth::user()->pegawai->role_id == 1)
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus-square"> Tambah Menu</i></button>
                  <div class="modal fade" id="tambah">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Tambah Menu Laundry</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <form action="{{ route('add_menu') }}" method="POST">
                            <div class="modal-body">
                              @csrf
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label>Nama Menu</label>
                                    <input type="text" name="nama" autocomplete="off" class="form-control" placeholder="Nama Menu" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="harga" autocomplete="off" id="harga" class="form-control" placeholder="Harga Menu" required>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="exampleSelectBorder">Status</label>
                                    <select class="custom-select form-control-border" name="status" id="exampleSelectBorder" required>
                                      <option value="Aktif">Aktif</option>
                                      <option value="Block">Block</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                  @endif
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Status</th>
                      @if (Auth::user()->pegawai->role_id == 1)  
                        <th>Opsi</th>
                      @endif
                    </tr>
                  </thead>
                  
                  <tbody>
                    @foreach ($data as $item)    
                      <tr>
                        <td>{{$item->nama}}</td>
                        @php
                          $harga = "Rp. ". number_format($item->harga,0,'.','.');
                        @endphp
                        <td>{{$harga}}</td>
                        <td>{{$item->status}}</td>
                        @if (Auth::user()->pegawai->role_id == 1)
                              <td>
                                @if ($item->status == 'Aktif')
                                  <button class="btn btn-sm btn-danger" title="Block" type="button" data-toggle="modal" data-target="#modal-sm{{$loop->iteration}}"><i class="fas fa-ban"></i></button>
                                  <div class="modal fade" id="modal-sm{{$loop->iteration}}">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Block Menu {{$item->nama}}</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        @php
                                          $parameter = [
                                            'id' => $item->id,
                                          ];
                                          $id = Crypt::encrypt($parameter);
                                        @endphp
                                        <form action="{{ route('status', $id) }}" method="POST">
                                          @csrf
                                            <div class="modal-body">
                                              <div class="row">
                                                <div class="col-sm-12">
                                                  <div class="form-group">
                                                    <label for="exampleSelectBorder">Status</label>
                                                      <select class="custom-select form-control-border" name="status" id="exampleSelectBorder">
                                                        <option value="Aktif">Aktif</option>
                                                        <option value="Block">Block</option>
                                                      </select>
                                                      <input type="text" name="nama" value="{{$item->nama}}" hidden>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                                @else
                                  <button class="btn btn-sm btn-success" title="Aktifkan" type="button" data-toggle="modal" data-target="#modal-sm{{$loop->iteration}}"><i class="fas fa-check"></i></button>
                                  <div class="modal fade" id="modal-sm{{$loop->iteration}}">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Aktifkan Menu {{$item->nama}}</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        @php
                                          $parameter = [
                                            'id' => $item->id,
                                          ];
                                          $id = Crypt::encrypt($parameter);
                                        @endphp
                                        <form action="{{ route('status', $id) }}" method="POST">
                                          @csrf
                                          <div class="modal-body">
                                            <div class="row">
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label for="exampleSelectBorder">Status</label>
                                                    <select class="custom-select form-control-border" name="status" id="exampleSelectBorder">
                                                      <option value="Block">Block</option>
                                                      <option value="Aktif">Aktif</option>
                                                    </select>
                                                    <input type="text" name="nama" value="{{$item->nama}}" hidden>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                          </div>
                                        </form>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                                @endif
                                <button class="btn btn-sm btn-info" title="Edit" type="button" data-toggle="modal" data-target="#modal-xl{{$loop->iteration}}"><i class="fas fa-edit"></i></button>
                                <div class="modal fade" id="modal-xl{{$loop->iteration}}">
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="modal-title">Edit Menu {{$item->nama}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      @php
                                        $parameter = [
                                          'id' => $item->id,
                                        ];
                                        $id = Crypt::encrypt($parameter);
                                      @endphp
                                      <form action="{{ route('edit_menu', $id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="form-group">
                                                <label>Nama Menu</label>
                                                <input type="text" name="nama" value="{{$item->nama}}" autocomplete="off" class="form-control" placeholder="Nama Menu" required>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-sm-6">
                                              <div class="form-group">
                                                <label>Harga</label>
                                                <input type="text" name="harga" value="{{$item->harga}}" autocomplete="off" id="uang" class="form-control" placeholder="Harga Menu" required>
                                              </div>
                                            </div>
                                            <div class="col-sm-6">
                                              <div class="form-group">
                                                <label for="exampleSelectBorder">Status</label>
                                                <input type="text" class="form-control" value="{{$item->status}}" disabled>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                      </form>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                              </td>    
                        @endif
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
      
          $('#menu').DataTable({
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
    var rupiah = document.getElementById('harga');
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