<?php

namespace Primitivo\Caixa;

use Carbon\Carbon;

class Boleto
{
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

    protected int $codigoMoeda = 9;

    protected array $fichaCompensacao = [];

    protected array $reciboPagador = [];

    protected ?Agente $pagador = null;
}
