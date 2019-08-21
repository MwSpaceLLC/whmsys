@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <ul class="side-menu">
                    <li class="active"><a href="/home">@lang('dashboard')</a></li>
                    <li><a href="/clients">@lang('clients')</a></li>
                    <li><a href="/invoices">@lang('invoices')</a></li>
                    <li><a href="/settings">@lang('settings')</a></li>
                </ul>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="client" data-color="#9933CC" data-border="#9933CC"
                                        data-int="{{ \App\Client::count()}}"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="invoice" data-color="#00695c" data-border="#00695c"
                                        data-int="{{\App\Invoice::count()}}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        var ctx = document.getElementById("client").getContext('2d');
        var dataset = document.getElementById("client").dataset;

        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: "@lang('Total Clients system')",
                    data: [dataset.int],
                    backgroundColor: [
                        'rgba(105, 0, 132, .2)',
                    ],
                    borderColor: [
                        'rgba(200, 99, 132, .7)',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true
            }
        });

        var ctx2 = document.getElementById("invoice").getContext('2d');
        var dataset2 = document.getElementById("invoice").dataset;

        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ["@lang('invoices')"],
                datasets: [{
                    label: "@lang('Total of Invoices')",
                    data: [dataset2.int],
                    backgroundColor: [dataset2.color],
                    borderColor: [dataset2.border],
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
@endsection
