<?php

namespace Primitivo\Caixa;

use InvalidArgumentException;

class Agente
{
    protected string $nome;

    protected string $documento;

    protected ?string $logradouro = null;

    protected ?string $bairro = null;

    protected ?string $cidade = null;

    protected ?string $estado = null;

    protected ?string $cep = null;

    public function __construct(string $nome, string $documento)
    {
        $this->setNome($nome);
        $this->setDocumento($documento);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        if (strlen($nome) > 40) {
            throw new InvalidArgumentException('O nome deve conter, no máximo, 40 caracteres.');
        }

        $this->nome = $nome;

        return $this;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): void
    {
        $this->documento = $documento;
    }
}
