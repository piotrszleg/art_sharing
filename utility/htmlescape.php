<?php
// returns false if $var is not a string
// otherwise, returns a string with \n, ', ", \, \0, / (to prevent XSS) escaped
function escapeForJSString($var) {
    return str_replace(
        "/" // escape forward slash to prevent XSS
        , "\\/"
        , str_replace(
            "\n" // escape newline
            , "\\n"
            , ($var) // escape sq, dq, backslash, and null byte
        )
    );
}
// wrapper for htmlspecialchars so we escape single and double quotes
function escapeHTMLSpecialChars($text="") {
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8', true);
}

function htmlescape($value){
    return stripslashes(escapeHTMLSpecialChars(escapeForJSString($value)));
}

/*backup
function escapeForJSString($var) {
    if(!is_string($var)) return false;
    return str_replace(
        "/" // escape forward slash to prevent XSS
        , "\\/"
        , str_replace(
            "\n" // escape newline
            , "\\n"
            , addslashes($var) // escape sq, dq, backslash, and null byte
        )
    );
}
function htmlescape($value){
    return stripslashes(escapeHTMLSpecialChars(escapeForJSString($value)));
}*/
?>