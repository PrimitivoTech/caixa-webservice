<?php

namespace Primitivo\Caixa\Enums;

enum Juros: string
{
    case VALOR_POR_DIA = 'VALOR_POR_DIA';
    case TAXA_MENSAL   = 'TAXA_MENSAL';
    case ISENTO        = 'ISENTO';
}
