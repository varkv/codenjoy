<?php

namespace Api;

/**
 * Этот enum содержит все возможные команды и дополнительные методы для работы с ними.
 * Сервер ожидает одну из этих команд, либо комбинацию из двух команд, разделенных запятыми.
 * Команда ACT может иметь любьое число целочисленных параметров, а может и не иметь их - зависит от игры.
 *
 * @author Kirill_Korol
 */
class Direction {

    /**
     * instances of directions
     * @var type Direction
     */
    static
            $UP,
            $DOWN,
            $LEFT,
            $RIGHT,
            $ACT,
            $STOP;

    /**
     * @var type sting
     */
    private $key;

    /**
     * @var type int
     */
    private $dx;

    /**
     * @var type int
     */
    private $dy;

    /**
     * @var type int
     */
    private $value;

    private function __construct(string $key, int $value, int $dx, int $dy) {
        $this->key = $key;
        $this->value = $value;
        $this->dy = $dy;
        $this->dx = $dx;
    }

    /**
     * @param x Given point.x.
     * @return New point.x that will be after move from current point.x in given direction.
     */
    public function changeX(int $x): int {
        return $x + $this->dx;
    }

    /**
     * @param y Given point.y
     * @return New point.y that will be after move from current point.y in given direction.
     */
    public function changeY(int $y): int {
        return $y + $this->dy;
    }

    /**
     * @return Inverted direction. Inverts UP to DOWN, RIGHT to LEFT, etc.
     */
    public function inverted(): Direction {
        switch ($this->key) {
            case "UP" : return Direction::$DOWN;
            case "DOWN" : return Direction::$UP;
            case "LEFT" : return Direction::$RIGHT;
            case "RIGHT" : return Direction::$LEFT;
            default : return Direction::$STOP;
        }
    }

    /**
     * @param point Current point.
     * @return New point that will be after move from current point in given direction.
     */
    public function change(BoardPoint $point): BoardPoint {
        return new BoardPoint($this->changeX($point->getX()), $this->changeY($point->getY()));
    }

    /**
     * @return Next clockwise direction. LEFT -> UP -> RIGHT -> DOWN -> LEFT.
     */
    public function clockwise(): Direction {
        switch ($this->key) {
            case "UP" : return Direction::$RIGHT;
            case "RIGHT" : return Direction::$DOWN;
            case "DOWN" : return Direction::$LEFT;
            case "LEFT" : return Direction::$UP;
        }
        throw new Exception(sprintf("Cant clockwise for: <%s>", $this));
    }

    public function __toString() {
        return $this->key;
    }

    function getDx(): int {
        return $this->dx;
    }

    function getDy(): int {
        return $this->dy;
    }

    function getValue(): int {
        return $this->value;
    }

    /**
     * please don't use this method in your code
     * use static instances instead
     */
    public static function instantiate() {
        Direction::$UP = new Direction("UP", 2, 0, -1);
        Direction::$DOWN = new Direction("DOWN", 3, 0, 1);
        Direction::$LEFT = new Direction("LEFT", 0, -1, 0);
        Direction::$RIGHT = new Direction("RIGHT", 1, 1, 0);
        Direction::$ACT = new Direction("ACT", 4, 0, 0);
        Direction::$STOP = new Direction("STOP", 5, 0, 0);
    }

}

/**
 * initialize static instances when class is loaded
 */
Direction::instantiate();
