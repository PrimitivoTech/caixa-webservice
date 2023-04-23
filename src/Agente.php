<?php

namespace Primitivo\Caixa;

use InvalidArgumentException;
use Primitivo\Caixa\Enums\UF;

class Agente
{
    protected string $nome;

    protected string $documento;

    protected ?string $logradouro = null;

    protected ?string $bairro = null;

    protected ?string $cidade = null;

    protected ?UF $estado = null;

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

        $this->nome = strtoupper(Helpers::unaccents($nome));

        return $this;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): static
    {
        $documento = Helpers::unmask($documento);

        $isCpf  = Helpers::isCpf($documento);
        $isCnpj = Helpers::isCnpj($documento);

        if (!$isCpf && !$isCnpj) {
            throw new InvalidArgumentException('Documento apresentado é inválido.');
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
        if (!$logradouro) {
            $this->logradouro = null;

            return $this;
        }

        if (strlen($logradouro) > 40) {
            throw new InvalidArgumentException('O logradouro deve ter no máximo 40 caracteres');
        }

        $this->logradouro = strtoupper(Helpers::unaccents($logradouro));

        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(?string $bairro): static
    {
        if (!$bairro) {
            $this->bairro = null;

            return $this;
        }

        if (strlen($bairro) > 15) {
            throw new InvalidArgumentException('O bairro deve ter no máximo 15 caracteres');
        }

        $this->bairro = strtoupper(Helpers::unaccents($bairro));

        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(?string $cidade): Agente
    {
        if (!$cidade) {
            $this->cidade = null;

            return $this;
        }

        if (strlen($cidade) > 15) {
            throw new InvalidArgumentException('A cidade deve ter no máximo 15 caracteres');
        }

        $this->cidade = strtoupper(Helpers::unaccents($cidade));

        return $this;
    }

    public function getEstado(): ?UF
    {
        return $this->estado;
    }

    public function setEstado(UF | string $estado = null): static
    {
        if ($estado instanceof UF || is_null($estado)) {
            $this->estado = $estado;

            return $this;
        }

        $estado = strtoupper($estado);

        if (!$estado = UF::tryFrom($estado)) {
            throw new InvalidArgumentException('O estado é invalido. Você deve force a sigla do estado ou um enum do tipo ' . UF::class);
        }

        $this->estado = $estado;

        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(?string $cep): static
    {
        if (!$cep) {
            $this->cep = null;

            return $this;
        }

        $cep = Helpers::unmask($cep);

        if (strlen($cep) != 8) {
            throw new InvalidArgumentException('O CEP deve ter 8 caracteres.');
        }

        $this->cep = $cep;

        return $this;
    }
}
