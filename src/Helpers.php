<?php

namespace Primitivo\Caixa;

class Helpers
{
    public static function unmask(string $text = null): string
    {
        return preg_replace('/[\-\|\(\)\/\.\: ]/', '', $text);
    }

    public static function unaccents(string $text): string
    {
        $search  = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,ã,è,ì,ò,ù,ä,ë,ï,ö,õ,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,Ã,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
        $replace = explode(",", "c,ae,oe,a,e,i,o,u,a,a,e,i,o,u,a,e,i,o,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

        return str_replace($search, $replace, $text);
    }

    public static function isCnpj(?string $cnpj): bool
    {
        $valid = true;
        $cnpj  = str_pad(self::unmask($cnpj), 14, '0', STR_PAD_LEFT);

        if (!ctype_digit($cnpj)) {
            return false;
        }

        for ($x = 0; $x < 10; $x++) {
            if ($cnpj == str_repeat($x, 14)) {
                $valid = false;
            }
        }

        if ($valid) {
            if (strlen($cnpj) != 14) {
                $valid = false;
            } else {
                for ($t = 12; $t < 14; $t++) {
                    $d = 0;
                    $c = 0;

                    for ($m = $t - 7; $m >= 2; $m--, $c++) {
                        $d += $cnpj[$c] * $m;
                    }

                    for ($m = 9; $m >= 2; $m--, $c++) {
                        $d += $cnpj[$c] * $m;
                    }

                    $d = ((10 * $d) % 11) % 10;

                    if ($cnpj[$c] != $d) {
                        $valid = false;

                        break;
                    }
                }
            }
        }

        return $valid;
    }

    public static function isCpf(?string $cpf): bool
    {
        $valid = true;
        $cpf   = str_pad(self::unmask($cpf), 11, '0', STR_PAD_LEFT);

        if (!ctype_digit($cpf)) {
            return false;
        }

        for ($x = 0; $x < 10; $x++) {
            if ($cpf == str_repeat($x, 11)) {
                $valid = false;
            }
        }

        if ($valid) {
            if (strlen($cpf) != 11) {
                $valid = false;
            } else {
                for ($t = 9; $t < 11; $t++) {
                    $d = 0;

                    for ($c = 0; $c < $t; $c++) {
                        $d += $cpf[$c] * (($t + 1) - $c);
                    }

                    $d = ((10 * $d) % 11) % 10;

                    if ($cpf[$c] != $d) {
                        $valid = false;

                        break;
                    }
                }
            }
        }

        return $valid;
    }
}
