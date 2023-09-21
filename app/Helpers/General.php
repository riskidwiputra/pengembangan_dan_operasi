<?php

if (!function_exists('usd_to_rupiah_format')) {
    function usd_to_rupiah_format($usd)
    {
        return 'Rp ' . number_format($usd * 14000, 2, ',', '.');
    }
}
