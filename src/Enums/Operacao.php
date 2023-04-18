<?php

namespace Primitivo\Caixa\Enums;

enum Operacao: string
{
    case INCLUSAO  = 'INCLUI_BOLETO';
    case BAIXA     = 'BAIXA_BOLETO';
    case ALTERACAO = 'ALTERA_BOLETO';
}
