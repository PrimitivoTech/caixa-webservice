<?php

use Carbon\Carbon;
use Primitivo\Caixa\Boleto;
use Primitivo\Caixa\Enums\Aceite;
use Primitivo\Caixa\Enums\Especie;
use Primitivo\Caixa\Enums\PosVencimento;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;

it('should throw an exception if convenio length is greater than seven', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O convênio deve ter no máximo 7 caracteres.');

    $boleto = new Boleto();
    $boleto->setConvenio(str_repeat('a', 8));
});

it('should set the convenio', function () {
    $boleto = new Boleto();
    $boleto->setConvenio(1234567);

    assertEquals('1234567', $boleto->getConvenio());
});

it('should fill convenio with zero if its length is lower than seven', function () {
    $boleto = new Boleto();
    $boleto->setConvenio(12345);

    assertEquals('0012345', $boleto->getConvenio());
});

it('should set the CNPJ of the recipient', function () {
    $boleto = new Boleto();
    $boleto->setCnpjBeneficiario('76.134.272/0001-46');

    assertEquals('76134272000146', $boleto->getCnpjBeneficiario());
});

it('should set the CPF of the recipient', function () {
    $boleto = new Boleto();
    $boleto->setCnpjBeneficiario('826.528.431-41');

    assertEquals('82652843141', $boleto->getCnpjBeneficiario());
});

it('should throw an exception if CNPJ is invalid', function (string $cnpj) {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O documento do beneficiário é inválido.');

    $boleto = new Boleto();
    $boleto->setCnpjBeneficiario($cnpj);
})->with(['11.111.111/1111-11', '11.111.111', '111.111.111-11', '111.111.111']);

it('should throw an exception if nossoNumero length is not equals to seventeen', function (string $nossoNumero) {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O nosso número deve ter 17 caracteres.');

    $boleto = new Boleto();
    $boleto->setNossoNumero($nossoNumero);
})->with(['123456789012345678', '1234567890123456']);

it('should throw an exception if nossoNumero does not starts with fourteen', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O nosso número deve começar com 14.');

    $boleto = new Boleto();
    $boleto->setNossoNumero('12345678901234567');
});

it('should set nossoNumero', function () {
    $boleto = new Boleto();
    $boleto->setNossoNumero('14123456789012345');

    assertEquals('14123456789012345', $boleto->getNossoNumero());
});

it('should set vencimento property', function () {
    $carbon = new Carbon();

    $boleto = new Boleto();
    $boleto->setVencimento($carbon);

    $response = $boleto->getVencimento();

    assertInstanceOf(Carbon::class, $response);
    assertEquals($carbon, $response);
});

it('should throw an exception if numeroDocumento length is greater than 11 chars', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O número do documento deve ter no máximo 11 caracteres.');

    $boleto = new Boleto();
    $boleto->setNumeroDocumento(str_repeat('a', 12));
});

it('should set numeroDocumento field', function () {
    $boleto = new Boleto();
    $boleto->setNumeroDocumento('12345678901');

    assertEquals('12345678901', $boleto->getNumeroDocumento());
});

it('should set valor field', function ($value, $expected) {
    $boleto = new Boleto();
    $boleto->setValor($value);

    assertEquals($expected, $boleto->getValor());
})->with([
    'Integer Value' => [123, 123.00],
    'Float Value'   => [123.45, 123.45],
]);

it('should set tipoEspecie field', function () {
    $boleto = new Boleto();
    $boleto->setTipoEspecie(Especie::DM);

    assertInstanceOf(Especie::class, $boleto->getTipoEspecie());
    assertEquals(Especie::DM, $boleto->getTipoEspecie());
});

it('should set aceite field', function () {
    $boleto = new Boleto();
    $boleto->setAceite(Aceite::SIM);

    assertInstanceOf(Aceite::class, $boleto->getAceite());
    assertEquals(Aceite::SIM, $boleto->getAceite());
});

it('should set juros field', function ($value, $expected) {
    $boleto = new Boleto();
    $boleto->setJuros($value);

    assertEquals($expected, $boleto->getJuros());
})->with([
    'Integer Value' => [123, 123.00],
    'Float Value'   => [123.45, 123.45],
]);

it('should set abatimento field', function ($value, $expected) {
    $boleto = new Boleto();
    $boleto->setAbatimento($value);

    assertEquals($expected, $boleto->getAbatimento());
})->with([
    'Integer Value' => [123, 123.00],
    'Float Value'   => [123.45, 123.45],
]);

it('should set aposVencimento instruction with PosVencimento enum', function () {
    $boleto = new Boleto();
    $boleto->setAposVencimento(PosVencimento::DEVOLVER);

    assertInstanceOf(PosVencimento::class, $boleto->getAposVencimento());
    assertEquals(PosVencimento::DEVOLVER, $boleto->getAposVencimento());
});

it('should set aposVencimento instruction with null', function () {
    $boleto = new Boleto();
    $boleto->setAposVencimento(null);

    assertNull($boleto->getAposVencimento());
});

it('should throw an exception if trying to set diasAposVencimento without setting aposVencimento field', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Você precisa informar a ação após o vencimento antes de setar os dias.');

    $boleto = new Boleto();
    $boleto->setDiasAposVencimento(1);
});

it('should throw an exception if diasAposVencimento is less than 1 or greater than 999', function ($number) {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Os dias após o vencimento devem estar entre 1 e 999.');

    $boleto = new Boleto();
    $boleto->setAposVencimento(PosVencimento::PROTESTAR);
    $boleto->setDiasAposVencimento($number);
})->with([
    'Less than 1'      => [0],
    'Greater than 999' => [1000],
]);

it('should set diasAposVencimento property', function () {
    $boleto = new Boleto();
    $boleto->setAposVencimento(PosVencimento::PROTESTAR);
    $boleto->setDiasAposVencimento(1);

    assertEquals(1, $boleto->getDiasAposVencimento());
});
