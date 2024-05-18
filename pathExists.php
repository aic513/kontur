<?php

function pathExists($map, $start, $end)
{
    $rows = count($map);
    $cols = count($map[0]);
    $queue = [[$start[0], $start[1]]];
    $visited = array_fill(0, $rows, array_fill(0, $cols, false));

    $directions = [
        [-1, 0], // вверх
        [1, 0],  // вниз
        [0, -1], // влево
        [0, 1],  // вправо
    ];

    $visited[$start[0]][$start[1]] = true;

    while (!empty($queue)) {
        [$currentRow, $currentCol] = array_shift($queue);

        if ($currentRow == $end[0] && $currentCol == $end[1]) {
            return true;
        }

        foreach ($directions as $direction) {
            $newRow = $currentRow + $direction[0];
            $newCol = $currentCol + $direction[1];

            if ($newRow >= 0 && $newRow < $rows && $newCol >= 0 && $newCol < $cols &&
                !$visited[$newRow][$newCol] && $map[$newRow][$newCol] == '_') {
                $queue[] = [$newRow, $newCol];
                $visited[$newRow][$newCol] = true;
            }
        }
    }

    return false;
}


$map = [
    ['_', '_', '_', '_', '_'],
    ['X', 'X', 'X', 'X', '_'],
    ['_', '_', 'X', '_', '_'],
    ['X', 'X', 'X', '_', 'X'],
    ['_', '_', '_', '_', '_'],
];

var_dump(pathExists($map, [0, 0], [4, 4])); // True
var_dump(pathExists($map, [0, 0], [2, 1])); // False
