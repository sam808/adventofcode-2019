<?php

class thermal_environment {
    const MAX_PARAMS = 4;

    public $codes = [];
    public $debug = FALSE;

    private function get_params($start_idx, $number, $param_modes, $write_params = []) {
        $params = [];
        
        for ($i = 0; $i < $number; $i++) {
            if ($param_modes[$i] == 1 || in_array($i, $write_params)) {
                $params[$i] = $this->codes[$start_idx + $i + 1];
            }
            elseif ($param_modes[$i] == 0) {
                $params[$i] = $this->codes[$this->codes[$start_idx + $i + 1]];
            }
        }

        return $params;
    }

    public function execute_codes($input_instruction) {

        $i = 0;

        while ($i < sizeof($this->codes)) {
            $code = substr($this->codes[$i], strlen($this->codes[$i]) - 2);

            if ($this->debug) {
                echo ' CODE is ' . $this->codes[$i] . ' at ' . $i . PHP_EOL;
            }
            
            $param_modes = array_reverse(str_split(substr($this->codes[$i], 0, strlen($this->codes[$i]) - 2)));
            if (empty($param_modes[0])) {
                $param_modes[0] = 0;
            }
            $param_modes = array_merge($param_modes, array_fill(sizeof($param_modes), self::MAX_PARAMS - sizeof($param_modes), 0));
            
            switch ($code) {
                case 1:
                    $num_params = 3;
                    $params = $this->get_params($i, $num_params, $param_modes, [2]);
                    $this->codes[$params[2]] = $params[0] + $params[1];

                    if ($this->debug) {
                        echo ' PUTTING  ' . ($params[0] + $params[1]) . ' into ' . $params[2] . PHP_EOL;
                    }

                    break;
                case 2:
                    $num_params = 3;
                    $params = $this->get_params($i, $num_params, $param_modes, [2]);
                    $this->codes[$params[2]] = $params[0] * $params[1];

                    if ($this->debug) {            
                        echo ' PUTTING  ' . ($params[0] * $params[1]) . ' into ' . $params[2] . PHP_EOL;
                    }

                    break;
                case 3:
                    $num_params = 1;
                    $params = $this->get_params($i, $num_params, $param_modes, [0]);
                    $this->codes[$params[0]] = $input_instruction;

                    if ($this->debug) {
                        echo ' PUTTING  ' . $input_instruction . ' into ' . $params[0] . PHP_EOL;
                    }

                    break;
                case 4:
                    $num_params = 1;
                    $params = $this->get_params($i, $num_params, $param_modes);
                    echo ' OUTPUT ' . $params[0] . PHP_EOL;

                    break;
                case 5:
                    $num_params = 2;
                    $params = $this->get_params($i, $num_params, $param_modes);
                    
                    if (!empty($params[0])) {
                        $i = $params[1];
                        continue 2;
                    }

                    break;
                case 6:
                    $num_params = 2;
                    $params = $this->get_params($i, $num_params, $param_modes);
                    
                    if (empty($params[0])) {
                        $i = $params[1];
                        continue 2;
                    }

                    break;
                case 7:
                    $num_params = 3;
                    $params = $this->get_params($i, $num_params, $param_modes, [2]);

                    $this->codes[$params[2]] = ($params[0] < $params[1]) ? 1 : 0;

                    break;
                case 8:
                    $num_params = 3;
                    $params = $this->get_params($i, $num_params, $param_modes, [2]);

                    $this->codes[$params[2]] = ($params[0] == $params[1]) ? 1 : 0;

                    break;
                case 99:
                    $num_params = 1;
                    echo ' BREAK ' . PHP_EOL;

                    return;
                default:
                    $num_params = 1;
                    echo ' UNKNOWN OPERATOR ' . $code . PHP_EOL;

                    break;
            }

            $i += $num_params + 1;
        }
    }
}