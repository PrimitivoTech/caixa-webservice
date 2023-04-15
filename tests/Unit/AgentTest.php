<?php

use function PHPUnit\Framework\assertEquals;

use Primitivo\Caixa\Agente;

it('should ensure that name and document are required for a new instance', function () {
    $agente = new Agente('João da Silva', '27431897111');

    assertEquals('JOAO DA SILVA', $agente->getNome());
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

it('should ensure that logradouro does not have more than forty chars', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O logradouro deve ter no máximo 40 caracteres');

    $agente = new Agente('João da Silva', '27431897111');
    $agente->setLogradouro(str_repeat('a', 41));
});

it('should ensure that logradouro must be in uppercase and without accents', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setLogradouro('Rua João Carroceiro');

    assertEquals('RUA JOAO CARROCEIRO', $agente->getLogradouro());
});

it('should ensure that bairro does not have more than fifteen chars', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O bairro deve ter no máximo 15 caracteres');

    $agente = new Agente('João da Silva', '27431897111');
    $agente->setBairro(str_repeat('a', 16));
});

it('should ensure that bairro must be in uppercase and without accents', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setBairro('Maracanã');

    assertEquals('MARACANA', $agente->getBairro());
});

it('should ensure that cidade does not have more than fifteen chars', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('A cidade deve ter no máximo 15 caracteres');

    $agente = new Agente('João da Silva', '27431897111');
    $agente->setCidade(str_repeat('a', 16));
});

it('should ensure that cidade must be in uppercase and without accents', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setCidade('São Paulo');

    assertEquals('SAO PAULO', $agente->getCidade());
});
