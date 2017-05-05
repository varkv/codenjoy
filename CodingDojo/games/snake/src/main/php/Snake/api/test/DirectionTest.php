<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api;

/**
 * Description of DirectionTest
 *
 * @author Kirill_Korol
 * 
 */
require_once '../Direction.php';
require_once '../BoardPoint.php';



assert(isset(Direction::$UP), 'Direction::$UP must be isset');
assert(isset(Direction::$DOWN), 'Direction::$DOWN must be isset');
assert(isset(Direction::$LEFT), 'Direction::$LEFT must be isset');
assert(isset(Direction::$RIGHT), 'Direction::$RIGHT must be isset');
assert(isset(Direction::$STOP), 'Direction::$STOP must be isset');
assert(isset(Direction::$ACT), 'Direction::$ACT must be isset');

$offset = 1;
assert(Direction::$UP->changeX($offset) == Direction::$UP->getDx() + $offset, 
        sprintf('Direction::$UP changeX must be <%d> but now <%d>', Direction::$UP->getDx() + $offset, Direction::$UP->changeX($offset)));
assert(Direction::$UP->changeY($offset) == Direction::$UP->getDy() + $offset, 
        sprintf('Direction::$UP changeX must be <%d> but now <%d>', Direction::$UP->getDy() + $offset, Direction::$UP->changeY($offset)));


assert(Direction::$UP->inverted() == Direction::$DOWN, 'Inverted Direction::$UP must be Direction::$DOWN');
assert(Direction::$DOWN->inverted() == Direction::$UP, 'Inverted Direction::$DOWN must be Direction::$UP');
assert(Direction::$LEFT->inverted() == Direction::$RIGHT, 'Inverted Direction::$LEFT must be Direction::$RIGHT');
assert(Direction::$RIGHT->inverted() == Direction::$LEFT, 'Inverted Direction::$RIGHT must be Direction::$LEFT');

assert(Direction::$UP->clockwise() == Direction::$RIGHT, 'Clockwise Direction::$UP must be Direction::$RIGHT');
assert(Direction::$RIGHT->clockwise() == Direction::$DOWN, 'Clockwise Direction::$RIGHT must be Direction::$DOWN');
assert(Direction::$DOWN->clockwise() == Direction::$LEFT, 'Clockwise Direction::$DOWN must be Direction::$LEFT');
assert(Direction::$LEFT->clockwise() == Direction::$UP, 'Clockwise Direction::$LEFT must be Direction::$UP');

$given = new BoardPoint(10, 10);
$expected = new BoardPoint(9, 10);
assert(Direction::$LEFT->change($given) == $expected, sprintf('Set target by point <%s> and using Direction::$LEFT function change must be <%s> but now <%s>',
        $given, $expected, Direction::$LEFT->change($given)));
