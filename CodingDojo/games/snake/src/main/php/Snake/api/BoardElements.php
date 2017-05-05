<?php

namespace Api;
use Exception;

/**
 * Этот enum содержит все возможные элементы на карте и дополнительные методы для работы с ними.
 *
 * @author Kirill_Korol
 */
class BoardElements {

    /**
     * instances of BoardElements
     * @var type Direction
     */
    public static
            $BAD_APPLE,
            $GOOD_APPLE,
            $BREAK,
            $HEAD_DOWN,
            $HEAD_LEFT,
            $HEAD_RIGHT,
            $HEAD_UP,
            $TAIL_END_DOWN,
            $TAIL_END_LEFT,
            $TAIL_END_UP,
            $TAIL_END_RIGHT,
            $TAIL_HORIZONTAL,
            $TAIL_VERTICAL,
            $TAIL_LEFT_DOWN,
            $TAIL_LEFT_UP,
            $TAIL_RIGHT_DOWN,
            $TAIL_RIGHT_UP,
            $NONE;

    /**
     * @var type string
     */
    private $ch;

    function __construct(string $ch) {
        $this->ch = $ch;
    }

    public function __toString() {
        return $this->ch;
    }

    public function getCh(): string {
        return $this->ch;
    }

    public static function valueOf(string $ch): BoardElements {
        $class_vars = get_class_vars(get_class(BoardElements::$NONE));
        foreach ($class_vars as $variable => $value) {
            if ($variable != "ch" && $value == $ch) {
                $class = new \ReflectionClass(get_class(BoardElements::$NONE));
                return $class->getStaticPropertyValue($variable);
            }
        }
        throw new Exception("No such element for " + $ch);
    }

    /**
     * please don't use this method in your code
     * use static instances instead
     */
    public static function instantiate() {
        BoardElements::$BAD_APPLE = new BoardElements("☻");
        BoardElements::$GOOD_APPLE = new BoardElements('☺');
        BoardElements::$BREAK = new BoardElements('☼');
        BoardElements::$HEAD_DOWN = new BoardElements('▼');
        BoardElements::$HEAD_LEFT = new BoardElements('◄');
        BoardElements::$HEAD_RIGHT = new BoardElements('►');
        BoardElements::$HEAD_UP = new BoardElements('▲');
        BoardElements::$TAIL_END_DOWN = new BoardElements('╙');
        BoardElements::$TAIL_END_LEFT = new BoardElements('╘');
        BoardElements::$TAIL_END_UP = new BoardElements('╓');
        BoardElements::$TAIL_END_RIGHT = new BoardElements('╕');
        BoardElements::$TAIL_HORIZONTAL = new BoardElements('═');
        BoardElements::$TAIL_VERTICAL = new BoardElements('║');
        BoardElements::$TAIL_LEFT_DOWN = new BoardElements('╗');
        BoardElements::$TAIL_LEFT_UP = new BoardElements('╝');
        BoardElements::$TAIL_RIGHT_DOWN = new BoardElements('╔');
        BoardElements::$TAIL_RIGHT_UP = new BoardElements('╚');
        BoardElements::$NONE = new BoardElements(' ');
    }

}

/**
 * initialize static instances when class is loaded
 */
BoardElements::instantiate();
