<?php

$filename = "input.txt";

if (!file_exists($filename)) {
    die("File not found: {$filename}");
}

$input = file_get_contents($filename);

$total_sum = 0;
$isEnabled = true;

# Regular expression to find instructions (mul, do, don't)
preg_match_all('/mul\((\d+),(\d+)\)|do\(\)|don\'t\(\)/', $input, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[0] as $match) {
    $instruction = $match[0];

    # Handle mul(x, y)
    if (preg_match('/mul\((\d+),(\d+)\)/', $instruction, $mulMatch)) {
        if ($isEnabled) {
            $x = (int)$mulMatch[1];
            $y = (int)$mulMatch[2];
            $total_sum += $x * $y;
        }
    }
    # Handle do() instruction
    elseif ($instruction === "do()") {
        $isEnabled = true;
    }
    # Handle don't() instruction
    elseif ($instruction === "don't()") {
        $isEnabled = false;
    }
}

echo "Total sum: {$total_sum}" . PHP_EOL;
