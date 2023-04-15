<?php

namespace Primitivo\Caixa\Entities;

class Cobranca
{
    public function __construct(
        protected readonly string $codigoBarras,
        protected readonly string $linhaDigitavel,
        protected readonly string $nossoNumero,
        protected readonly string $urlBoleto
    ) {
    }
}
