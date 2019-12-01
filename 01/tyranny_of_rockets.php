<?php

class tyranny_of_rockets {
    public static function calculate_total_fuel($module_masses) {
        $total_fuel = 0;

        foreach ($module_masses as $module_mass) {            
            $total_fuel += self::get_fuel_for_module_mass($module_mass);
        }

        return $total_fuel;
    }

    public static function calculate_total_fuel_with_fuel_mass($module_masses) {
        $total_fuel = 0;

        foreach ($module_masses as $module_mass) {            
            $total_fuel += self::get_fuel_for_module_mass_with_fuel_mass($module_mass);
        }

        return $total_fuel;
    }

    public static function get_fuel_for_module_mass($module_mass) {
        $module_mass = trim($module_mass);

        $fuel = floor($module_mass / 3) - 2;

        return $fuel < 0 ? 0 : $fuel;
    }

    public static function get_fuel_for_module_mass_with_fuel_mass($module_mass) {
        $fuel = $total_fuel = self::get_fuel_for_module_mass($module_mass);

        while ($fuel > 0) {
            $fuel = self::get_fuel_for_module_mass($fuel);
            $total_fuel += $fuel;
        }

        return $total_fuel;
    }
}