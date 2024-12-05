<?php

$filename = "input.txt";

function isSafeReport($numbers)
{
    $isIncreasing = true;
    $isDecreasing = true;

    for ($i = 1; $i < count($numbers); $i++) {
        $diff = $numbers[$i] - $numbers[$i - 1];

        # If the difference is out of bounds the report is not safe
        if ($diff < -3 || $diff > 3 || $diff == 0) {
            return false;
        }

        # Track if the sequence breaks either increasing or decreasing pattern
        if ($diff > 0) {
            $isDecreasing = false;
        }
        if ($diff < 0) {
            $isIncreasing = false;
        }
    }

    # A report is safe only if it's entirely increasing or decreasing
    return $isIncreasing || $isDecreasing;
}

function isSafeWithDampener($numbers)
{
    # Check if the report is already safe
    if (isSafeReport($numbers)) {
        return true;
    }

    # Try removing each level and see if the report becomes safe
    for ($i = 0; $i < count($numbers); $i++) {
        $modifiedNumbers = $numbers;
        unset($modifiedNumbers[$i]); // Remove the current level
        $modifiedNumbers = array_values($modifiedNumbers); // Re-index the array

        if (isSafeReport($modifiedNumbers)) {
            return true; // If removing this level makes it safe, return true
        }
    }

    # If no single removal makes the report safe, it remains unsafe
    return false;
}

try {
    $content = new SplFileObject($filename);
    $safeReports = 0;
    $safeReportsWithDampener = 0;

    while (!$content->eof()) {
        $line = trim($content->fgets());
        if ($line === '') {
            continue;
        }

        # Convert line into an array of integers
        $numbers = array_map('intval', explode(' ', $line));

        if (isSafeReport($numbers)) {
            $safeReports++;
        }

        if (isSafeWithDampener($numbers)) {
            $safeReportsWithDampener++;
        }
    }

    echo $safeReports . PHP_EOL;
    echo $safeReportsWithDampener . PHP_EOL;
} catch (Exception $e) {
    echo "Error while processing file content: " . $e->getMessage();
}
