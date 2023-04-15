<?php

use function PHPUnit\Framework\assertEquals;

use Primitivo\Caixa\Agente;

it('should ensure that name and document are required for a new instance', function () {
    $agente = new Agente('João da Silva', '27431897111');

    assertEquals('João da Silva', $agente->getNome());
    assertEquals('27431897111', $agente->getDocumento());
});

it('should ensure that the name does not have more than forty chars for name', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O nome deve conter, no máximo, 40 caracteres.');

    new Agente(str_repeat('a', 41), '27431897111');
});

it('should ensure that document is a valid CPF', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Documento apresentado é inválido: CPF');

    new Agente('João da Silva', '11111111111');
});

it('should ensure that document is a valid CNPJ', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Documento apresentado é inválido: CNPJ');

    new Agente('João da Silva', '11111111111111');
});
