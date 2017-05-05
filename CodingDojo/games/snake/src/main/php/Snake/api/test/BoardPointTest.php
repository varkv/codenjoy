<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api;

/**
 * Description of BoardPointTest
 *
 * @author Kirill_Korol
 * 
 */
require_once '../BoardPoint.php';




$point = new BoardPoint(10, 10);
assert(!$point->isOutOfBoard(20), 'Точка должна быть на доске в 20 блоков');
assert($point->isOutOfBoard(5), 'Точка не должна быть на доске в 5 блоков');

$expected = new BoardPoint(9, 10);
assert($point->shiftLeft(1) == $expected, sprintf('Cдвиг влево должен возвращать точку <%s>. Сейчас: <%s>', $point->shiftLeft(1), $expected));
$expected = new BoardPoint(11, 10);
assert($point->shiftRight(1) == $expected, sprintf('Cдвиг вправо должен возвращать точку <%s>. Сейчас: <%s>', $point->shiftRight(1), $expected));
$expected = new BoardPoint(10, 9);
assert($point->shiftTop(1) == $expected, sprintf('Cдвиг вверх должен возвращать точку <%s>. Сейчас: <%s>', $point->shiftTop(1), $expected));
$expected = new BoardPoint(10, 11);
assert($point->shiftBottom(1) == $expected, sprintf('Cдвиг вниз должен возвращать точку <%s>. Сейчас: <%s>', $point->shiftBottom(1), $expected));


