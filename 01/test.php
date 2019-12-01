<?php

    require 'tyranny_of_rockets.php';

    $test = new tyranny_of_rockets();
    $inputs = [
        12,
        14,
        1969,
        100756,
    ];

    $expected = [
        2,
        2,
        654,
        33583,
    ];
    
    foreach ($inputs as $idx => $module_mass) {
        $result = $test::get_fuel_for_module_mass($module_mass);
        
        echo ($result == $expected[$idx] ? '[PASS] ' : '[FAIL] ');
        echo $module_mass . "\t" . $result . "\t expected \t" . $expected[$idx] . PHP_EOL;
    }

    echo 'PART 1 TOTAL ' . $test::calculate_total_fuel($inputs) . PHP_EOL;

    $expected = [
        2,
        2,
        966,
        50346,
    ];
    
    foreach ($inputs as $idx => $module_mass) {
        $result = $test::get_fuel_for_module_mass_with_fuel_mass($module_mass);
        
        echo ($result == $expected[$idx] ? '[PASS] ' : '[FAIL] ');
        echo $module_mass . "\t" . $result . "\t expected \t" . $expected[$idx] . PHP_EOL;
    }

    echo 'PART 1 TOTAL ' . $test::calculate_total_fuel_with_fuel_mass($inputs) . PHP_EOL;
