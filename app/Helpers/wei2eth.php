<?php
namespace App\Helpers;

class wei2eth {
	/*
    * The following functions are for conversion
    * and for handling big numbers
    */
    public static function convert($wei)
    {
        return bcdiv($wei,1000000000000000000,18);
    }

/*    function bchexdec($hex) 
    {
        if(strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, $this->bchexdec($remain)), hexdec($last));
        }
    }*/
}