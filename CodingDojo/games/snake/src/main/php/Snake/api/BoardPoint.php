<?php

namespace Api;

/**
 * Description of BoardPoint
 *
 * @author Kirill_Korol
 */
class BoardPoint {

    /**
     * @var type int
     */
    private $x;

    /**
     * @var type int
     */
    private $y;

    public function __construct(int $x, int $Y) {
        $this->x = $x;
        $this->y = $Y;
    }

    public function isOutOfBoard(int $boardSize): bool {
        return $this->x >= $boardSize || $this->y >= $boardSize || $this->x < 0 || $this->y < 0;
    }

    public function shiftLeft(int $delta = 1): BoardPoint {
        return new BoardPoint($this->x - $delta, $this->y);
    }

    public function shiftRight(int $delta = 1): BoardPoint {
        return new BoardPoint($this->x + $delta, $this->y);
    }

    public function shiftTop(int $delta = 1): BoardPoint {
        return new BoardPoint($this->x, $this->y - $delta);
    }

    public function shiftBottom(int $delta = 1): BoardPoint {
        return new BoardPoint($this->x, $this->y + $delta);
    }

    public function __toString(): string {
        return sprintf("[%d,%d]", $this->x, $this->y);
    }
    
    function getX(): int {
        return $this->x;
    }

    function getY(): int {
        return $this->y;
    }
}
