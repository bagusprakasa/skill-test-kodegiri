<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function logic()
    {

        $input = ['11', '12', 'cii', '001', '2', '1998', '7', '89', 'iia', 'fii'];
        $result = [];

        // Filter hanya elemen-elemen yang berisi huruf saja
        $letters = array_filter($input, function ($item) {
            return ctype_alpha($item);
        });

        // Kelompokkan substring secara leksikografis
        foreach ($letters as $item) {
            $substrings = [];
            $length = strlen($item);

            for ($i = 0; $i < $length; $i++) {
                for ($j = $i + 1; $j <= $length; $j++) {
                    $substrings[] = substr($item, $i, $j - $i);
                }
            }

            $result[$item] = array_unique($substrings);
        }

        // Menggabungkan semua substring menjadi satu set
        $finalSet = [];
        foreach ($result as $substrings) {
            $finalSet = array_merge($finalSet, $substrings);
        }
        $finalSet = array_unique($finalSet);

        // Cetak hasil
        foreach ($result as $item => $substrings) {
            echo "$item = {" . implode(", ", $substrings) . "}\n";
        }

        echo "S = {" . implode(", ", $finalSet) . "}\n";
    }
}
