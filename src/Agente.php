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

        $this->nome = strtoupper(
            Helpers::unaccents($nome)
        );

        return $this;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): static
    {
        $documento = Helpers::unmask($documento);

        if (strlen($documento) == 11 && !Helpers::isCpf($documento)) {
            throw new InvalidArgumentException('Documento apresentado é inválido: CPF');
        }

        if (strlen($documento) == 14 && !Helpers::isCnpj($documento)) {
            throw new InvalidArgumentException('Documento apresentado é inválido: CNPJ');
        }

        $this->documento = $documento;

        return $this;
    }

    public function getLogradouro(): ?string
    {
        return $this->logradouro;
    }

    public function setLogradouro(?string $logradouro): static
    {
        if ($logradouro && strlen($logradouro) > 40) {
            throw new InvalidArgumentException('O logradouro deve ter no máximo 40 caracteres');
        }

        $this->logradouro = strtoupper(
            Helpers::unaccents($logradouro)
        );

        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(?string $bairro): static
    {
        if ($bairro && strlen($bairro) > 15) {
            throw new InvalidArgumentException('O bairro deve ter no máximo 15 caracteres');
        }

        $this->bairro = strtoupper(
            Helpers::unaccents($bairro)
        );

        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(?string $cidade): Agente
    {
        if ($cidade && strlen($cidade) > 15) {
            throw new InvalidArgumentException('A cidade deve ter no máximo 15 caracteres');
        }

        $this->cidade = strtoupper(
            Helpers::unaccents($cidade)
        );

        return $this;
    }
}
