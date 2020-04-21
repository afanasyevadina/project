<?php

namespace App;
class ExcelHelper
{
    public static function col($i)
    {
        $alp = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $len = strlen($alp);
        $lead = $i < $len ? '' : ($i < $len * 2 ? $alp[0] : $alp[1]);
        return $lead.$alp[$i % $len];
    }
}
