/*-
 * #%L
 * Codenjoy - it's a dojo-like platform from developers to developers.
 * %%
 * Copyright (C) 2016 Codenjoy
 * %%
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/gpl-3.0.html>.
 * #L%
 */
var log = function (string) {
    console.log(string);
};

var printArray = function (array) {
    var result = [];
    for (var index in array) {
        var element = array[index];
        result.push(element.toString());
    }
    return "[" + result + "]";
};
var util = require('util');

var hostIp = '127.0.0.1';
//var hostIp = 'tetrisj.jvmhost.net';

var userName = 'kvk@kvk.com';
var protocol = 'WS';

var processBoard = function (boardString) {
    var board = new Board(boardString);
    log("Board: " + board);

    var answer = new DirectionSolver(board).get().toString();
    log("Answer: " + answer);
    log("-----------------------------------");

    return answer;
};

if (protocol == 'HTTP') {
    var http = require('http');
    var url = require('url');

    http.createServer(function (request, response) {
        var parameters = url.parse(request.url, true).query;
        var boardString = parameters.board;

        var answer = processBoard(boardString);

        response.writeHead(200, { 'Content-Type': 'text/plain' });
        response.end(answer);
    }).listen(8888, hostIp);

    log('Server running at http://' + hostIp + ':8888/');
} else {
    var port = 8080;
    if (hostIp == 'tetrisj.jvmhost.net') {
        port = 12270;
    }
    var server = 'ws://' + hostIp + ':' + port + '/codenjoy-contest/ws';
    var WebSocket = require('ws');
    var ws = new WebSocket(server + '?user=' + userName);

    ws.on('open', function () {
        log('Opened');
    });

    ws.on('close', function () {
        log('Closed');
    });

    ws.on('message', function (message) {
        log('received: %s', message);

        var pattern = new RegExp(/^board=(.*)$/);
        var parameters = message.match(pattern);
        var boardString = parameters[1];

        var answer = processBoard(boardString);

        ws.send(answer);
    });

    log('Web socket client running at ' + server);
}

var Elements = {
    BAD_APPLE: ('☻'),
    GOOD_APPLE: ('☺'),

    BREAK: ('☼'),

    HEAD_DOWN: ('▼'),
    HEAD_LEFT: ('◄'),
    HEAD_RIGHT: ('►'),
    HEAD_UP: ('▲'),

    TAIL_END_DOWN: ('╙'),
    TAIL_END_LEFT: ('╘'),
    TAIL_END_UP: ('╓'),
    TAIL_END_RIGHT: ('╕'),
    TAIL_HORIZONTAL: ('═'),
    TAIL_VERTICAL: ('║'),
    TAIL_LEFT_DOWN: ('╗'),
    TAIL_LEFT_UP: ('╝'),
    TAIL_RIGHT_DOWN: ('╔'),
    TAIL_RIGHT_UP: ('╚'),

    NONE: (' ')
};

var D = function (index, dx, dy, name) {

    var changeX = function (x) {
        return x + dx;
    };

    var changeY = function (y) {
        return y + dy;
    };

    var inverted = function () {
        switch (this) {
            case Direction.UP: return Direction.DOWN;
            case Direction.DOWN: return Direction.UP;
            case Direction.LEFT: return Direction.RIGHT;
            case Direction.RIGHT: return Direction.LEFT;
            default: return Direction.STOP;
        }
    };

    var toString = function () {
        return name;
    };

    return {
        changeX: changeX,

        changeY: changeY,

        inverted: inverted,

        toString: toString,

        getIndex: function () {
            return index;
        }
    };
};

var Direction = {
    UP: D(2, 0, -1, 'up'),        // направления движения
    DOWN: D(3, 0, 1, 'down'),
    LEFT: D(0, -1, 0, 'left'),
    RIGHT: D(1, 1, 0, 'right'),
    ACT: D(4, 0, 0, 'act'),       // выполнить действие
    STOP: D(5, 0, 0, '')         // стоять на месте
};

Direction.values = function () {
    return [Direction.UP, Direction.DOWN, Direction.LEFT, Direction.RIGHT, Direction.ACT, Direction.STOP];
};

Direction.valueOf = function (index) {
    var directions = Direction.values();
    for (var i in directions) {
        var direction = directions[i];
        if (direction.getIndex() == index) {
            return direction;
        }
    }
    return Direction.STOP;
};

var Point = function (x, y) {
    return {
        equals: function (o) {
            return o.getX() == x && o.getY() == y;
        },

        toString: function () {
            return '[' + x + ',' + y + ']';
        },

        isBad: function (boardSize) {
            return x >= boardSize || y >= boardSize || x < 0 || y < 0;
        },

        getX: function () {
            return x;
        },

        getY: function () {
            return y;
        }
    }
};

var pt = function (x, y) {
    return new Point(x, y);
};

var LengthToXY = function (boardSize) {
    return {
        getXY: function (length) {
            if (length == -1) {
                return null;
            }
            return new Point(length % boardSize, Math.ceil(length / boardSize));
        },

        getLength: function (x, y) {
            return y * boardSize + x;
        }
    };
};

var Board = function (board) {
    var isAt = function (x, y, element) {
        if (pt(x, y).isBad(size)) {
            return false;
        }
        return getAt(x, y) == element;
    };

    var getAt = function (x, y) {
        return board.charAt(xyl.getLength(x, y));
    };

    var getAllAt = function (x, y) {
        return board.charAt(xyl.getLength(x, y));
    };

    var boardAsString = function () {
        var result = "";
        for (var i = 0; i <= size - 1; i++) {
            result += board.substring(i * size, (i + 1) * size);
            result += "\n";
        }
        return result;
    };

    var contains = function (a, obj) {
        var i = a.length;
        while (i--) {
            if (a[i].equals(obj)) {
                return true;
            }
        }
        return false;
    };

    var removeDuplicates = function (all) {
        var result = [];
        for (var index in all) {
            var point = all[index];
            if (!contains(result, point)) {
                result.push(point);
            }
        }
        return result;
    };

    var boardSize = function () {
        return Math.sqrt(board.length);
    };

    var size = boardSize();
    var xyl = new LengthToXY(size);

    var findAll = function (element) {
        var result = [];
        for (var i = 0; i < size * size; i++) {
            var point = xyl.getXY(i);
            if (isAt(point.getX(), point.getY(), element)) {
                result.push(point);
            }
        }
        return result;
    };

    var getApples = function () {
        return findAll(Elements.GOOD_APPLE);
    }

    var getSnakeDirection = function () {
        var head = getHead();
        if (head == null) {
            return null;
        }
        if (isAt(head.getX(), head.getY(), Elements.HEAD_LEFT)) {
            return Direction.LEFT;
        } else if (isAt(head.getX(), head.getY(), Elements.HEAD_RIGHT)) {
            return Direction.RIGHT;
        } else if (isAt(head.getX(), head.getY(), Elements.HEAD_UP)) {
            return Direction.UP;
        } else {
            return Direction.DOWN;
        }
    }

    var getHead = function () {
        var result = [];
        result = result.concat(findAll(Elements.HEAD_UP));
        result = result.concat(findAll(Elements.HEAD_DOWN));
        result = result.concat(findAll(Elements.HEAD_LEFT));
        result = result.concat(findAll(Elements.HEAD_RIGHT));
        if (result.length == 0) {
            return null;
        }
        return result[0];
    }

    var getSnake = function () {
        var head = getHead();
        if (head == null) {
            return [];
        }
        var result = [];
        result = result.concat(findAll(Elements.TAIL_END_DOWN));
        result = result.concat(findAll(Elements.TAIL_END_LEFT));
        result = result.concat(findAll(Elements.TAIL_END_UP));
        result = result.concat(findAll(Elements.TAIL_END_RIGHT));
        result = result.concat(findAll(Elements.TAIL_HORIZONTAL));
        result = result.concat(findAll(Elements.TAIL_VERTICAL));
        result = result.concat(findAll(Elements.TAIL_LEFT_DOWN));
        result = result.concat(findAll(Elements.TAIL_LEFT_UP));
        result = result.concat(findAll(Elements.TAIL_RIGHT_DOWN));
        result = result.concat(findAll(Elements.TAIL_RIGHT_UP));
        return result;
    }

    var getBarriers = function () {
        var all = getSnake();
        all = all.concat(getWalls());
        all = all.concat(getStones());
        return removeDuplicates(all);
    };

    var getWalls = function () {
        return findAll(Elements.BREAK);
    };

    var getStones = function () {
        return findAll(Elements.BAD_APPLE);
    };

    var toString = function () {
        return util.format("Board:\n%s\n" +
            "Apple at: %s\n" +
            "Stones at: %s\n" +
            "Head at: %s\n" +
            "Snake at: %s\n" +
            "Current direction: %s",
            boardAsString(),
            printArray(getApples()),
            printArray(getStones()),
            getHead(),
            printArray(getSnake()),
            getSnakeDirection());
    };

    var isAnyOfAt = function (x, y, elements) {
        for (var index in elements) {
            var element = elements[index];
            if (isAt(x, y, element)) {
                return true;
            }
        }
        return false;
    };

    var isNear = function (x, y, element) {
        if (pt(x, y).isBad(size)) {
            return false;
        }
        return isAt(x + 1, y, element) || isAt(x - 1, y, element) || isAt(x, y + 1, element) || isAt(x, y - 1, element);
    };

    var isBarrierAt = function (x, y) {
        return contains(getBarriers(), pt(x, y));
    };

    var countNear = function (x, y, element) {
        if (pt(x, y).isBad(size)) {
            return 0;
        }
        var count = 0;
        if (isAt(x - 1, y, element)) count++;
        if (isAt(x + 1, y, element)) count++;
        if (isAt(x, y - 1, element)) count++;
        if (isAt(x, y + 1, element)) count++;
        return count;
    };

    return {
        size: boardSize,
        getApples: getApples,
        getSnakeDirection: getSnakeDirection,
        getHead: getHead,
        getSnake: getSnake,
        isAt: isAt,
        boardAsString: boardAsString,
        getBarriers: getBarriers,
        toString: toString,
        findAll: findAll,
        getWalls: getWalls,
        getStones: getStones,
        isAnyOfAt: isAnyOfAt,
        isNear: isNear,
        isBarrierAt: isBarrierAt,
        countNear: countNear,
        getAt: getAt
    };
};

var random = function (n) {
    return Math.floor(Math.random() * n);
};

var direction;

var DirectionSolver = function (board) {

    /**
     * @return next bot action
     */
    var get = function () {
        return Direction.UP;
    }

    return {
        get: get
    };
};

