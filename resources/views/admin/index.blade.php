@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Admin Panel</h1>
        </div>
    </div>
    <div id="ordersChart" style="width:100%; height:400px;"></div>
@endsection

@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('ordersChart', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Monthly Orders'
                },
                xAxis: {
                    categories: {!! json_encode($months) !!}, // Meseci
                    title: {
                        text: 'Month'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Orders'
                    }
                },
                tooltip: {
                    shared: true,
                    crosshairs: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                    name: 'Orders',
                    data: {!! json_encode($orderCounts) !!} // Broj porudžbina
                }]
            });
        });
    </script>
@endsection
