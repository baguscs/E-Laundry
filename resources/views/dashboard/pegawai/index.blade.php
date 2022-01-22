@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pegawai Kasir</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Pegawai</li>
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
                  @if (Auth::user()->pegawai->role_id == 1)
                  <a href="{{ route('add_pegawai') }}" class="btn btn-success" ><i class="fa fa-plus-square"></i> Tambah Pegawai</a>
                  @endif
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>No. Telfon</th>
                      <th>E-Mail</th>
                      @if (Auth::user()->pegawai->role_id == 1)
                        <th>Password</th>
                      @endif
                      <th>Kode</th>
                      <th>Status</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->telpon}}</td>
                            <td>{{$item->email}}</td>
                            @if (Auth::user()->pegawai->role_id == 1)
                            <td>
                              @if ($item->akses == Null)
                                  <button disabled class="btn btn-sm btn-success">Telah Diubah</button>
                              @else
                                  {{$item->akses}}
                              @endif
                          </td>
                            @endif
                            <td>{{$item->kode}}</td>
                            <td>
                              @if (Auth::user()->pegawai->role_id == 1)
                                @if ($item->akses == null)
                                  @if ($item->status == 'aktif')
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#status{{$loop->iteration}}">
                                      <i class="fas fa-check"> Aktif</i>
                                    </button>
                                  @elseif($item->status == 'non-aktif')
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#status{{$loop->iteration}}">
                                      <i class="fas fa-exclamation-triangle"> Non-Aktif</i>
                                    </button>
                                  @else
                                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#status{{$loop->iteration}}">
                                    <i class="fas fa-exclamation-triangle"> Suspend</i>
                                  </button>
                                  @endif
                              
                                    <div class="modal fade" id="status{{$loop->iteration}}">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Ubah Status Pegawai {{$item->nama}}</h4>
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
                                          <form action="{{ route('update_status', $id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                              <div class="form-group">
                                                <label for="custom-control-input">Status Pegawai</label>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" value ="aktif" type="radio" id="customRadio1" name="radio" @if ($item->status == 'aktif')
                                                      checked
                                                  @endif>
                                                  <label for="customRadio1" class="custom-control-label">Aktif</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                  <input class="custom-control-input" value="suspend" type="radio" id="customRadio2" name="radio" @if ($item->status == 'suspend')
                                                    checked
                                                  @endif>
                                                  <label for="customRadio2" class="custom-control-label">Suspend</label>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="sumbit" class="btn btn-primary">Save changes</button>
                                            </div>
                                          </form>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                @else
                                 <button title="Telah Diubah" class="btn btn-sm btn-success"><i class="fa fa-star-of-life"></i> Data Baru</button>
                                @endif
                              @else
                                @if ($item->status == 'aktif')
                                <button title="Telah Diubah" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Aktif</button>
                                @elseif($item->status == 'eror')
                                <button title="Telah Diubah" class="btn btn-sm btn-warning"><i class="fa fa-exclamation-triangle"></i> Non Aktivasi</button>
                                @else
                                <button title="Telah Diubah" class="btn btn-sm btn-warning"><i class="fa fa-exclamation-triangle"></i> Suspend</button>
                                @endif
                              @endif
                            </td>
                            
                            <td>
                                @php
                                $parameter = [
                                        'id' => $item->id,
                                     ];
                                     $id = Crypt::encrypt($parameter);
                                @endphp
                                @if (Auth::user()->pegawai->role_id == 1 && $item->akses != Null )
                                    <button title="Edit Pegawai" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-xl{{$loop->iteration}}">
                                    <i class="fa fa-edit"></i>
                                    </button>

                                    <div class="modal fade" id="modal-xl{{$loop->iteration}}">
                                        <div class="modal-dialog modal-xl">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Pegawai {{$item->nama}}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('edited_pegawai', $id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Nama Pegawai</label>
                                                                    <input type="text" name="nama" value="{{$item->nama}}" required class="form-control" placeholder="Nama Depan" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                              <!-- text input -->
                                                              <div class="form-group">
                                                                <label>Alamat</label>
                                                                <input type="text" name="alamat" value="{{$item->alamat}}" class="form-control" placeholder="Alamat" required>
                                                              </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                              <div class="form-group">
                                                                <label>Nomor Telepon</label>
                                                                <input type="number" name="telpon" value="{{$item->telpon}}" required class="form-control" placeholder="Nomor Telepon">
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                  <label>E-Mail</label>
                                                                  <input type="email" name="email" value="{{$item->email}}" required class="form-control" placeholder="E-Mail">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="exampleSelectBorder">Jenis Kelamin</label>
                                                                    <select name="kelamin" id="kelamin" value="{{old('kelamin')}}" required class="custom-select form-control-border" id="exampleSelectBorder">
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
                                                                  <input type="text" name="sekolah" value="{{$item->sekolah}}" required class="form-control" placeholder="Sekolah Terakhir">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="customFile">Ijazah Terakhir</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" name="ijazah"value="{{old('ijazah')}}" class="custom-file-input" id="customFile">
                                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                                        <a target="_blank" href="{{ route('read_ijazah', $item->nama) }}" id="ijazah" class="btn btn-info">Ijazah Terkini</a>
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
                                                                        <input type="file" value="{{old('foto')}}" name="foto" class="custom-file-input" id="imgInp">
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
                                                                        <img src="{{ asset('storage/foto/'. $item->img) }}" id="img" class="card-img-top img-fluid">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="customFile">Foto KTP</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" name="ktp" value="{{old('ktp')}}" class="imgFile custom-file-input" accept="image/*" onchange="loadFile(event)">
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
                                                                        <img src="{{ asset('storage/ktp/'. $item->img_ktp) }}" id="img_ktp" class="card-img-top img-fluid">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" required class="form-check-input" id="exampleCheck1">
                                                            <label class="form-check-label" for="exampleCheck1">Saya telah membaca serta memeriksa kebenaran dari data tersebut</label>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                          </div>
                                                    </div>
                                                </form>
                                            </div>
                                          </div>
                                          <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                      </div>
                                      <!-- /.modal -->

                                    <button title="Hapus Pegawai" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default{{$loop->iteration}}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="modal-default{{$loop->iteration}}">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Hapus Pegawai</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yang ingin menghapus pegawai {{$item->nama}}?</p>
                                            </div>
                                            <form action="{{ route('del_pegawai', $id) }}" method="POST">
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
                                @else
                                <button title="Detail Pegawai" type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-xl{{$loop->iteration}}">
                                  <i class="fa fa-info-circle"></i>
                                  </button>

                                  <div class="modal fade" id="modal-xl{{$loop->iteration}}">
                                      <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title">Informasi Pegawai {{$item->nama}}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                              <form method="POST">
                                                  @csrf
                                                      <div class="row">
                                                          <div class="col-sm-12">
                                                              <div class="form-group">
                                                                  <label>Nama Pegawai</label>
                                                                  <input type="text" readonly name="nama" value="{{$item->nama}}" required class="form-control" placeholder="Nama Depan" required>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-sm-6">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                              <label>Alamat</label>
                                                              <input type="text" readonly name="alamat" value="{{$item->alamat}}" class="form-control" placeholder="Alamat" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-sm-6">
                                                            <div class="form-group">
                                                              <label>Nomor Telepon</label>
                                                              <input type="number" readonly name="telpon" value="{{$item->telpon}}" required class="form-control" placeholder="Nomor Telepon">
                                                            </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-sm-6">
                                                              <div class="form-group">
                                                                <label>E-Mail</label>
                                                                <input type="email" readonly name="email" value="{{$item->email}}" required class="form-control" placeholder="E-Mail">
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-6">
                                                              <div class="form-group">
                                                                  <label for="exampleSelectBorder">Jenis Kelamin</label>
                                                                  <input type="email" readonly name="email" value="{{$item->kelamin}}" required class="form-control" placeholder="E-Mail">
                                                                </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-sm-6">
                                                              <div class="form-group">
                                                                <label>Sekolah Terakhir</label>
                                                                <input type="text" name="sekolah" readonly value="{{$item->sekolah}}" required class="form-control" placeholder="Sekolah Terakhir">
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="customFile">Foto Pegawai</label>
                                                                <div class="input-group mb-3">
                                                                  <input type="text" class="form-control" readonly value="{{$item->img}}">
                                                                  <span class="input-group-append">
                                                                    <a target="_blank" href="{{ asset('storage/foto/'. $item->img) }}" type="button" class="btn btn-info btn-flat">Lihat Foto</a>
                                                                  </span>
                                                                </div>
                                                                @error('foto')
                                                                <div class="alert alert-danger" style="margin-top: 10px">
                                                                    <i class="icon fas fa-exclamation-triangle"></i>
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                      </div>
                                                      @if (Auth::user()->pegawai->role_id == 1)
                                                        <div class="row">
                                                          <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="customFile">Ijazah Terakhir</label>
                                                                <div class="input-group mb-3">
                                                                  <input type="text" class="form-control" readonly value="{{$item->ijazah}}">
                                                                  <span class="input-group-append">
                                                                    <a target="_blank" href="{{ route('read_ijazah', $item->nama) }}" type="button" class="btn btn-info btn-flat">Lihat Ijazah</a>
                                                                  </span>
                                                                </div>
                                                                @error('ijazah')
                                                                <div class="alert alert-danger" style="margin-top: 10px">
                                                                    <i class="icon fas fa-exclamation-triangle"></i>
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                                @enderror
                                                            </div>
                                                          </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="customFile">Foto KTP</label>
                                                                    <div class="input-group mb-3">
                                                                      <input type="text" class="form-control" readonly value="{{$item->img}}">
                                                                      <span class="input-group-append">
                                                                        <a target="_blank" href="{{ asset('storage/ktp/'. $item->img_ktp) }}" type="button" class="btn btn-info btn-flat">Lihat Foto</a>
                                                                      </span>
                                                                    </div>
                                                                    @error('ktp')
                                                                    <div class="alert alert-danger" style="margin-top: 10px">
                                                                        <i class="icon fas fa-exclamation-triangle"></i>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                      @endif
                                                      <div class="modal-footer">
                                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
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
<style>
  #ijazah{
    margin-top: 10px;
    margin-bottom: 5px;
  }
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
    @foreach($data as $row)
      document.getElementById('kelamin').value='{{$row->kelamin}}';
    @endforeach
    
  </script>
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
            var loadFile = function(event) {
                var output = document.getElementById('img_ktp');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
      };
    </script>
@endpush