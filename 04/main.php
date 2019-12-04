<?php
    
    $input = [347312,805915];

    function is_valid($number, $upper, $lower) {
        $digits = str_split($number);

        $has_double = FALSE;

        for ($i = 1; $i <= sizeof($digits)-1; $i++) {
            if ($digits[$i] < $digits[$i - 1]) {
                return FALSE;
            }

            if ($has_double == FALSE && $digits[$i] == $digits[$i - 1]) {
                $has_double = TRUE;
            }
        }

        return $has_double;
    }

    function is_valid_doubles_only($number, $upper, $lower) {
        $digits = str_split($number);

        $has_double = FALSE;
        $digit_count = 1;

        for ($i = 1; $i <= sizeof($digits)-1; $i++) {
            if ($digits[$i] < $digits[$i - 1]) {
                return FALSE;
            }

            if ($has_double == FALSE) {
                if ($digits[$i] == $digits[$i - 1]) {
                    $digit_count++;
                }
                else {
                    if ($digit_count == 2) {
                        $has_double = TRUE;
                    }
                    $digit_count = 1;
                }

                if ($digit_count == 2 && $i == sizeof($digits) - 1) {
                    $has_double = TRUE;
                }
            }
        }

        return $has_double;
    }

    $test = [
        111111,
        223450,
        123789
    ];

    foreach ($test as $number) {
        echo 'PART 1 TEST ' . $number . "\t" . (is_valid($number, $input[0], $input[1]) ? 'TRUE' : 'FALSE') . PHP_EOL;
    }

    $test = [
        112233,
        123444,
        111122
    ];

    foreach ($test as $number) {
        echo 'PART 2 TEST ' . $number . "\t" . (is_valid_doubles_only($number, $input[0], $input[1]) ? 'TRUE' : 'FALSE') . PHP_EOL;
    }

    $valids = 0;
    for ($i = $input[0]; $i <= $input[1]; $i++) {
        if (is_valid($i, $input[0], $input[1])) {
            $valids++;
        }
    }

    echo 'PART 1 ' . $valids . ' between ' . $input[0] . ' and ' . $input[1] . PHP_EOL;

    $valids = 0;
    for ($i = $input[0]; $i <= $input[1]; $i++) {
        if (is_valid_doubles_only($i, $input[0], $input[1])) {
            $valids++;
        }
    }

    echo 'PART 2 ' . $valids . ' between ' . $input[0] . ' and ' . $input[1] . PHP_EOL;


/*

--- Day 4: Secure Container ---
You arrive at the Venus fuel depot only to discover it's protected by a password. The Elves had written the password on a sticky note, but someone threw it out.

However, they do remember a few key facts about the password:

It is a six-digit number.
The value is within the range given in your puzzle input.
Two adjacent digits are the same (like 22 in 122345).
Going from left to right, the digits never decrease; they only ever increase or stay the same (like 111123 or 135679).
Other than the range rule, the following are true:

111111 meets these criteria (double 11, never decreases).
223450 does not meet these criteria (decreasing pair of digits 50).
123789 does not meet these criteria (no double).
How many different passwords within the range given in your puzzle input meet these criteria?

--- Part Two ---
An Elf just remembered one more important detail: the two adjacent matching digits are not part of a larger group of matching digits.

Given this additional criterion, but still ignoring the range rule, the following are now true:

112233 meets these criteria because the digits never decrease and all repeated digits are exactly two digits long.
123444 no longer meets the criteria (the repeated 44 is part of a larger group of 444).
111122 meets the criteria (even though 1 is repeated more than twice, it still contains a double 22).
How many different passwords within the range given in your puzzle input meet all of the criteria?


*/