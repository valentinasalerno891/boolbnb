
@extends('layouts.app')
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps.css'>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.64.0/maps/maps-web.min.js"></script>

@section('content')
    <div class="container">
        <div class="row pt-4">
            <div class="col-md-12">
            <canvas id="myChart-messages" class="chart"></canvas> 
        </div>
        <div class="col-md-12">
            <canvas id="myChart-views" class="chart"></canvas> 
        </div>
        </div>
    </div>
    {{-- @dd($messages) --}}
{{-- <body style="width: 100%; height: 100%; margin: 0; padding: 0;"> --}}
    
@endsection



@section('script')

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>

        // messages
        var messages = {!! $messages !!};
        console.log(messages);

        var labels = [];
        var data = [];
        for (var i = 0; i<messages.length; i++){
            labels.push(messages[i]['created_at']);
            data.push(messages[i]['total']);
        }

        console.log(labels);
        console.log(data);

        var ctx = $('#myChart-messages')[0].getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.reverse(),
                datasets: [{
                    label: 'Messaggi ricevuti',
                    data: data.reverse(),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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

        // messages
        var views = {!! $views !!};
        console.log(views);

        var labels = [];
        var data = [];
        for (var i = 0; i<views.length; i++){
            labels.push(views[i]['created_at']);
            data.push(views[i]['total']);
        }

        console.log(labels);
        console.log(data);

        var ctx = $('#myChart-views')[0].getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.reverse(),
                datasets: [{
                    label: 'Visualizzazioni dell\'appartamento',
                    data: data.reverse(),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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