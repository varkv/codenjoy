<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tests
 *
 * @author Kirill_Korol
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

function my_assert_handler($file, $line, $code, $desc = null) {
    $message = sprintf("Assertion Failed: File <%s>. Line <%d>. Code <%s>", $file, $line, $code);
    if ($desc) {
        $message .= sprintf(" Message <%s>", $desc);
    }
    print $message . "\n";
}

assert_options(ASSERT_CALLBACK, 'my_assert_handler');

require_once "BoardPointTest.php";
require_once "DirectionTest.php";
require_once "BoardElementsTest.php";
require_once "BoardTest.php";
        

