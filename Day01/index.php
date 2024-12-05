<?php

$filename = "input.txt";


try {
    $left_table = [];
    $right_table = [];

    # Read the file line by line:
    $content = new SplFileObject($filename);
    while (!$content->eof()) {
        $line = trim($content->fgets());
        if (!empty($line)) {
            # Split the line into two numbers:
            $numbers = preg_split('/\s+/', $line);
            if (count($numbers) == 2) {
                $left_table[] = (int)$numbers[0];
                $right_table[] = (int)$numbers[1];
            }
        }
    }

    # Sort both table arrays:
    sort($left_table);
    sort($right_table);

    # Calculate differences line by line:
    for ($i = 0; $i < min(count($left_table), count($right_table)); $i++) {
        $difference = abs($left_table[$i] - $right_table[$i]);
        $differences[] = $difference;

        echo "Pair: ({$left_table[$i]}, {$right_table[$i]}) - Difference: {$difference}" . PHP_EOL;
    }

    # Get total difference:
    $total_difference = array_sum($differences);
    echo "Total Difference: {$total_difference}" . PHP_EOL;
} catch (Exception $e) {
    echo "Error reading file: " . $e->getMessage();
}
