<?php

    require 'program_alarm_1202.php';

    $test = new program_alarm_1202();
    $inputs = [
        [1,0,0,0,99],
        [2,3,0,3,99],
        [2,4,4,5,99,0],
        [1,1,1,4,99,5,6,0,99],
    ];

    $expected = [
        [2,0,0,0,99],
        [2,3,0,6,99],
        [2,4,4,5,99,9801],
        [30,1,1,4,2,5,6,0,99],
    ];
    
    foreach ($inputs as $idx => $codes) {
        $test->codes = $codes;

        $test->execute_codes();
        
        echo ($test->codes === $expected[$idx] ? '[PASS] ' : '[FAIL] ');
        echo implode(',', $codes) . "\t\t" . implode(',', $test->codes) . "\t expected \t" . implode(',', $expected[$idx]) . PHP_EOL;
    }
