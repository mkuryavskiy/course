<?php

function generate_code() 
{    
    $chars = '1234567890';
    $length = 5;
    $numChars = strlen($chars);
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $chars[random_int(0, $numChars - 1)];
    }

    return $code;
}

?>
