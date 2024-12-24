<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>CVTS</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/dash/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        @yield('css')
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/dash/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

    @include('layouts.sidebar')

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
               @include('layouts.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                        @yield('contenido')


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; by  Jorge Garrido 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/dash/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('/dash/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Core plugin JavaScript -->
    <script src="{{ asset('/dash/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
     <!-- Custom scripts for all pages-->
    <script src="{{ asset('/dash/js/sb-admin-2.min.js')}}"></script>
    <!-- Page level plugins-->
    <script src="{{ asset('/dash/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{ asset('/dash/js/up-info.js')}}"></script>
    @if($cat=="plan")
    <script src="{{ asset('/dash/js/demo/plan-grafic.js')}}"></script>
    @endif




         @if (!empty($labelss) && !empty($datoss))
    <script>
        var etiquetas= {!! json_encode($labelss) !!};
        var datos1= {!! json_encode($datoss) !!};
        var lineasVenta={!! json_encode($lieaVenta) !!};
        var ctx = document.getElementById("myAreaCharts");
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: etiquetas,
            datasets: [{
                data: datos1,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                tension: 0.4
            },
            {
                    label: 'Linea Venta',  // Adding LineaVenta as a second line
                    data: lineasVenta,
                    backgroundColor: ['#f6c23e'],
                    hoverBackgroundColor: ['#f1b31c'],
                    hoverBorderColor: "rgba(255, 206, 86, 1)",
                    tension: 0
                }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
        },
    });
    var ctx = document.getElementById("pies");
    var tiemposPas = {!! json_encode($tiemposPas) !!};
    var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Delay", "On Time", "Great Time"],
    datasets: [{
      data: [tiemposPas[0],tiemposPas[1], tiemposPas[2]],
      backgroundColor: ['#FF4141', '#FFE641', '#27B744'],
      hoverBackgroundColor: ['#DE1818', '#FCDE37', '#50B727'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,

  },
});
    </script>
    @endif
    @if (!empty($datos))

    <script src="{{ asset('/dash/js/junta-calidad.js')}}"></script>
@endif
@yield('scripts')


</body>

</html>
