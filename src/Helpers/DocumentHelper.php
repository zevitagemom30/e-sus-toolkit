<?php

namespace App\Helpers;

class DocumentHelper
{
    public static function validateCPF(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $rest = $sum % 11;
        $digit1 = ($rest < 2) ? 0 : 11 - $rest;

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $rest = $sum % 11;
        $digit2 = ($rest < 2) ? 0 : 11 - $rest;

        if ($cpf[9] != $digit1 || $cpf[10] != $digit2) {
            return false;
        }

        return true;
    }

    public static function validateCNS(string $cns): bool
    {
        if (strlen(trim($cns)) != 15) {
            return false;
        }

        $sum = 0;
        $rest = 0;
        $dv = 0;
        $pis = substr($cns, 0, 11);
        $result = '';

        for ($i = 0; $i < 11; $i++) {
            $sum += intval($pis[$i]) * (15 - $i);
        }

        $rest = $sum % 11;
        $dv = 11 - $rest;

        if ($dv == 11) {
            $dv = 0;
        }

        if ($dv == 10) {
            $sum = 0;
            for ($i = 0; $i < 11; $i++) {
                $sum += intval($pis[$i]) * (15 - $i);
            }
            $sum += 2;
            $rest = $sum % 11;
            $dv = 11 - $rest;
        }

        if ($dv == intval(substr($cns, 11, 1))) {
            $result = $pis . '001' . strval($dv);
        } else {
            $result = $pis . '000' . strval($dv);
        }

        return $cns == $result;
    }

    public static function validateCNSProv($cns): bool
    {
        if (strlen(trim($cns)) != 15) {
            return false;
        }

        $sum = 0;
        $rest = 0;

        for ($i = 0; $i < 15; $i++) {
            $sum += intval($cns[$i]) * (15 - $i);
        }

        $rest = $sum % 11;

        return $rest == 0;
    }
}
