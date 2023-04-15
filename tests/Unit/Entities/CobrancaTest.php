<?php

use function PHPUnit\Framework\assertTrue;

use Primitivo\Caixa\Entities\Cobranca;

it('should ensure that properties are readonly', function () {
    $cobranca = new Cobranca(
        codigoBarras: '010412345670123009123091203912877656129871223334',
        linhaDigitavel: '010412345670123009123091203912877656129871223334',
        nossoNumero: '123456',
        urlBoleto: 'https://webservices.caixa.gov.br/emiteBoleto/something-here'
    );

    $reflection = new ReflectionClass($cobranca);

    foreach ($reflection->getProperties() as $property) {
        assertTrue($property->isReadOnly());
    }
});
