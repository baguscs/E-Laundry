@extends('dashboard.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('storage/foto/'. Auth::user()->pegawai->img) }}"
                       alt="User profile picture">
                </div>

            <h3 class="profile-username text-center">{{Auth::user()->pegawai->nama}}</h3>

            <p class="text-muted text-center">{{Auth::user()->pegawai->role->role}}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Pendidikan Terakhir</strong>
                <p class="text-muted">
                <a target="_blank" href="{{ asset('storage/ijazah/'. Auth::user()->pegawai->ijazah) }}">{{Auth::user()->pegawai->sekolah}}</a>
                </p>

                <hr>

                <strong><i class="fas fa-user-check mr-1"></i> Status</strong>

                <p class="text-muted">
                    @if (Auth::user()->pegawai->status == "aktif")
                        <button disabled type="button" class="btn btn-block btn-success">Aktif</button>
                    @endif
                </p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
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
                    <form class="form-horizontal" method="POST" action="{{ route('edited_profile') }}">
                        @csrf
                      @if (Auth::user()->pegawai->img_ktp != Null)
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">KTP</label>
                        <div class="col-sm-10">
                            <a target="_blank" href="{{ asset('storage/ktp/'. Auth::user()->pegawai->img_ktp) }}" data-toggle="lightbox" data-title="sample 1 - white">
                                <img src="{{ asset('storage/ktp/'. Auth::user()->pegawai->img_ktp) }}" class="img-fluid mb-2" alt="white sample"/>
                            </a>
                        </div>
                      </div>
                      @endif
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" placeholder="Name" readonly value="{{Auth::user()->pegawai->kelamin}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" readonly value="{{Auth::user()->pegawai->alamat}}" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">No. Telfon</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" placeholder="Name" readonly value="{{Auth::user()->pegawai->telpon}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">E-Mail</label>
                        <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputSkills" placeholder="E-Mail" value="{{Auth::user()->email}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" required> Saya menyetujui syarat dan ketentuan
                            </label>
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
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection