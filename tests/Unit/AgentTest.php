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
