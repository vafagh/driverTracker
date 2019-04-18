<?php

namespace App;

use Carbon\Carbon;
use Locations;

class Helper
{

    public static function locations($op1,$sortBy)
    {
        $cliName='';
        foreach (Location::where('type',$op1)->orderBy($sortBy)->get() as $location){
            $locName = str_replace('"','',$location->name);
            if($sortBy=='longName')  $cliName .= '"'.$locName.'":"'.$locName.'",';
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

}
