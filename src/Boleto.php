<?php

declare(strict_types=1);

namespace Primitivo\Caixa;

use Carbon\Carbon;
use InvalidArgumentException;
use Primitivo\Caixa\Enums\Aceite;
use Primitivo\Caixa\Enums\Especie;
use Primitivo\Caixa\Enums\Operacao;
use Primitivo\Caixa\Enums\PosVencimento;
use Primitivo\Caixa\Enums\VersaoBoleto;

class Boleto
{
    protected const USUARIO_SERVICO = 'SGCBS02P';

    protected const SISTEMA_ORIGEM = 'SIGCB';

    protected const MOEDA = '09';

    protected string $convenio;

    protected string $cnpjBeneficiario;

    protected string $nossoNumero;

    protected Carbon $vencimento;

    protected string $numeroDocumento;

    protected float $valor;

    protected Especie $tipoEspecie = Especie::DM;

    protected Aceite $aceite = Aceite::NAO;

    protected float $juros = 0.00;

    protected float $abatimento = 0.00;

    protected ?PosVencimento $aposVencimento = null;

    protected int $diasAposVencimento = 1;

    protected array $fichaCompensacao = [];

    protected array $reciboPagador = [];

    protected ?Agente $pagador = null;

    protected VersaoBoleto $versaoBoleto = VersaoBoleto::CONVENCIONAL;

    protected Operacao $operacao = Operacao::INCLUSAO;

    public function getConvenio(): string
    {
        return $this->convenio;
    }

    public function setConvenio(string $convenio): static
    {
        if (strlen($convenio) > 7) {
            throw new InvalidArgumentException('O convênio deve ter no máximo 7 caracteres.');
        }

        $this->convenio = str_pad($convenio, 7, '0', STR_PAD_LEFT);

        return $this;
    }

    public function getCnpjBeneficiario(): string
    {
        return $this->cnpjBeneficiario;
    }

    public function setCnpjBeneficiario(string $cnpjBeneficiario): static
    {
        $cnpjBeneficiario = Helpers::unmask($cnpjBeneficiario);

        $isCpf  = Helpers::isCpf($cnpjBeneficiario);
        $isCnpj = Helpers::isCnpj($cnpjBeneficiario);

        if (!$isCpf && !$isCnpj) {
            throw new InvalidArgumentException('O documento do beneficiário é inválido.');
        }

        $this->cnpjBeneficiario = $cnpjBeneficiario;

        return $this;
    }

    public function getNossoNumero(): string
    {
        return $this->nossoNumero;
    }

    public function setNossoNumero(string $nossoNumero): static
    {
        if (strlen($nossoNumero) != 17) {
            throw new InvalidArgumentException('O nosso número deve ter 17 caracteres.');
        }

        if (!str_starts_with($nossoNumero, '14')) {
            throw new InvalidArgumentException('O nosso número deve começar com 14.');
        }

        $this->nossoNumero = $nossoNumero;

        return $this;
    }

    public function getVencimento(): Carbon
    {
        return $this->vencimento;
    }

    public function setVencimento(Carbon $vencimento): static
    {
        $this->vencimento = $vencimento;

        return $this;
    }

    public function getNumeroDocumento(): string
    {
        return $this->numeroDocumento;
    }

    public function setNumeroDocumento(string $numeroDocumento): static
    {
        if (strlen($numeroDocumento) > 11) {
            throw new InvalidArgumentException('O número do documento deve ter no máximo 11 caracteres.');
        }

        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): static
    {
        $this->valor = (float)number_format($valor, 2, '.', '');

        return $this;
    }

    public function getTipoEspecie(): Especie
    {
        return $this->tipoEspecie;
    }

    public function setTipoEspecie(Especie $tipoEspecie): static
    {
        $this->tipoEspecie = $tipoEspecie;

        return $this;
    }

    public function getAceite(): Aceite
    {
        return $this->aceite;
    }

    public function setAceite(Aceite $aceite): static
    {
        $this->aceite = $aceite;

        return $this;
    }

    public function getJuros(): float
    {
        return $this->juros;
    }

    public function setJuros(float $juros): static
    {
        $this->juros = (float)number_format($juros, 2, '.', '');

        return $this;
    }

    public function getAbatimento(): float
    {
        return $this->abatimento;
    }

    public function setAbatimento(float $abatimento): static
    {
        $this->abatimento = (float)number_format($abatimento, 2, '.', '');

        return $this;
    }

    public function getAposVencimento(): ?PosVencimento
    {
        return $this->aposVencimento;
    }

    public function setAposVencimento(?PosVencimento $aposVencimento): static
    {
        $this->aposVencimento = $aposVencimento;

        return $this;
    }
}
