<?php

$filename = "input.txt";

function calculateSimilarityScore($left_table, $right_table)
{
    $right_counts = array_count_values($right_table);
    $total_similarity_score = 0;

    foreach ($left_table as $number) {
        $times_in_right = $right_counts[$number] ?? 0;
        $score = $number * $times_in_right;
        $total_similarity_score += $score;
    }

    return $total_similarity_score;
}

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
    }

    # Get total difference:
    $total_difference = array_sum($differences);
    echo "Total Difference: {$total_difference}" . PHP_EOL;

    # Get total similarity score
    $total_similarity_score = calculateSimilarityScore($left_table, $right_table);
    echo "Total Similarity Score: $total_similarity_score" . PHP_EOL;
} catch (Exception $e) {
    echo "Error reading file: " . $e->getMessage();
}
