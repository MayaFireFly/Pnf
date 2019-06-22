# Pnf

PhoneNumberFormatter for yii2

Напишите свой formatter телефонного номера, формат/маска задается опционально. В БД лежит числовое представление номера.

Copy and pass in "app/components" folder file pnf.php

Add in config your's app (components):

'pnf' => [

           'class' => 'app\components\pnf',
           
           //uncomment if you want to pass your's parameters of length phone numbers
           
           //default maxLength = 11, minLength = 5
           
           //'numberMaxLength' => 11,
           
           //'numberMinLength' => 5,
           
       ],
