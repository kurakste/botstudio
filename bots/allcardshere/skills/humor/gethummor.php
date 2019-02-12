<?php 
$jocks = json_decode(file_get_contents(__DIR__.'/anekdot.json')); 

function getJocke(Array $jocks) {
    $rnd = (int)rand(0, count($jocks)-1);
    return $jocks[$rnd];
}

return getJocke($jocks);