<?php

use Primitivo\Caixa\Agente;
use Primitivo\Caixa\Enums\UF;

use function PHPUnit\Framework\{assertEquals, assertInstanceOf, assertNull};

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
    $this->expectExceptionMessage('Documento apresentado é inválido.');

    new Agente('João da Silva', '11111111111');
});

it('should ensure that document is a valid CNPJ', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Documento apresentado é inválido.');

    new Agente('João da Silva', '11111111111111');
});

it('should set logradouro as null', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setLogradouro(null);

    assertNull($agente->getLogradouro());
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

it('should set bairro as null', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setBairro(null);

    assertNull($agente->getBairro());
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

it('should set cidade as null', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setCidade(null);

    assertNull($agente->getCidade());
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

it('should set cep as null', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setCep(null);

    assertNull($agente->getCep());
});

it('should set an state or null on the estado field', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setEstado(UF::MINAS_GERAIS);

    $result = $agente->getEstado();

    assertInstanceOf(UF::class, $result);
});

it('should convert a string to enum when setting state', function (string $estado) {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setEstado($estado);

    assertInstanceOf(UF::class, $agente->getEstado());
})->with(['MG', 'sp']);

it('should throw an exception if state does not match with enum values', function (?string $estado) {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O estado é invalido. Você deve force a sigla do estado ou um enum do tipo ' . UF::class);

    $agente = new Agente('João da Silva', '27431897111');
    $agente->setEstado($estado);
})->with(['Minas Gerais']);

it('should throw an exception if cep length is different from 8 chars', function (string $cep) {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('O CEP deve ter 8 caracteres.');

    $agente = new Agente('João da Silva', '27431897111');
    $agente->setCep($cep);
})->with(['39400', '39401-4042']);

it('remove mask from cep before check its length', function () {
    $agente = new Agente('João da Silva', '27431897111');
    $agente->setCep('39400-000');

    assertEquals('39400000', $agente->getCep());
});
