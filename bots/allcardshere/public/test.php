<?php
require_once("../../../vendor/autoload.php");

use app\allcardshere\services\Parser;


$frase = "дЕкатлон fuckin Marry Poppins";

$parser = new Parser;
$res = $parser->parse($frase);
$res = $parser->getAllCardsNameAsString();

var_dump($res);