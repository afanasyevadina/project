<?php

namespace App;
use App\CollegeGraphic;

class DateConvert
{
    public static function convert($date, $group = null)
    {
        $time = strtotime($date);
        $graphic = CollegeGraphic::where('start1', '<=', $date)
        ->where('end2', '>=', $date)->first();
        if($graphic) {
            if(strtotime($graphic->end1) >= $time)
                return [
                    'year' => $graphic->year,
                    'semestr' => 1
                ];
            if(strtotime($graphic->start2) <= $time)
                return [
                    'year' => $graphic->year,
                    'semestr' => 2
                ];
        }
        return null;
    }
}
