<?php

namespace App;

use Carbon\Carbon;
use Locations;

class Helper
{

    //Use: when($rideable,$ahead = true,$forceChoiceSaturday = true)['date', 'shift', 'day']
    public static function when($rideable,$ahead = true,$forceChoiceSaturday = true)
    {
        $forceMorning = false;
        $forceFriday = false;
        $today = new Carbon();
        $today = $today->format('Y-m-d');
        $tomorrow = new Carbon('tomorrow');
        $tomorrow = $tomorrow->format('Y-m-d');
        $currentHoure = date('H');
        $day = date("l");
        $m = 'Morning';
        $e = 'Evening';
        if($ahead){
            $start = 9;
            $middle = 13;
        }else{
            $start = 13;
            $middle = 16;
        }
        if (empty($rideable->delivery_date) || $rideable->status == 'Reschedule' ||  $rideable->status == 'BackOrdered' ) {
            if($day == 'Friday' && $forceFriday){
                $deliverydate = 0;
            }elseif($day == 'Saturday') {
                $mondey = new Carbon('next monday');
                $deliverydate = $mondey->format('Y-m-d');
                $forceMorning = true;
                $ahead = false;
            }else $deliverydate = $today;
            if(($ahead && $currentHoure >= $start && $currentHoure <= $middle) || (!$ahead && $currentHoure > $middle) ){
                $shift = $e;
            }else {
                $shift = $m;
                }
            if($ahead && $currentHoure >= $middle){
                $deliverydate = $tomorrow;
                $shift = $m;
            }
        }else{
            $deliverydate = $rideable->delivery_date;
            $shift = $rideable->shift;
        }
        return array('date' => $deliverydate, 'shift' => $shift, 'day' => $day);
    }

    public static function locations($op1,$sortBy)
    {
        $cliName='';
        foreach (Location::where('type',$op1)->orderBy($sortBy)->get() as $location){
            $locName = str_replace('"','',$location->name);
            if($sortBy=='name')  $cliName .= '"'.$locName.'":"'.$locName.'",';
            else                 $cliName .= '"'.$locName.'":"'.$location->phone.' , '.$locName.'",';
        }
        return $cliName;
    }

    public static function shift($shiftName, $tolerance = 4)
    {
        switch ($shiftName) {
            case 'Morning':
            return array('starts' => 8, 'ends' => 14, 'tolerance' => $tolerance);
            break;

            case 'Evening':
            return array('starts' => 14, 'ends' => 18, 'tolerance' => $tolerance);
            break;

            default:
            return 'Wrong call. Eather Morning or Evening. Helper::shift("Morning")';
            break;
        }
    }

    public static function col($min)
    {
        while(is_float(12/$min)) $min+=1;
        return 12/$min;
    }

    public static function dateName($date)
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
        switch ($date) {
            case $yesterday:
            $dateName = 'Yesterday';
            break;

            case $today:
            $dateName = 'Today';
            break;

            case $tomorrow:
            $dateName = 'Tomorrow';
            break;

            default:
            $dateName = $date;
            break;
        }
        return $dateName;
    }

    public static function valuePrint($value)
    {
        $flaten = null;
        if (gettype($value)=='array' && !empty($value)){
            $flaten .= '<table class="border">';
            $flaten .= '<tr>';
                foreach ($value as $key => $v){
                        $flaten .= Helper::valuePrint($v);
                }
                $flaten .= '</tr>';
                $flaten .= '</table>';
        }elseif(!empty($value)){
            $ext = substr($value, -4);
            // $flaten = ;
            $flaten = ($ext=='.jpg' || $ext=='.png') ? '<td class="border p-2"><img src="/img/driver/'.$value.'" height="30px"></td>' : '<td class="border p-2">'.$value.'</td>';
        }
        return $flaten;
    }

    public static function filter($value)
    {
        $finished = ['Done','Returned','NotAvailable','Pulled','NoData','Return','Closed','Nobody','NoMoney','Canceled','NoTicket','NoTime','Damaged','Wrong'];
        $ongoing = ['Created','OnTheWay','NotAvailable','DriverDetached','Reschedule','BackOrdered','Ready'];

        switch ($value){
            case 'finished':
            $status = $finished;
            break;

            case 'ongoing':
            $status = $ongoing;
            break;

            case 'all':
            $status = array_merge($finished,$ongoing);
            break;

            default:
            dd('$value was empty. please set "finished" or "ongoing" or "all" '. $value);

        }
        return $status;
    }

    public static function queryFiller($r,$type = null){
        if($r->filled('shift')){
            if ($r->input('shift') === 0) {
                                        $field1 = ['shift', '=', null];
            }else{
                                        $field1 = ['shift', '=', $r->input('shift')];
            }
        }else {
                                        $field1 = ['id', '!=', 0];//to return all rows
        }

        if($r->filled('delivery_date')){
            if($r->input('delivery_date') == '0'){
                                        $field0 = ['delivery_date', '=', null];
            }elseif($r->input('delivery_date') == 'all'){
                                        $field0 = ['id',            '!=', 0]; // to return all rows
            }else{
                                        $field0 = ['delivery_date',  '=', $r->input('delivery_date')];
            }
        }elseif($type == "delivery"){
                                        $field0 = ['delivery_date', '=',  Carbon::today()->toDateString()];
        }else $field0 = ['id','!=', 0]; // to return all rows


        return ['shift' => $field1, 'delivery_date' => $field0];
    }

    public static function urlParser($value)
    {
        //
        return $value;
    }
}
