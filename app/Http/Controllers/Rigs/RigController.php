<?php

namespace App\Http\Controllers\Rigs;

use Auth;
use Carbon\Carbon;
use App\MinerStatistics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RigController extends Controller
{
    protected $statistics;

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
     * Show the rigs dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->statistics = $this->getRigsStatistics(120);
        return view('rigs', [
            'page_title' => 'Mining Rigs',
            'rigs' => $this->getLastStatistics(),
            'chart' => $this->chart()
        ]);
    }

    
    /**
     * Returns the miner statistics in a collection 
     * grouped by rig name.
     *
     * @param integer $offset
     * @param integer $limit
     * @param string $order (asc, desc)
     * @return void
     */
    public function getRigsStatistics($offset, $limit = 2500, $order = 'desc') 
    {
        try {
            return MinerStatistics::where('user_id', auth()->user()->id)
                ->where('created_at','>=', Carbon::now()->subMinutes($offset))
                ->orderBy('created_at', $order)
                ->take($limit)
                ->get()
                ->groupBy('rigname');
        } catch (Exception $e) {
            // Still waiting...
        }
        
    }

    public function getRigs() 
    {
        if(!$this->statistics) {
            $this->statistics = $this->getRigsStatistics(90);
        }

        $rigs = (object) [];
        foreach($this->statistics as $key => $value) {
            $rigs->$key = $key;
        }

        return $rigs;
    }

    public function getLastStatistics() 
    {
        if(!$this->statistics) {
            $this->statistics = $this->getRigsStatistics(120);
        }

        $response = (object) [];
        foreach($this->getRigs() as $key => $value) {
            $tableData = $this->statistics[$value]->where('created_at','>=', Carbon::now()->subSeconds(40));

            if (isset($tableData[0]) && $tableData !== []) {
                $response->$key = (object) $tableData[0];
                $response->$key->data = json_decode($tableData[0]['data'], true);
            } 
        }

        return $response;
    }

    private function chart() 
    {
        $start = Carbon::now('Europe/Brussels');
        $end = Carbon::now('Europe/Brussels')->subMinutes(120);
        $timeLabels = $this->createTimeRange($end, $start);

        $chart = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => '100%', 'height' => '20%'])
            ->labels($timeLabels)
            ->datasets($this->createDatasets($this->getChartData($timeLabels)))
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

    private function getChartData($timeLabels) 
    {
        $chartData = (object) [];
        // Go over each returned rig
        foreach($this->statistics as $key => $value) {

            $arr = array(); // Create an empty array to store our results
            // Go over all our timeLabels
            foreach(array_reverse($timeLabels) as $t => $timeLabel) {

                // Create a range to match the incomming created_at and timeLabels
                // Needs finetuning!!
                $start = Carbon::createFromFormat('H:i', $timeLabel)->subSeconds(60)->format('H:i:s');
                $end = Carbon::createFromFormat('H:i', $timeLabel)->addSeconds(60)->format('H:i:s');

                foreach ($value as $k => $v) {
                    // Transform created_at to the same format as $start and $end
                    $created = Carbon::createFromFormat('Y-m-d H:i:s', $v['created_at'])->format('H:i:s');
                    if($created >= $start && $created <= $end) {
                        if(!isset($v->data['hashrate'])){
                            $hashrate_ = json_decode($v->data,true)['hashrate'];
                        } else {
                            $hashrate_ = $v->data['hashrate'];
                        }

                        $arr[$timeLabel] = $hashrate_;
                    } 
                }
                
                // If the set timeLabel has no value set to 0
                // Rig is not running...
                if (!isset($arr[$timeLabel])) {
                    $arr[$timeLabel] = '0';
                }

            }
            $chartData->$key = $arr;
        }

        return $chartData;
    }

    private function chartData($label, $data, $color)
    {
        return [
            "label" => $label,
            'backgroundColor' => "rgba(" . $color . ", 0.1)",
            'borderColor' => "rgba(" . $color . ", 0.7)",
            "pointBorderColor" => "rgba(" . $color . ", 0, 0.7)",
            "pointBackgroundColor" => "rgba(" . $color . ", 0.7)",
            "pointHoverBackgroundColor" => "#fff",
            "pointHoverBorderColor" => "rgba(220,220,220,1)",
            'data' => $data,
        ];
    }

    private function createDatasets($chartData) 
    {
        $datasets = [];
        $n = 0;
        foreach($chartData as $key => $value) {
            $data = [];
            foreach ($value as $k => $v) {
                $data[] = $v;
            }
            $colors = [
                "0, 188, 212",
                "244, 67, 54",
                "255, 152, 0"
            ];

            $datasets[] = $this->chartData($key, array_reverse($data), $colors[$n++]);
        }

        return $datasets;
    }

    private function createTimeRange($start, $end, $interval = '5 mins', $format = '24') {
        $startTime = strtotime($start); 
        $endTime   = strtotime($end);

        $returnTimeFormat = ($format == '12')?'g:i A':'G:i';
    
        $current   = time(); 
        $addTime   = strtotime('+'.$interval, $current); 
        $diff      = $addTime - $current;
    
        $times = array(); 
        while ($startTime < $endTime) { 
            $times[] = date($returnTimeFormat, $startTime); 
            $startTime += $diff; 
        } 
        $times[] = date($returnTimeFormat, $startTime); 

        $result = [];
        foreach($times as $time) {
            $date = $time;
            $hours = Carbon::createFromFormat('H:i', $time)->format('H');
            $minutes = Carbon::createFromFormat('H:i', $time)->format('i');

            // round down to the nearest multiple of 5
            $minutes = floor($minutes / 5 ) * 5;

            // if $minutes is 0 or 5 we add a trailing 0
            if($minutes < 10) {
                $minutes = '0' . $minutes;
            }
            // output
            $result[] = $hours . ':' . $minutes;
        }

        return $result; 
    }
}
