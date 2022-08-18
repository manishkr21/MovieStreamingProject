<?php

class FormSanitizer{
    // no need to make the instance of the class if static func is used 
    public static function sanitizeFormString($inputText){
        $inputText = strip_tags($inputText); // remove html tags
        // $inputText = str_replace(" ","",$inputText)    // remove the whitespace
        $inputText= trim($inputText);  // remove the whitespace
        $inputText = strtolower($inputText); // convert in lower case
        $inputText = ucfirst($inputText);  // make only first char of given string capital
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText){
        $inputText = strip_tags($inputText); // remove html tags
        $inputText= trim($inputText);  // remove the whitespace
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText){
        $inputText = strip_tags($inputText); // remove html tags
        $inputText= trim($inputText);  // remove the whitespace
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText){
        $inputText = strip_tags($inputText); // remove html tags
        return $inputText;
    }
}

?>