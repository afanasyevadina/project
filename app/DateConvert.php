<?php

namespace App;
use App\CollegeGraphic;
use App\Group;

class DateConvert
{
    public static function convert($date, $group = null)
    {
        $time = strtotime($date);
        if($group) {
            $grp = Group::find($group);
            $graphic = $grp->graphics()->where('start1', '<=', $date)
            ->where('end2', '>=', $date)->first();
        } else {
            $graphic = CollegeGraphic::where('start1', '<=', $date)
            ->where('end2', '>=', $date)->first();
        }
        if($graphic) {
            if(strtotime($graphic->end1) >= $time)
                return [
                    'year' => $graphic->year,
                    'semestr' => 1,
                    'day' => date('N', $time),
                    'week' => ceil(($time + 1 - strtotime($graphic->start1)) / (3600*24*7)) % 2 ? 1 : 2
                ];
            if(strtotime($graphic->start2) <= $time)
                return [
                    'year' => $graphic->year,
                    'semestr' => 2,
                    'day' => date('N', $time),
                    'week' => ceil(($time + 1 - strtotime($graphic->start2)) / (3600*24*7)) % 2 ? 1 : 2
                ];
        }
        return null;
    }
}
