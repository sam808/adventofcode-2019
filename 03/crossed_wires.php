<?php

class crossed_wires {
    private const INTERSECTION = 'X';
    private const START = 'o';
    private const WIRES = ['*', '+'];

    public $wire1_path = [];
    public $wire2_path = [];

    public $grid = [];

    public static function parse_wire_path($string) {
        return array_map(function($val) {
            return trim($val);
        }, explode(',', $string));
    }

    public function map_wire_paths() {
        $this->grid = [];

        foreach ([$this->wire1_path, $this->wire2_path] as $wire_idx => $path) {
            $x = $y = $cumulative_length = 0;

            foreach ($path as $instruction) {
                $direction = substr($instruction, 0, 1);
                $length = substr($instruction, 1);

                if ($direction == 'U' || $direction == 'L') {
                    $direction_multiplier = -1;
                }
                else {
                    $direction_multiplier = 1;
                }

                switch ($direction) {
                    case 'D':
                    case 'U':
                        for ($i = 0; $i <= $length; $i++) {
                            if ($i > 0) {
                                $cumulative_length++;
                            }
            
                            $val = $this->grid[$x][$y + ($i * $direction_multiplier)] ?? NULL;

                            if (empty($val)) {
                                $this->grid[$x][$y + ($i * $direction_multiplier)] = [self::WIRES[$wire_idx], $cumulative_length];
                            }
                            elseif ($val[0] != self::WIRES[$wire_idx]) {
                                $this->grid[$x][$y + ($i * $direction_multiplier)] = [self::INTERSECTION, $val[1] + $cumulative_length];
                            }
                        }

                        $y = $y + ($length * $direction_multiplier);
                        break;
                    case 'L':
                    case 'R':
                        for ($i = 0; $i <= $length; $i++) {
                            if ($i > 0) {
                                $cumulative_length++;
                            }

                            $val = $this->grid[$x + ($i * $direction_multiplier)][$y] ?? NULL;

                            if (empty($val)) {
                                $this->grid[$x + ($i * $direction_multiplier)][$y] = [self::WIRES[$wire_idx], $cumulative_length];
                            }
                            elseif ($val[0] != self::WIRES[$wire_idx]) {
                                $this->grid[$x + ($i * $direction_multiplier)][$y] = [self::INTERSECTION, $val[1] + $cumulative_length];
                            }
                        }

                        $x = $x + ($length * $direction_multiplier);
                        break;                        
                }
            }
        }

        $this->grid[0][0] = self::START;
    }

    public function get_intersections($timing = FALSE) {
        $intersections = [];

        foreach ($this->grid as $x => $ys) {
            foreach ($ys as $y => $val) {
                if ($this->grid[$x][$y][0] == self::INTERSECTION) {
                    $intersections[$x . 'x' . $y] = $timing ? $this->grid[$x][$y][1] : (abs($x) + abs($y));
                }
            }
        }

        return $intersections;
    }

    public function get_closest_intersection($timing = FALSE) {
        return min($this->get_intersections($timing));
    }

    public function print_grid($distance = FALSE) {
        // print_r($this->grid);
        $min_x = min(array_keys($this->grid));
        $max_x = max(array_keys($this->grid));
        $min_y = $max_y = NULL;

        foreach ($this->grid as $x => $ys) {
            if (empty($min_y) || min(array_keys($this->grid[$x])) < $min_y) {
                $min_y = min(array_keys($this->grid[$x]));
            }
            if (empty($max_y) || max(array_keys($this->grid[$x])) < $min_y) {
                $max_y = max(array_keys($this->grid[$x]));
            }
        }

        // echo 'THIS IS A ' . $min_x . ' to ' . $max_x . ' by ' . $min_y . ' to ' . $max_y . ' GRID ' . PHP_EOL;

        for ($y = $min_y; $y <= $max_y; $y++) {
            for ($x = $min_x; $x <= $max_x; $x++) {
                echo ($this->grid[$x][$y][$distance ? 1 : 0] ?? '-') . ' ';
            }

            echo PHP_EOL;
        }

        echo PHP_EOL;
        echo PHP_EOL;
    }
}