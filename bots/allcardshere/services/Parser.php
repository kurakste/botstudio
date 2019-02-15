<?php 

namespace app\allcardshere\services;

class Parser {
    protected $cards;

    public function __construct() {
        // get cards data from file
        $this->cards = require_once(__DIR__.'/cards.php');
    }

    /**
     *  It gets frase as a string and parse it tring to 
     *  find what card was asked by user. 
     */
    public function parse(String $frase) {
        $frase = mb_strtolower($frase, 'UTF-8');
        $input = explode(' ', $frase);
        $inputLenth = count($input);
        if ($inputLenth > 1) {
            for ($i=0; $i<$inputLenth-1; $i++) {
                $input[] = $input[$i].' '.$input[$i+1];
            }
        }
        
        foreach ($this->cards as $card) {
            $common = array_intersect($card['alias'], $input);
            if (count($common)>0) return $card;
        }

        return false;
    } 

    public function getAllCardsNameAsArray() {
        $filtred = array_filter($this->cards, function($element){
            return $element['cardavailable'];
        });
        return array_keys($filtred);
    }

    public function getAllCardsNameAsString() {
        return implode(', ', $this->getAllCardsNameAsArray());
    }

}