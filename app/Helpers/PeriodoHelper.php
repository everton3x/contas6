<?php

namespace App\Helpers;

class PeriodoHelper
{
    public static function next($periodo)
    {
        $year = (int) substr($periodo, 0, 4);
        $month = (int) substr($periodo, 5, 2);

        switch ($month) {
            case 12:
                $year++;
                $month = 1;
                break;
            default:
                $month++;
                break;
        }

        return sprintf('%04d-%02d', $year, $month);
    }

    public static function previous($periodo)
    {
        $year = (int) substr($periodo, 0, 4);
        $month = (int) substr($periodo, 5, 2);

        switch ($month) {
            case 1:
                $year--;
                $month = 12;
                break;
            default:
                $month--;
                break;
        }

        return sprintf('%04d-%02d', $year, $month);
    }

    public static function fmt($periodo)
    {
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        return $meses[(int) substr($periodo, 5, 2)] . ' de ' . substr($periodo, 0, 4);
    }

    public static function nextVencimento(?string $vencimento): ?string
    {
        if(is_null($vencimento)) return null;

        $year = (int) substr($vencimento, 0, 4);
        $month = (int) substr($vencimento, 5, 2);
        $day = (int) substr($vencimento, 8, 2);

        $proximo_periodo = self::next(sprintf('%04d-%02d', $year, $month));
        $year = (int) substr($proximo_periodo, 0, 4);
        $month = (int) substr($proximo_periodo, 5, 2);
        while(checkdate($month, $day, $year) === false) {
            $day--;
        }

        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
}
