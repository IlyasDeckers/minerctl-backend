<?php

namespace App\Http\Controllers\Rigs;

use Auth;
use App\MinerStatistics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the wallet dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stats = MinerStatistics::where('user_id', Auth::user()->id)->get()->toArray();

        $rigs = array();
        foreach($stats as $key => $value) {
            $rigs[] = $value['rigname'];
        }
        $rigs = array_unique($rigs);
        
        $res = [];
        $table = [];
        foreach($rigs as $key => $value) {
            $res[$value] = MinerStatistics::where('rigname', $value)
                ->where('created_at','>=', \Carbon\Carbon::now()->subMinutes(20))
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
            $tableData = MinerStatistics::where('rigname', $value)
                ->where('created_at','>=', \Carbon\Carbon::now()->subSeconds(10))
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();

            if (isset($tableData)) {
                $table[$value] = $tableData;
            }
        }

        return view('rigs', [
            'rigs' => $table,
            'chart' => $this->chart($res)
        ]);
    }

    public function chart($data) 
    {
        $p = [];
        foreach($data as $key => $value) {
            $x = [];
            $time = [];
            foreach($value as $k => $v) {
                $time[] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v['created_at'])->format('H:i:s');
                $x[] = json_decode($v['data'], true);
            }

            $hashrate = [];
            foreach($x as $k => $v){
                $hashrate[] = $v['hashrate'];
            }
            $p[$key] = [ 'time' => $time, 'hashrate' => $hashrate ];
        }

        $datasets = [];
        $n = 0;
        foreach($p as $key => $value) {
            $colors = [
                "0, 188, 212",
                "244, 67, 54",
                "255, 152, 0"
            ];

            $datasets[] = $this->chartData('Hashrate: ' . $key, array_reverse($value['hashrate']), $colors[$n++]);
        }
        
        $chart = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => '100%', 'height' => '20%'])
            ->labels(array_reverse($time))
            ->datasets($datasets)
            ->optionsRaw("{ 
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                            beginAtZero: true   // minimum value will be 0.
                        }
                    }]
                }
            }");

        return $chart;
    }

    public function chartData($label, $data, $color)
    {
        return [
            "label" => $label,
            'backgroundColor' => "rgba(" . $color . ", 0)",
            'borderColor' => "rgba(" . $color . ", 0.7)",
            "pointBorderColor" => "rgba(" . $color . ", 0, 0.7)",
            "pointBackgroundColor" => "rgba(" . $color . ", 0.7)",
            "pointHoverBackgroundColor" => "#fff",
            "pointHoverBorderColor" => "rgba(220,220,220,1)",
            'data' => $data,
        ];
    }
}
