@extends('dashboard.master')
@section('content')
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$order}}</h3>

                <p>Pesanan Laundry</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('order') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{$pegawai}}</h3>

                <p>Pegawai Kasir</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('show_pegawai') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$barang}}</h3>

                <p>Barang Pelengkap</p>
              </div>
              <div class="icon">
                <i class="ion ion-cube"></i>
              </div>
              <a href="{{ route('pasokan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        {{-- <div class="row">
          <div class="card col-md-6">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-bar mr-1"></i>
                Statistik Pesanan
              </h3>
            </div><!-- /.card-header -->
            <div class="card-body" >
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                  <canvas id="myChart" width="10px" height="10px"></canvas>
              </div>
            </div><!-- /.card-body -->
          </div> --}}
          {{-- <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-history mr-1"></i>
                  Pengguna Online
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body" >
                <div class="tab-content p-0">
                    <table class="table">
                    @foreach ($online as $person)
                      <tbody>
                        <tr>
                          <td>{{$person->user->}}</td>
                          <td></td>
                        </tr>
                      </tbody>
                    @endforeach
                    </table>
                </div>
              </div><!-- /.card-body -->
            </div>
          </div> --}}
        </div>
        <!-- /.card -->
        </div>
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script>
  var ctx = document.getElementById('myChart');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Jan', 'Feb', 'March', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okto', 'Novem', 'Des'],
          datasets: [{
              label: 'Tahun {{$year}}',
              data: [12, 19, 3, 5, 2, 3, 3, 6, 9, 8, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(219, 35, 118, 0.2)',
                  'rgba(177, 230, 5, 0.2)',
                  'rgba(29, 240, 155, 0.2)',
                  'rgba(45, 228, 235, 0.2)',
                  'rgba(35, 139, 219, 0.2)',
                  'rgba(60, 35, 219, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(219, 35, 118, 1)',
                  'rgba(177, 230, 5, 1)',
                  'rgba(29, 240, 155, 1)',
                  'rgba(45, 228, 235, 1)',
                  'rgba(35, 139, 219, 1)',
                  'rgba(60, 35, 219, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
  </script>
@endpush