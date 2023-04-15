<?php

use function PHPUnit\Framework\{assertEquals, assertFalse, assertNull, assertTrue};

use Primitivo\Caixa\Helpers;

it('should ensure to remove invalid characters', function () {
    $cpf  = '627.755.457-34';
    $cnpj = '63.024.642/0001-40';

    assertEquals('62775545734', Helpers::unmask($cpf));
    assertEquals('63024642000140', Helpers::unmask($cnpj));
    assertNull(Helpers::unmask());
});

it('should remove accents from a string', function () {
    $str = 'José Monção da Silva Nhô';

    assertEquals('Jose Moncao da Silva Nho', Helpers::unaccents($str));
});

it('should return null if the string is empty or null when removing accents', function (?string $text) {
    assertNull(Helpers::unaccents($text));
})->with(['', null]);

it('should ensure that CNPJ is valid', fn (string $cnpj) => assertTrue(Helpers::isCnpj($cnpj)))
    ->with([
        '63.024.642/0001-40',
        '32.012.154/0001-90',
        '17.718.374/0001-40',
        '01.652.592/0001-99',
    ]);

/** @covers Helpers::isCnpj() */
it('should ensure that CNPJ is invalid', fn (string $cnpj) => assertFalse(Helpers::isCnpj($cnpj)))
    ->with([
        '00.000.000/0000-00',
        '11.111.111/1111-11',
        '22.222.222/2222-22',
        '33.333.333/3333-33',
        '44.444.444/4444-44',
        '55.555.555/5555-55',
        '66.666.666/6666-66',
        '77.777.777/7777-77',
        '88.888.888/8888-88',
        '99.999.999/9999-99',
        '63.024.642',
        'abcdef',
        '123456789012345',
    ]);

it('should ensure that CPF is valid', fn (string $cpf) => assertTrue(Helpers::isCpf($cpf)))
    ->with([
        '570.616.604-81',
        '766.214.797-51',
        '211.897.202-48',
        '577.976.329-10',
    ]);

/** @covers Helpers::isCpf() */
it('should ensure that CPF is invalid', fn (string $cpf) => assertFalse(Helpers::isCnpj($cpf)))
    ->with([
        '000.000.000-00',
        '111.111.111-11',
        '222.222.222-22',
        '333.333.333-33',
        '444.444.444-44',
        '555.555.555-55',
        '666.666.666-66',
        '777.777.777-77',
        '888.888.888-88',
        '999.999.999-99',
        '570.616.604',
        'abcdef',
        '123456789012',
    ]);
