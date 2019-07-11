<?php

namespace App;

use Carbon\Carbon;
use Locations;

class Helper
{

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
        if (empty($rideable->delivery_date)) {
            if($day == 'Friday' && $forceFriday){
                $deliverydate = 0;
            }elseif($day == 'Saturday') {
                $mondey = new Carbon('next monday');
                $deliverydate = $mondey->format('Y-m-d');
                $forceMorning = true;
                $ahead = false;
            }else $deliverydate = $today;

            if(($ahead && $currentHoure >= $start && $currentHoure <= $middle) || (!$ahead && $currentHoure >= $middle) ){
                $shift = $e;
            }else $shift = $m;

            if($ahead && $currentHoure >= $middle){
                $deliverydate = $tomorrow;
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
            else                    $cliName .= '"'.$locName.'":"'.$location->phone.' , '.$locName.'",';
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
            return array('starts' => 15, 'ends' => 18, 'tolerance' => $tolerance);
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
            $flaten = '<td class="border p-2">'.$value.'</td>';
        }
        return $flaten;
    }

}
