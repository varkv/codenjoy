<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api;

/**
 * Description of BoardTest
 *
 * @author Kirill_Korol
 * 
 */
require_once '../Board.php';
require_once '../BoardPoint.php';
require_once '../BoardElements.php';

$boardString = "☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼             ☼☼             ☼☼             ☼☼             ☼☼☺            ☼☼     ◄╕      ☼☼             ☼☼             ☼☼  ☻          ☼☼             ☼☼             ☼☼             ☼☼             ☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼";
$board = new Board($boardString);

$diedSnakeBoardString = "☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼             ☼☼             ☼☼             ☼☼             ☼☼☺            ☼☼╕            ☼☼             ☼☼             ☼☼  ☻          ☼☼             ☼☼             ☼☼             ☼☼             ☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼☼";
$diedSnakeBoard = new Board($diedSnakeBoardString);

assert($board->getSize() == 15, sprintf('Board size must be 15 but actual is %d', $board->getSize()));

$given = new BoardPoint(0, 1);
$expected = 15;
assert($board->getShiftByPoint($given) == $expected, sprintf('Board getShiftByPoint %s expected %d but actual is %d', $given, $expected, $board->getShiftByPoint($given)));

$given = 160;
$expected = new BoardPoint(10, 10);
assert($board->getPointByShift($given) == $expected, sprintf('Board getPointByShift %d expected %s but actual is %s', $given, $expected, $board->getPointByShift($given)));

$given = new BoardPoint(0, 0);
$expected = BoardElements::$BREAK;
assert($board->getElementAt($given) == $expected, sprintf('Board getElementAt %s expected %s but actual is %s', $given, $expected, $board->getElementAt($given)));

$given = new BoardPoint(0, 0);
$notExpected = BoardElements::$GOOD_APPLE;
assert($board->getElementAt($given) != $notExpected, sprintf('Board getElementAt %s not expected %s but actual is %s', $given, $notExpected, $board->getElementAt($given)));

$given = new BoardPoint(3, 9);
$expected = BoardElements::$BAD_APPLE;
assert($board->getElementAt($given) == $expected, sprintf('Board getElementAt %s expected %s but actual is %s', $given, $expected, $board->getElementAt($given)));

$given = new BoardPoint(3, 9);
$expected = BoardElements::$BAD_APPLE;
assert($board->getElementAt($given) == $expected, sprintf('Board getElementAt %s expected %s but actual is %s', $given, $expected, $board->getElementAt($given)));

$given1 = new BoardPoint(3, 9);
$given2 = BoardElements::$BAD_APPLE;
$expected = true;
assert($board->hasElementAt($given1, $given2) == $expected, sprintf('Board hasElementAt (%s, %s) expected %b but actual is %b', $given1, $given2, $expected, $board->hasElementAt($given1, $given2)));

$given1 = new BoardPoint(1000, 1000);
$given2 = BoardElements::$BAD_APPLE;
$expected = false;
assert($board->hasElementAt($given1, $given2) == $expected, sprintf('Board hasElementAt (%s, %s) expected %b but actual is %b', $given1, $given2, $expected, $board->hasElementAt($given1, $given2)));

$given1 = new BoardPoint(3, 9);
$given2 = BoardElements::$BREAK;
$expected = false;
assert($board->hasElementAt($given1, $given2) == $expected, sprintf('Board hasElementAt (%s, %s) expected %b but actual is %b', $given1, $given2, $expected, $board->hasElementAt($given1, $given2)));

$given1 = new BoardPoint(3, 9);
$given2 = array(BoardElements::$BAD_APPLE, BoardElements::$BREAK);
$expected = true;
assert($board->hasElemenstAt($given1, $given2) == $expected, sprintf('Board hasElemenstAt (%s, %s) expected %b but actual is %b', $given1, var_export($given2, true), $expected, $board->hasElemenstAt($given1, $given2)));

$given1 = new BoardPoint(3, 9);
$given2 = array(BoardElements::$NONE, BoardElements::$BREAK);
$expected = false;
assert($board->hasElemenstAt($given1, $given2) == $expected, sprintf('Board hasElemenstAt (%s, %s) expected %b but actual is %b', $given1, var_export($given2, true), $expected, $board->hasElemenstAt($given1, $given2)));

$given1 = new BoardPoint(3, 9);
$given2 = BoardElements::$BREAK;
$expected = false;
assert($board->isNearToElement($given1, $given2) == $expected, sprintf('Board isNearToElement (%s, %s) expected %b but actual is %b', $given1, var_export($given2, true), $expected, $board->isNearToElement($given1, $given2)));

$given1 = new BoardPoint(1, 9);
$given2 = BoardElements::$BREAK;
$expected = true;
assert($board->isNearToElement($given1, $given2) == $expected, sprintf('Board isNearToElement (%s, %s) expected %b but actual is %b', $given1, var_export($given2, true), $expected, $board->isNearToElement($given1, $given2)));

$given1 = new BoardPoint(1, 1);
$given2 = BoardElements::$BREAK;
$expected = 2;
assert($board->getCountElementsNearToPoint($given1, $given2) == $expected, sprintf('Board getCountElementsNearToPoint (%s, %s) expected %d but actual is %d', $given1, var_export($given2, true), $expected, $board->getCountElementsNearToPoint($given1, $given2)));

$given1 = new BoardPoint(1, 1);
$given2 = BoardElements::$GOOD_APPLE;
$expected = 0;
assert($board->getCountElementsNearToPoint($given1, $given2) == $expected, sprintf('Board getCountElementsNearToPoint (%s, %s) expected %d but actual is %d', $given1, var_export($given2, true), $expected, $board->getCountElementsNearToPoint($given1, $given2)));

$given = BoardElements::$BAD_APPLE;
$expected = array(new BoardPoint(3, 9));
assert($board->findAllElements($given) == $expected, sprintf('Board findAllElements %s expected %s but actual is %s', $given, var_export($expected, true), var_export($board->findAllElements($given),true)));

$expected = array(new BoardPoint(1, 5));
assert($board->getApples() == $expected, sprintf('Board getApples expected %s but actual is %s', var_export($expected, true), var_export($board->getApples(),true)));

$expected = new BoardPoint(6, 6);
assert($board->getHead() == $expected, sprintf('Board getHead expected %s but actual is %s', $expected, $board->getHead()));

$expected = null;
assert($diedSnakeBoard->getHead() == $expected, sprintf('DiedSnakeBoard getHead expected %s but actual is %s', $expected, $diedSnakeBoard->getHead()));

$expected = array(new BoardPoint(6, 6), new BoardPoint(7, 6));
assert($board->getSnake() == $expected, sprintf('Board getSnake expected %s but actual is %s', var_export($expected, true), var_export($board->getSnake(), true)));

$expected = array(new BoardPoint(3, 9));
assert($board->getStones() == $expected, sprintf('Board getStones expected %s but actual is %s', var_export($expected, true), var_export($board->getStones(), true)));

$expected = Direction::$LEFT;
assert($board->getSnakeDirection() == $expected, sprintf('Board getSnakeDirection expected %s but actual is %s', $expected, $board->getSnakeDirection()));

echo $board;