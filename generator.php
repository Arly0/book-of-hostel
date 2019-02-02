<?php

function generator_captcha(){
    // think here all not hard
    $symbol = 'qwertyupkjhgfdsazxcvbnm23456789';
    $len = rand(4,6);
    $lenSymbol = strlen($symbol);
    $chars = '';
    $symbol_arr = str_split($symbol);

    for($i=0;$i<$len;$i++)
    {
        $chars .= $symbol_arr[rand(1,$lenSymbol)];
    }
    return $chars;
}