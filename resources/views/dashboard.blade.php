@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-md-12">
        <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header" data-background-color="rose" data-header-animation="true">
                <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-content">
                <div class="card-actions">
                    <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                        <i class="material-icons">build</i> Fix Header!
                    </button>
                    <button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
                        <i class="material-icons">refresh</i>
                    </button>
                    <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Change Date">
                        <i class="material-icons">edit</i>
                    </button>
                </div>
                <h4 class="card-title">Total Shares Last Hour</h4>
                <p class="category">{{ $total_stats->validShares }}</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Updated every 15 min
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header" data-background-color="green" data-header-animation="true">
                <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-content">
                <div class="card-actions">
                    <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                        <i class="material-icons">build</i> Fix Header!
                    </button>
                    <button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
                        <i class="material-icons">refresh</i>
                    </button>
                    <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Change Date">
                        <i class="material-icons">edit</i>
                    </button>
                </div>
                <h4 class="card-title">Total Hashrate</h4>
                <p class="category">
                    {{ $total_stats->reportedHashrate}} MH/s
                </p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> updated 4 minutes ago
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header" data-background-color="blue" data-header-animation="true">
                <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-content">
                <div class="card-actions">
                    <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                        <i class="material-icons">build</i> Fix Header!
                    </button>
                    <button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
                        <i class="material-icons">refresh</i>
                    </button>
                </div>
                <h4 class="card-title">Unpaid Balance</h4>
                <p class="category">{{ $total_stats->unpaid }} ETH</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> updated 4 minutes ago
                </div>
            </div>
        </div>
    </div>
    <div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Event Log</h4>
                </div>
                <div class="card-content table-responsive">
                    
                    @if(count($notifications_dash) > 0)
                    <table class="table table-hover">
                        <thead class="text-warning">
                        </thead>
                        <tbody>
                            @foreach($notifications_dash as $notification )
                            <tr class="{{ $notification->type }}">
                                <td>{{ $notification->created_at }}</td>
                                <td>{!! html_entity_decode($notification->message) !!}</td>
                                <td>{{ $notification->type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center">
                        <i class="material-icons" style="font-size: 80px;">event_busy</i>
                        <h3>No Events</h3>
                        <p><br> </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Active Workers</h4>
                </div>
                <div class="card-content table-responsive">
                    @if($miners)
                    <table class="table table-hover">
                        <thead class="text-warning">
                        </thead>
                        <tbody>
                            @foreach($miners as $miner)
                            <tr >
                                <td>{{ $miner->rigname }}</td>
                                <td>{{ $miner->data->hashrate }}</td>
                                <td>test</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center">
                        <i class="material-icons" style="font-size: 80px;">cloud_off</i>
                        <h3>No Active Workers</h3>
                        <p><a href="">Download</a> the application to get started</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection