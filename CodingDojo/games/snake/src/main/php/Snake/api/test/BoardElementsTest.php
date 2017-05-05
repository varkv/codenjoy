<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api;

/**
 * Description of BoardElementsTest
 *
 * @author Kirill_Korol
 * 
 */
require_once '../BoardElements.php';

assert(isset(BoardElements::$BAD_APPLE), 'BoardElements::$BAD_APPLE must be isset');
assert(isset(BoardElements::$GOOD_APPLE), 'BoardElements::$GOOD_APPLE must be isset');
assert(isset(BoardElements::$BREAK), 'BoardElements::$BREAK must be isset');
assert(isset(BoardElements::$HEAD_DOWN), 'BoardElements::$HEAD_DOWN must be isset');
assert(isset(BoardElements::$HEAD_LEFT), 'BoardElements::$HEAD_LEFT must be isset');
assert(isset(BoardElements::$HEAD_RIGHT), 'BoardElements::$HEAD_RIGHT must be isset');
assert(isset(BoardElements::$HEAD_UP), 'BoardElements::$HEAD_UP must be isset');
assert(isset(BoardElements::$TAIL_END_DOWN), 'BoardElements::$TAIL_END_DOWN must be isset');
assert(isset(BoardElements::$TAIL_END_LEFT), 'BoardElements::$TAIL_END_LEFT must be isset');
assert(isset(BoardElements::$TAIL_END_UP), 'BoardElements::$TAIL_END_UP must be isset');
assert(isset(BoardElements::$TAIL_END_RIGHT), 'BoardElements::$TAIL_END_RIGHT must be isset');
assert(isset(BoardElements::$TAIL_HORIZONTAL), 'BoardElements::$TAIL_HORIZONTAL must be isset');
assert(isset(BoardElements::$TAIL_VERTICAL), 'BoardElements::$TAIL_VERTICAL must be isset');
assert(isset(BoardElements::$TAIL_LEFT_DOWN), 'BoardElements::$TAIL_LEFT_DOWN must be isset');
assert(isset(BoardElements::$TAIL_LEFT_UP), 'BoardElements::$TAIL_LEFT_UP must be isset');
assert(isset(BoardElements::$TAIL_RIGHT_DOWN), 'BoardElements::$TAIL_RIGHT_DOWN must be isset');
assert(isset(BoardElements::$TAIL_RIGHT_UP), 'BoardElements::$TAIL_RIGHT_UP must be isset');
assert(isset(BoardElements::$NONE), 'BoardElements::$NONE must be isset');

assert(BoardElements::$NONE->getCh() == " ", 'getCh method of BoardElements::$NONE must return empty space <" ">');
assert(BoardElements::$NONE->getCh() != "!", 'getCh method of BoardElements::$NONE must return empty space <" ">');

assert(BoardElements::valueOf(" ") == BoardElements::$NONE, 'valueOf <" ">  must be BoardElements::$NONE');
assert(BoardElements::valueOf(" ") != BoardElements::$BREAK, 'valueOf <" ">  must not be BoardElements::$BREAK');
assert(BoardElements::valueOf("☼") == BoardElements::$BREAK, 'valueOf <"☼">  must be BoardElements::$BREAK');