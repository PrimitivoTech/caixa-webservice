<?php

namespace Primitivo\Caixa;

class Agente
{
    public function __construct(
        protected string $nome,
        protected string $documento,
        protected ?string $logradouro,
        protected ?string $bairro,
        protected ?string $cidade,
        protected ?string $estado,
        protected ?string $cep,
    ) {
    }
}
