@extends('dashboard.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pesanan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Pesanan</li>
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
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new-member">
                      <i class="fas fa-plus-square"> Tambahkan Pesanan</i>
                    </button>

                    <div class="modal fade" id="new-member">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Menu Tambahkan Pesanan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="card">
                                  <a href="{{ route('new_customer', 'new') }}">
                                    <img src="{{ asset('images/new_customer.jpg') }}" id="menu" width="90%">
                                    <p id="menu">Customer Baru</p>
                                  </a>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="card">
                                  <a href="{{ route('old_customer', 'old') }}">
                                    <img src="{{ asset('images/old_customer.jpg') }}" id="menu" width="90%">
                                    <p id="menu">Customer Lama</p>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  @endif
                  <thead>
                    <tr>
                      <th>No. Resi</th>
                      <th>Nama Pelanggan</th>
                      <th width='50px'>Kategori</th>
                      <th width='110px'>Status</th>
                      <th>Pendata</th>
                      <th width='110px'>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                        <td>{{$item->resi}}</td>
                        <td>{{$item->customer->nama}}</td>
                        <td>{{$item->kategori}}</td>
                        <td>
                          @if ($item->status == "non confirm")
                            <button data-name="{{$item->customer->nama}}" type="button" class="btn btn-sm btn-info swalDefaultInfo"><i class="fa fa-exclamation-circle"></i> Non Konfirmasi</button>
                          @elseif ($item->status == "good")
                            <button data-name="{{$item->customer->nama}}" type="button" class="btn btn-sm btn-success swalDefaultSuccess"><i class="fa fa-check"></i> Terkonfirmasi</button>
                          @else
                            <button data-name="{{$item->customer->nama}}" data-pesan="{{$item->pesan}}" type="button" class="btn btn-sm btn-danger swalDefaultError"><i class="fas fa-window-close"></i> Dibatalkan</button>
                          @endif
                        </td>
                        <td>{{$item->pegawai->nama}}</td>
                        @php
                          $parameter = [
                            'id' => $item->id,
                            ];
                            $id = Crypt::encrypt($parameter);
                        @endphp
                        <td><a href="{{ route('detail_pesanan', $id) }}" class="btn btn-sm btn-block btn-info" title="Informasi Pesanan"><i class="fa fa-info-circle"> </i></a></td>
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
              title: 'Status Pesanan '+nama+' Telah Dikonfirmasi'
            })
          });

          $('.swalDefaultError').click(function() {
            var nama = $(this).attr("data-name");
            var pesan = $(this).attr("data-pesan");
            console.log(pesan);
            Toast.fire({
              icon: 'error',
              title: 'Status Pesanan '+nama+' Gagal Karena '+pesan
            })
          });

          $('.swalDefaultInfo').click(function() {
            var nama = $(this).attr("data-name");
            Toast.fire({
              icon: 'info',
              title: 'Status Pesanan '+nama+' Belum Dikonfirmasi'
            })
          });
      });
    </script>
@endpush