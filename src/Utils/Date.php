<?php

namespace App\Utils;

class Date
{
    public static function DataBanco($data)
    {
        return date("Y-m-d H:i:s",strtotime($data));
    }

    public static function DataBR($data)
    {
        return date("d/m/Y H:i:s",strtotime($data));
    }
}