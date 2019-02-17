<?php 

namespace skills\humor;

class Anekdot {
    public static function getRandomAnekdot() {
        $jocks = json_decode(file_get_contents(__DIR__.'/anekdot.json')); 
        $rnd = (int)rand(0, count($jocks)-1);
        return $jocks[$rnd];
    }

}
