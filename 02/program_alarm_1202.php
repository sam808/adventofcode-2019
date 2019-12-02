<?php

class program_alarm_1202 {
    public $codes = [];

    public function execute_codes() {
        for ($i = 0; $i <= sizeof($this->codes)-3; $i+=4) {
            switch ($this->codes[$i]) {
                case 1:
                    $this->codes[$this->codes[$i+3]] = $this->codes[$this->codes[$i+1]] + $this->codes[$this->codes[$i+2]];
                    break;
                case 2:
                    $this->codes[$this->codes[$i+3]] = $this->codes[$this->codes[$i+1]] * $this->codes[$this->codes[$i+2]];
                    break;
                case 99:
                    break;
                default:
                echo 'operator ' . $this->codes[$i] . ' in ' . $i . PHP_EOL;
                    throw new Exception('Unknown operator');
                    break;
            }
        }
    }
}