<?php

/**
 * Description of Board
 *
 * @author Kirill_Korol
 */

namespace Api;

class Board {

    /**
     * @var string
     */
    private $boardString;

    function __construct(string $boardString) {
        $this->boardString = str_replace("\n", "", $boardString);
    }

    public function getSize(): int {
        return sqrt(mb_strlen($this->boardString, "UTF-8"));
    }

    /**
     * @return \Api\BoardPoint[]
     */
    public function findAllElements(BoardElements $element): array {
        $result = array();
        $size = $this->getSize();
        for ($i = 0; $i < $size * $size; $i++) {
            $boardPoint = $this->getPointByShift($i);

            if ($this->hasElementAt($boardPoint, $element)) {
                array_push($result, $boardPoint);
            }
        }
        return $result;
    }

    /**
     * @param \Api\BoardPoint $point
     * @param \Api\BoardElements[] $elements
     */
    public function hasElemenstAt(BoardPoint $point, array $elements): bool {
        for ($i = 0; $i < count($elements); $i++) {
            if ($this->hasElementAt($point, $elements[$i])) {
                return true;
            }
        }
        return false;
    }

    public function hasElementAt(BoardPoint $point, BoardElements $element): bool {
        if ($point->isOutOfBoard($this->getSize())) {
            return false;
        }
        return $this->getElementAt($point) == $element;
    }

    public function getElementAt(BoardPoint $point): BoardElements {
        return BoardElements::valueOf(
                        mb_substr($this->boardString, $this->getShiftByPoint($point), 1, "UTF-8"));
    }

    public function isNearToElement(BoardPoint $point, BoardElements $element): bool {
        if ($point->isOutOfBoard($this->getSize())) {
            return false;
        }

        return $this->hasElementAt($point->shiftBottom(), $element) || $this->hasElementAt($point->shiftTop(), $element) || $this->hasElementAt($point->shiftLeft(), $element) || $this->hasElementAt($point->shiftRight(), $element);
    }

    public function getCountElementsNearToPoint(BoardPoint $point, BoardElements $element): int {
        if ($point->isOutOfBoard($this->getSize())) {
            return false;
        }

        return $this->hasElementAt($point->shiftBottom(), $element) + $this->hasElementAt($point->shiftTop(), $element) + $this->hasElementAt($point->shiftLeft(), $element) + $this->hasElementAt($point->shiftRight(), $element);
    }

    public function getShiftByPoint(BoardPoint $point): int {
        return $point->getY() * $this->getSize() + $point->getX();
    }

    public function getPointByShift(int $shift): BoardPoint {
        $size = $this->getSize();
        return new BoardPoint($shift % $size, $shift / $size);
    }

    public function printBoard(): string {
        $result = "";

        $size = $this->getSize();
        for ($i = 0; $i < $size; $i++) {
            $result .= mb_substr($this->boardString, $i * $size, $size, "UTF-8");
            $result .= "\n";
        }
        return $result;
    }

    public function hasBarrierAt(BoardPoint $point): bool {
        return in_array($point, $this->getBarriers());
    }

    /** ********************************************************************* */

    /**
     * @return \Api\BoardPoint[]
     */
    public function getApples(): array {
        return $this->findAllElements(BoardElements::$GOOD_APPLE);
    }

    /**
     * @return \Api\BoardPoint or null 
     * if head is null than you already died =( just skip step
     */
    public function getHead() {
        $result = array();
        $result = array_merge($result, $this->findAllElements(BoardElements::$HEAD_DOWN));
        $result = array_merge($result, $this->findAllElements(BoardElements::$HEAD_LEFT));
        $result = array_merge($result, $this->findAllElements(BoardElements::$HEAD_RIGHT));
        $result = array_merge($result, $this->findAllElements(BoardElements::$HEAD_UP));
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    /**
     * @return \Api\BoardPoint[] or empty array if head is null
     */
    public function getSnake() {
        $head = $this->getHead();
        if ($head == null) {
            return array();
        }

        $result = array();
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_END_DOWN));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_END_LEFT));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_END_UP));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_END_RIGHT));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_HORIZONTAL));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_VERTICAL));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_LEFT_DOWN));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_LEFT_UP));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_RIGHT_DOWN));
        $result = array_merge($result, $this->findAllElements(BoardElements::$TAIL_RIGHT_UP));

        array_unshift($result, $head);
        return $result;
    }

    /**
     * @return \Api\BoardPoint[]
     */
    public function getStones(): array {
        return $this->findAllElements(BoardElements::$BAD_APPLE);
    }

    /**
     * @return \Api\BoardPoint[]
     */
    public function getWalls(): array {
        return $this->findAllElements(BoardElements::$BREAK);
    }

    public function getSnakeDirection(): Direction {
        $head = $this->getHead();
        if ($head == null) {
            return Direction::$LEFT;
        }

        if ($this->hasElementAt($head, BoardElements::$HEAD_UP)) {
            return Direction::$UP;
        } else if ($this->hasElementAt($head, BoardElements::$HEAD_DOWN)) {
            return Direction::$DOWN;
        } else if ($this->hasElementAt($head, BoardElements::$HEAD_RIGHT)) {
            return Direction::$RIGHT;
        }
        return Direction::$LEFT;
    }

    /**
     * @return \Api\BoardPoint[]
     */
    public function getBarriers(): array {

        $result = array();
        array_push($result, $this->getSnake());
        array_push($result, $this->getStones());
        array_push($result, $this->getWalls());

        return $result;
    }

    public function __toString(): string {
        return sprintf("Board:\n%s\n".
                "Apple at: %s\n" .
                "Stones at: %s\n" .
                "Head at: %s\n" .
                "Snake at: %s\n" .
                "Current direction: %s", 
                $this->printBoard(), 
                var_export($this->getApples(), true), 
                var_export($this->getStones(), true), 
                $this->getHead(), 
                var_export($this->getSnake(), true),
                $this->getSnakeDirection());
    }

}
