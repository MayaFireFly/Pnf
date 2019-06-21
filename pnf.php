<?php

namespace app\components;

use yii\i18n\Formatter;
use yii\base\InvalidArgumentException;
use yii\base\Exception;

class Pnf extends Formatter {

    public function asPhoneNumber($value, $format = null) 
    {
        try{

            $number = preg_replace("/[^\d]/", "", $value);
            $len = strlen($number);

            if(null === $format){

                $format = [
                    ["/^(\d{1})(\d{3})(\d{3})(\d{4})$/", "$1 $2-$3-$4"],
                    ["/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3"],        
                    ["/^(\d{3})(\d{3,})$/", "$1-$2"],
                ];

                if($len < 10 && $len > 6){
                    $number = preg_replace($format[2][0], $format[2][1], $number);
                }elseif($len == 10){
                    $number = preg_replace($format[1][0], $format[1][1], $number);
                }elseif($len == 11){
                    $number = preg_replace($format[0][0], $format[0][1], $number);
                }elseif($len > 11){
                    throw new InvalidArgumentException("The phone number don't must be greater then 11 characters.");
                }

            }else{
                if(is_array($format) && count($format) === 2 && $this::isRegex($format[0]) && $this::isGroupeRegex($format[1])){
                    $number = preg_replace($format[0], $format[1], $number);
                }else{
                    return "Format must be the array with two items, first - regex with (groups) min - 1, max - 4, second - formatted groups"
                            ." Example: asPhoneNumber('222222', ['/^(\d{2})(\d{2})(\d{2})$/', '$1-$2-$3']) Output: 22-22-22";                    
                }                
            }

        }catch(Exception $e){
                return $e;
        } 
        
        return $number;
    }

    public static function isRegex($str) {
        $regex = "/^\/[\s\S]+\/$/";                      
        return preg_match($regex, $str);
    }

    public static function isGroupeRegex($strGroupe){
        $regexGroupe = '/^(\(?(\$\d)\)?\-?){1,4}$/';
        return preg_match($regexGroupe, $strGroupe);
    }
}