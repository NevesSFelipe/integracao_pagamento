<?php

namespace App;

class Environment {
    
    public static function load(string $dir)
    {
        $env = "$dir/.env";
        if(!file_exists($env)) {
            return false;
        }

        $lines = file($env);
        foreach($lines as $line) {
            putenv(trim($line));
        }
    }

}

?>