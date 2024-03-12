<?php

namespace App\Traits;

trait FormatDate {
    public function to_readable($date)
    {
        $days = [
            "senin",
            "senin",
            "selasa",
            "rabu",
            "kamis",
            "jumat",
            "sabtu",
            "minggu",
        ];

        $months = [
            "januari",
            "februari",
            "maret",
            "april",
            "mei",
            "juni",
            "juli",
            "agustus",
            "september",
            "oktober",
            "november",
            "desember",
        ];

        $day = $days[(int)date('w', strtotime($date))];
        $month = $months[(int)date('m', strtotime($date)) - 1];

        return ucwords($day.", ".date('m', strtotime($date))." ".$month." ".date('Y', strtotime($date)));
    }
}