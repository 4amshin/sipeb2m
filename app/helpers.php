<?php

use Carbon\Carbon;

if (!function_exists('formatWaktuBerangkat')) {
    function formatWaktuBerangkat($waktuBerangkat)
    {

        $waktu = Carbon::parse($waktuBerangkat);
        $hariIni = Carbon::today();

        if ($waktu->isSameDay($hariIni)) {
            return 'Hari ini, ' . $waktu->format('h:i A');
        } else {
            return $waktu->locale('id')->translatedFormat('h:i A, d F Y');
        }
    }

}

if (!function_exists('formatDate')) {
    function formatDate($tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        return $tanggal->locale('id')->translatedFormat('d F Y');
    }
}
