@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Admin Panel</h1>
        </div>
    </div>
    <div id="ordersChart" style="width:100%; height:400px;"></div>
    <div id="ordersWeekChart" style="width:100%; height:400px;"></div>
@endsection

@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart za porudžbine po mesecima
            Highcharts.chart('ordersChart', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Monthly Orders'
                },
                xAxis: {
                    categories: {!! json_encode($months) !!},
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
                    data: {!! json_encode($orderCounts) !!}
                }]
            });

            // Chart za porudžbine po nedeljama
            const chart = Highcharts.chart('ordersWeekChart', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Orders in the Last 10 Weeks'
                },
                xAxis: {
                    categories: {!! json_encode($weeks) !!}, // Kategorije - nedelje
                    title: {
                        text: 'Week'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Orders'
                    }
                },
                series: [{
                    name: 'Orders',
                    data: {!! json_encode($orderCountsPerWeek) !!} // Broj porudžbina po nedeljama
                }]
            });

        });
    </script>
@endsection