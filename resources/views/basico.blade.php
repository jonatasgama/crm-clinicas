<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CRM</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!--full calendar-->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <img src="{{ env('APP_URL') }}/img/logo.png" width="170" class="img-fluid mx-auto d-block">
        <hr class="sidebar-divider my-0">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">

            <div class="sidebar-brand-text mx-3">ORGANIZA CRM</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href=" {{ route('consulta.dash') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Geral
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('consulta.index') }}">
                <i class="fas fa-clipboard-list"></i>
                <span>Consultas</span>
            </a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-user-md"></i>
                <span>Tratamentos</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!--<h6 class="collapse-header">Custom Components:</h6>-->
                    <a class="collapse-item" href="{{ route('tratamento.index') }}">Listar</a>
                    <a class="collapse-item" href="{{ route('tratamento.create') }}">Cadastrar</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagamentos"
               aria-expanded="true" aria-controls="pagamentos">
                <i class="fas fa-money-bill-alt"></i>
                <span>Formas de Pagamento</span>
            </a>
            <div id="pagamentos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!--<h6 class="collapse-header">Custom Components:</h6>-->
                    <a class="collapse-item" href="{{ route('pagamento.index') }}">Listar</a>
                    <a class="collapse-item" href="{{ route('pagamento.create') }}">Cadastrar</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pacientes"
               aria-expanded="true" aria-controls="pacientes">
                <i class="fas fa-user-friends"></i>
                <span>Pacientes</span>
            </a>
            <div id="pacientes" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('paciente.index') }}">Listar</a>
                    <a class="collapse-item" href="{{ route('paciente.create') }}">Cadastrar</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#canais"
               aria-expanded="true" aria-controls="pacientes">
                <i class="fas fa-user-friends"></i>
                <span>Canal de Origem</span>
            </a>
            <div id="canais" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('canalorigem.index') }}">Listar</a>
                    <a class="collapse-item" href="{{ route('canalorigem.create') }}">Cadastrar</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Financeiro
        </div>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#gastos"
               aria-expanded="true" aria-controls="gastos">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Gastos</span>
            </a>
            <div id="gastos" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('gasto.index') }}">Listar</a>
                    <a class="collapse-item" href="{{ route('gasto.create') }}">Cadastrar</a>
                    <a class="collapse-item" href="{{ route('saida.create') }}">Registrar saída</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#relatorios"
               aria-expanded="true" aria-controls="relatorios">
                <i class="fas fa-chart-line"></i>
                <span>Relatórios</span>
            </a>
            <div id="relatorios" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('saida.itemmes') }}">Item por mês</a>
                    <a class="collapse-item" href="{{ route('saida.gastosmes') }}">Gastos por mês</a>
                    <a class="collapse-item" href="{{ route('saida.gastosereceita') }}">Gastos x Receita</a>
                </div>
            </div>
        </li>

        <!-- Divider
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Relatórios
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>-->

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form id="form_pesquisa" method="post" action="{{ route('paciente.procurar') }}"
                      class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="nome" name="nome" class="form-control bg-light border-0 small" placeholder="Pesquisar"
                               aria-label="Pesquisar" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $_SESSION["nome"] }}</span>
                            <img class="img-profile rounded-circle"
                                 src="{{ asset('img/undraw_profile_1.svg') }}">
                        </a>
                        <!-- Dropdown - User Information-->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <!--<a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>-->
                            <a class="dropdown-item" href="{{ route('sair') }}">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Sair
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            @yield('conteudo')

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; {{ date("Y") }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
-->


<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset('js/jquery.mask.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<!--<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>-->
<!--<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/locale/pt-br.js'></script>


<script>
    $(document).ready(function(){
        $('#valor').mask('###.###,##', {reverse: true});
        $('#telefone').mask('## #####-####', {reverse: false});
    });
</script>

@if(isset($consultas))
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: { center: 'month,listWeek' },
                defaultView: 'month',
                events : [
                        @foreach($consultas as $consulta)
                    {
                        id: '{{ $consulta->id }}',
                        title : '{{ $consulta->paciente->nome . ' ' . $consulta->paciente->sobrenome .' | '. $consulta->tratamento->tratamento }}',
                        start : '{{ $consulta->inicio_consulta }}',
                        tratamento_id : '{{ $consulta->tratamento_id }}',
                        pagamento_id : '{{ $consulta->pagamento_id }}',
                        pagamento : '{{ $consulta->pagamento }}',
                        paciente_id : '{{ $consulta->paciente->id }}',
                        @if($consulta->fim_consulta)
                        end: '{{ $consulta->fim_consulta }}',
                        @endif
                    },
                    @endforeach
                ],
                eventClick: function(calEvent, jsEvent, view) {
                    $('#event_id').val(calEvent._id);
                    $('#a_id').val(calEvent.id);
                    $('#a_inicio_consulta').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm'));
                    $('#a_fim_consulta').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm'));
                    $('#a_tratamento_id').val(calEvent.tratamento_id);
                    $('#a_paciente_id').val(calEvent.paciente_id);
                    $('#a_pagamento_id').val(calEvent.pagamento_id);
                    $('#a_pagamento').val(calEvent.pagamento);
                    $('#atualizaConsulta').modal();
                    calEvent.pagamento == "realizado" ? document.getElementById('a_pagamento').setAttribute("disabled", true) : document.getElementById('a_pagamento').removeAttribute("disabled");
                    document.getElementById('form_atualiza').setAttribute("action", "/consulta/"+calEvent.id);
                }
            });

            /*
            $('#').click(function(e) {
                e.preventDefault();
                var data = {
                    _token: '{{ csrf_token() }}',
                consulta_id: $('#consulta_id').val(),
                inicio_consulta: $('#a_inicio_consulta').val(),
                fim_consulta: $('#a_fim_consulta').val(),
                pagamento: $('#a_pagamento').val(),
                pagamento_id: $('#a_pagamento_id').val(),
                tratamento_id: $('#a_tratamento_id').val(),

            };

            $.post('{{ route('consulta.ajaxUpdate') }}', data, function( result ) {
                $('#calendar').fullCalendar('removeEvents', $('#event_id').val());

                $('#calendar').fullCalendar('renderEvent', {
                    title: result.consulta.paciente.nome + ' ' + result.consulta.paciente.sobrenome,
                    start: result.consulta.inicio_consulta,
                    end: result.consulta.fim_consulta,
                    id: result.consulta.id,
                    pagamento: result.consulta.pagamento,
                    pagamento_id: result.consulta.pagamento_id,
                    tratamento_id: result.consulta.tratamento_id
                }, true);

                $('#atualizaConsulta').modal('hide');
            });
        });
        */
        });

    </script>
@endif

@if(isset($pie))
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Roboto', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';
        // Pie Chart Example
        var tudo = {!! $pie !!};
        var ctx = document.getElementById("myPieChart");

        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: tudo.forma_pagamento,
                datasets: [{
                    data: tudo.qtd,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#44c4e'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#44c4e'],
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
                    displayColors: true,
                    caretPadding: 10,
                },
                legend:
                    {
                        display: true,
                        position: "bottom"
                    },
                cutoutPercentage: 80,
            },
        });

    </script>
@endif

@if(isset($chart_area))

    <script>
        var dados_area = {!! $chart_area !!};

        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dados_area.mes,
                datasets: [{
                    label: "Total",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: dados_area.total,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return 'R$' + number_format(value, 2, ',', '.');
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': R$' + number_format(tooltipItem.yLabel, 2, ',', '.');
                        }
                    }
                }
            }
        });

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    </script>
@endif
</body>

</html>
