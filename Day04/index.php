<?php

$filename = "input.txt";

if (!file_exists($filename)) {
    die("File not found: $filename");
}

# Read the file and create a grid
$grid = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

# Convert grid to a 2D array
$grid = array_map('str_split', $grid);

$word = "XMAS";

function countWordOccurrences($grid, $word)
{
    $rows = count($grid);
    $cols = count($grid[0]);
    $wordLength = strlen($word);
    $count = 0;

    # Define the 8 possible directions (dx, dy)
    $directions = [
        [0, 1],
        [1, 0],
        [1, 1],
        [1, -1],
        [0, -1],
        [-1, 0],
        [-1, -1],
        [-1, 1],
    ];

    # Iterate through each cell in the grid
    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {
            # Check each direction from the current cell
            foreach ($directions as $direction) {
                $dr = $direction[0];
                $dc = $direction[1];
                $found = true;

                # Check if the word fits in this direction
                for ($k = 0; $k < $wordLength; $k++) {
                    $nr = $r + $k * $dr;
                    $nc = $c + $k * $dc;

                    # Out of bounds or mismatch
                    if ($nr < 0 || $nr >= $rows || $nc < 0 || $nc >= $cols || $grid[$nr][$nc] !== $word[$k]) {
                        $found = false;
                        break;
                    }
                }

                if ($found) {
                    $count++;
                }
            }
        }
    }

    return $count;
}

function countXMASOccurrences($grid)
{
    $rows = count($grid);
    $cols = count($grid[0]);
    $count = 0;

    # Iterate through each cell in the grid
    for ($r = 1; $r < $rows - 1; $r++) {
        for ($c = 1; $c < $cols - 1; $c++) {
            # Check for "X-MAS" pattern
            if (
                # Check diagonal 1 (top-left to bottom-right)
                (($grid[$r - 1][$c - 1] === 'M' && $grid[$r][$c] === 'A' && $grid[$r + 1][$c + 1] === 'S') ||
                    ($grid[$r - 1][$c - 1] === 'S' && $grid[$r][$c] === 'A' && $grid[$r + 1][$c + 1] === 'M')) &&
                # Check diagonal 2 (top-right to bottom-left)
                (($grid[$r - 1][$c + 1] === 'M' && $grid[$r][$c] === 'A' && $grid[$r + 1][$c - 1] === 'S') ||
                    ($grid[$r - 1][$c + 1] === 'S' && $grid[$r][$c] === 'A' && $grid[$r + 1][$c - 1] === 'M'))
            ) {
                $count++;
            }
        }
    }

    return $count;
}

$totalWordOccurrences = countWordOccurrences($grid, $word);
$totalXMASOccurrences = countXMASOccurrences($grid);

echo "Total occurrences of '$word': " . $totalWordOccurrences . PHP_EOL;
echo "Total occurrences of 'X-MAS': " . $totalXMASOccurrences . PHP_EOL;
