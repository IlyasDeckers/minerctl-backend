@extends('layouts.app')

@section('content')
<div class="row">
    @if($rigs !== [])
    @foreach($rigs as $key => $value)
    @if($value !== [])
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $key }}</h4>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary">
                            <tr>
                                <th>GPU</th>
                                <th>Hashrate</th>
                                <th>Temperature</th>
                                <th>Fanspeed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(json_decode($value[0]['data'],true)['gpus'] as $k => $v)
                            <tr>
                                <td>gpu{{ $k }}</td>
                                <td>{{ $v['hashrates'] }} MH/s</td>
                                <td>{{ $v['temperature'] }} &#176;C</td>
                                <td>{{ $v['fanSpeed'] }} %</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    @else
    <div class="col-md-12">
        <div class="text-center">
            <i class="material-icons" style="font-size: 80px; margin-top: 100px;">cloud_off</i>
            <h3>No Running Rigs</h3>
        </div>
    </div>
    @endif
    <!-- <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Hashrate</h4>
            </div>
            <div class="card-content">
                {!! $chart->render() !!}
            </div>
            
        </div>
    </div> -->
</div>
@endsection
