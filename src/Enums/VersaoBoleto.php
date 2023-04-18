<?php

namespace Primitivo\Caixa\Enums;

enum VersaoBoleto: string
{
    case CONVENCIONAL = '3.0';
    case HIBRIDO      = '3.2';
    case TOKEN        = '4.0';
}
