<?php

namespace App\Utils;

class Moeda
{

    public static function onlyNumbers($str)
    {
        $str = preg_replace('/\D/', '', $str);
        return $str;
    }

    public static function MoedaDB($moeda)
    {
        if(!is_numeric($moeda))
        {
            $moeda = str_replace(".", "", $moeda);
            $moeda = str_replace(",", ".", $moeda);
        }
        return $moeda;
    }

    public static function MoedaBR($getValor)
    {
        return number_format($getValor,2,",",".");
    }
}