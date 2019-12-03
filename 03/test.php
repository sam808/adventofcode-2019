<?php

    require 'crossed_wires.php';

    $test = new crossed_wires();
    $inputs = [
        [
            'L4,U12,D12,L3,U5,R8',
            'R5,D5,L5,U15,L10'
        ],
        [
            'R75,D30,R83,U83,L12,D49,R71,U7,L72',
            'U62,R66,U55,R34,D71,R55,D58,R83'
        ],
        [
            'R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51',
            'U98,R91,D20,R16,D67,R40,U7,R15,U6,R7'
        ],
    ];

    $expected = [
        5,
        159,
        135
    ];
    
    foreach ($inputs as $idx => $paths) {
        $test->wire1_path = $test::parse_wire_path($paths[0]);
        $test->wire2_path = $test::parse_wire_path($paths[1]);

        $test->map_wire_paths();

        if ($idx == 0) {
            $test->print_grid();
        }

        $intersection = $test->get_closest_intersection();

        echo 'PART 1 ' . ($intersection === $expected[$idx] ? '[PASS] ' : '[FAIL] ');
        echo implode("\t", $paths) . "\t\t" . $intersection . "\t expected \t" . $expected[$idx] . PHP_EOL;
    }

    $inputs = [
        [
            'L4,U12,D12,L3,U5,R8',
            'R5,D5,L5,U15,L10'
        ],
        [
            'R75,D30,R83,U83,L12,D49,R71,U7,L72',
            'U62,R66,U55,R34,D71,R55,D58,R83'
        ],
        [
            'R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51',
            'U98,R91,D20,R16,D67,R40,U7,R15,U6,R7'
        ],
    ];

    $expected = [
        48,
        610,
        410
    ];
    
    foreach ($inputs as $idx => $paths) {
        $test->wire1_path = $test::parse_wire_path($paths[0]);
        $test->wire2_path = $test::parse_wire_path($paths[1]);

        $test->map_wire_paths();

        if ($idx == 0) {
            $test->print_grid(TRUE);
        }

        $intersection = $test->get_closest_intersection(TRUE);

        echo 'PART 2 ' . ($intersection === $expected[$idx] ? '[PASS] ' : '[FAIL] ');
        echo implode("\t", $paths) . "\t\t" . $intersection . "\t expected \t" . $expected[$idx] . PHP_EOL;
    }



