@extends('dashboard.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ganti Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Ganti Password</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="card">
                        <div class="card-body">
                            @if ($messege = Session::get("pesan"))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i> Sukses</h5>
                                    {{ Session::get("pesan") }}
                                </div>
                            @endif
                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" method="POST" action="{{ route('update_password') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Password Lama</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="old_password"  placeholder="Password Lama" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Password Baru</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password" placeholder="Password Baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <input type="checkbox" required> Saya menyetujui syarat dan ketentuan yang berlaku
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-danger">Batal</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
        </section>
    </div>
@endsection