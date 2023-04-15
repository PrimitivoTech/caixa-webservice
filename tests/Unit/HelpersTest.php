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

it('should ensure that CNPJ is valid', function () {
    assertTrue(Helpers::isCnpj('63.024.642/0001-40'));
    assertFalse(Helpers::isCnpj('00.000.000/0000-00'));
    assertFalse(Helpers::isCnpj('11.111.111/1111-11'));
    assertFalse(Helpers::isCnpj('22.222.222/2222-22'));
    assertFalse(Helpers::isCnpj('33.333.333/3333-33'));
    assertFalse(Helpers::isCnpj('44.444.444/4444-44'));
    assertFalse(Helpers::isCnpj('55.555.555/5555-55'));
    assertFalse(Helpers::isCnpj('66.666.666/6666-66'));
    assertFalse(Helpers::isCnpj('77.777.777/7777-77'));
    assertFalse(Helpers::isCnpj('88.888.888/8888-88'));
    assertFalse(Helpers::isCnpj('99.999.999/9999-99'));
    assertFalse(Helpers::isCnpj('63.024.642'));
});

it('should ensure that CPF is valid', function () {
    assertTrue(Helpers::isCpf('570.616.604-81'));
    assertFalse(Helpers::isCnpj('000.000.000-00'));
    assertFalse(Helpers::isCnpj('111.111.111-11'));
    assertFalse(Helpers::isCnpj('222.222.222-22'));
    assertFalse(Helpers::isCnpj('333.333.333-33'));
    assertFalse(Helpers::isCnpj('444.444.444-44'));
    assertFalse(Helpers::isCnpj('555.555.555-55'));
    assertFalse(Helpers::isCnpj('666.666.666-66'));
    assertFalse(Helpers::isCnpj('777.777.777-77'));
    assertFalse(Helpers::isCnpj('888.888.888-88'));
    assertFalse(Helpers::isCnpj('999.999.999-99'));
    assertFalse(Helpers::isCnpj('570.616.604'));
});
