<?php

namespace App;

use Carbon\Carbon;

class Helper
{

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
