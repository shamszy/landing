<?php

namespace App\Libs\Helpers;

/**
 * System helper
 */
class SystemHelper
{
    /**
     * generate code
     * @param $number
     * @return string
     */
    public function generateRandomCode($number): string
    {
        $today = date('YmdHis');
        $characters = '0123456789';
        $main = $today.$characters;
        $randomString = '';
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, strlen($main) - 1);
            $randomString .= $main[$index];
        }
        return $randomString;
    }

    /**
     * clean string coming from database
     * @param $string
     * @return mixed
     */
    public function cleanStringHelper($string): mixed
    {
        if (is_null($string)) {
            return "";
        }else {
            return $string;
        }
    }

    /**
     * convert money to kobo
     * @param $amount
     * @return float|int
     */
    public function convertToKobo($amount): float|int
    {
        return $amount * 100;
    }

    /**
     * convert kobo to naira
     * @param $amount
     * @return float|int
     */
    public function convertKoboToNaira($amount): float|int
    {
        return $amount / 100;
    }

    /**
     * generate slug from system
     * @param $param
     * @return string
     */
    public function systemSlugHelper($param): string
    {
        $cleanParam = str_replace(' ', '_', $param);
        return $cleanParam."_".$this->generateRandomCode(12);
    }

    /**
     * @param $type
     * @return string
     */
    public function generatePaymentReference($type): string
    {
        return $type . strtoupper(config('app.name')) . $this->generateRandomCode(25);
    }

}
