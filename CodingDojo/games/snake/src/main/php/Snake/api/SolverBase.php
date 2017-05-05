<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api;


/**
 * Description of SolverBase
 *
 * @author Kirill_Korol
 */
abstract class SolverBase {    
    const RESPONSE_PREFIX = "board=";
    
    /**
     * @var string
     */
    private $host;
    
    /**
     * @var string
     */
    private $userName;
    
    /**
     * @var bool
     */
    private $shouldExit = false;
    
    function __construct($host, $userName) {
        $this->host = $host;
        $this->userName = $userName;
    }
    
    abstract protected function doMove(Board $gameBoard): string;
    
    public function play(){        
        $server = sprintf("ws://%s/codenjoy-contest/ws", $this->host);
        $uri = $server . "?user=" . urlencode($this->userName);
                
        \Ratchet\Client\connect($uri)->then(function($conn) {
            $conn->on('message', function($msg) use ($conn) {
                $board = mb_substr($msg, mb_strpos($msg, SolverBase::RESPONSE_PREFIX) + mb_strlen(SolverBase::RESPONSE_PREFIX));
                $response = $this->doMove(new \Api\Board($board));                
                $conn->send($response);
            });
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}
