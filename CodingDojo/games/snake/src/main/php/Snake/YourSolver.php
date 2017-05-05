<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YourSolver
 *
 * @author Kirill_Korol
 */
require_once './api/SolverBase.php';
require_once './api/Board.php';
require_once './api/BoardElements.php';
require_once './api/BoardPoint.php';
require_once './api/Direction.php';

class YourSolver extends Api\SolverBase{    
    const HOST = "127.0.0.1:8080";
    const NAME = "kvk@com.com";

    function __construct() {        
       parent::__construct(YourSolver::HOST, YourSolver::NAME);               
    }
    
    protected function doMove(Api\Board $gameBoard): string {
        //put your logic here
        echo $gameBoard;
        
        switch (rand(0, 3)){
            case 0: return (string) Api\Direction::$RIGHT;
            case 1: return (string) Api\Direction::$UP;
            case 2: return (string) Api\Direction::$DOWN;
            case 3: return (string) Api\Direction::$LEFT;
        }
        return (string) Api\Direction::$RIGHT;
    }

}
