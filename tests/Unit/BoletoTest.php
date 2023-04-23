<?php

use Carbon\Carbon;
use Primitivo\Caixa\Boleto;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

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
