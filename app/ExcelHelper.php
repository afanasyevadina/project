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

    public static function normalize($str)
    {
    	return $str ? mb_strtoupper(mb_substr($str, 0, 1)).mb_strtolower(mb_substr($str, 1)) : '';
    }
}
