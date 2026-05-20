@extends('layout')

{{-- diretiva do Blade para "enviar" um pedaço de texto para um local específico no layout pai --}}
@section('title', 'Painel de Controle & Ponto')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Painel de Controle & Ponto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                        <li class="breadcrumb-item active">Painel de Controle</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalUsuarios }}</h3>
                            <p>Usuários Registrados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('users') }}" class="small-box-footer">
                            Mais informações <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card card-primary card-outline h-100">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-clock mr-1"></i> Seu Ponto Hoje</h3>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="row text-center mb-3">
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block font-weight-bold text-uppercase">Entrada</small>
                                    <span class="badge badge-secondary p-2 w-100" style="font-size: 14px;">{{ $myTodayClock->clock_in ?? '--:--' }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block font-weight-bold text-uppercase">Almoço (Ida)</small>
                                    <span class="badge badge-secondary p-2 w-100" style="font-size: 14px;">{{ $myTodayClock->lunch_start ?? '--:--' }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block font-weight-bold text-uppercase">Almoço (Volta)</small>
                                    <span class="badge badge-secondary p-2 w-100" style="font-size: 14px;">{{ $myTodayClock->lunch_end ?? '--:--' }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block font-weight-bold text-uppercase">Saída</small>
                                    <span class="badge badge-secondary p-2 w-100" style="font-size: 14px;">{{ $myTodayClock->clock_out ?? '--:--' }}</span>
                                </div>
                            </div>

                            <form action="{{ route('ponto.registrar') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold p-2">
                                    @if(!$myTodayClock || !$myTodayClock->clock_in)
                                        <i class="fas fa-sign-in-alt mr-1"></i> Registrar Entrada
                                    @elseif(!$myTodayClock->lunch_start)
                                        <i class="fas fa-utensils mr-1"></i> Ir para Almoço
                                    @elseif(!$myTodayClock->lunch_end)
                                        <i class="fas fa-reply mr-1"></i> Voltar do Almoço
                                    @elseif(!$myTodayClock->clock_out)
                                        <i class="fas fa-sign-out-alt mr-1"></i> Registrar Saída
                                    @else
                                        🎉 Jornada Concluída!
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="card card-success card-outline h-100">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-trophy mr-1 text-warning"></i> Corrida das Horas (Hoje)</h3>
                        </div>
                        <div class="card-body p-0" style="max-height: 190px; overflow-y: auto;">
                            <table class="table table-striped table-valign-middle m-0">
                                <thead>
                                    <tr>
                                        <th>Posição</th>
                                        <th>Colaborador</th>
                                        <th>Tempo Líquido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ranking as $index => $rank)
                                        <tr class="{{ $index == 0 ? 'table-warning font-weight-bold' : '' }}">
                                            <td>{{ $index + 1 }}º</td>
                                            <td>{{ $rank->user->name }}</td>
                                            <td>{{ round($rank->total_minutes / 60, 2) }} hrs</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted p-3">Nenhum ponto batido hoje.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i> 
                                Carga Horária Diária — Competição Semanal (Últimos 7 dias)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="position-relative" style="height: 350px;">
                                <canvas id="pontoChart" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('pontoChart').getContext('2d');
            
            // Dados estruturados vindos do DashboardController
            const chartData = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Horas Trabalhadas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Dias da Semana'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection