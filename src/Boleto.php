<?php

declare(strict_types=1);

namespace Primitivo\Caixa;

use Carbon\Carbon;
use InvalidArgumentException;
use Primitivo\Caixa\Enums\Operacao;
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

    protected string $tipoEspecie = '02';

    protected string $aceite = 'N';

    protected float $juros = 0.00;

    protected float $abatimento = 0.00;

    protected ?string $aposVencimento;

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
}
