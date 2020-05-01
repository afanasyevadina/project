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

    public static function monthDays($month, $year)
    {
        switch ($month) {
            case '01': case '03': case '05': case '07': case '08': case '10': case '12': 
                return 31;
                break;
            case '04': case '06': case '09': case '11':
                return 30;
                break;
            case '02':
                return $year % 4 ? 28 : 29;
                break;
        }
    }

    public static function month($month)
    {
        return @[
            '01' => 'Январь',
            '02' => 'Февраль',
            '03' => 'Март',
            '04' => 'Апрель',
            '05' => 'Май',
            '06' => 'Июнь',
            '07' => 'Июль',
            '08' => 'Август',
            '09' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        ][$month];
    }
}
