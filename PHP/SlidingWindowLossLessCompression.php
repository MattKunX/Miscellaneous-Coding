<?php
/* 
    Sliding Window Compression
    Current character 'i'
    Window: s[i - $width, i - 1], where s[i, j] means the substring of 's' from index 'i' to index 'j', both inclusive
            if less than $width characters before the current one, then s[0, i - 1]
    Find such startIndex and length that s[i, i + length - 1] = s[startIndex, startIndex + length - 1] and s[startIndex, startIndex + length - 1] is contained within the window. 
    If there are several such pairs, choose the one with the largest length. 
    If there still remains more than one option, choose the one with the smallest startIndex.
    If the search was successful, append "(startIndex,length)" to the result and move to the index i + length.
    Otherwise, append the current character to the result and move on to the next one.

    Example:
    $inputString = "abacabadabacaba", $width = 7
    solution($inputString, $width) = "ab(0,1)c(0,3)d(4,3)c(8,3)".
*/

function losslessDataCompression($inputString, $width) {
    $window = '';
    $result = '';
    $i = 0;
    $string_len = strlen($inputString);
    
    while($i < $string_len){
        $ii = $i - $width;
        $j = $width + $ii;
        if($ii < 0)
            $ii = 0;
        if($j > $width)
            $j = $width;
        
        $found = false;
        $window = substr($inputString,$ii,$j);
        $winlen = strlen($window);
        if($winlen > 0){
            $length = 0;
            for($l=1;$l<=$winlen;$l++){
                $lookup = substr($inputString,$i,$l);
                $f = strpos($window,$lookup);
                //echo "\nL:$lookup:$f";
                if($f !== false){
                    if(strlen($lookup) > $length){
                        $found = $f;
                        $length = strlen($lookup);
                    }
                }
            }
        }
        
        //echo "\n$i:{$inputString[$i]} W:$window\n";
        
        if($found !== false){
            $windowIndex = $ii+$found;
            $result .= "($windowIndex,$length)";
            $i += $length;
        }else{
            $result .= $inputString[$i];
            $i++;
        }
        //$window .= $inputString[$i];
    }
    return $result;
}

function test() {
    $results = [];
    $results[] = losslessDataCompression("abacabadabacaba", 7) === "ab(0,1)c(0,3)d(4,3)c(8,3)";
    $results[] = losslessDataCompression("abacabadabacaba", 8) === "ab(0,1)c(0,3)d(0,7)";
    $results[] = losslessDataCompression("aaaaaaaaaaaaaaaaaaaaaaaaaaaa", 12) === "a(0,1)(0,2)(0,4)(0,8)(4,12)";
    $results[] = losslessDataCompression("aaabbbaaabbb", 1) === "a(0,1)(1,1)b(3,1)(4,1)a(6,1)(7,1)b(9,1)(10,1)";
    $results[] = losslessDataCompression("y", 1) === "y";
    $results[] = losslessDataCompression("specialword", 20) === "specialword";
    var_dump($results);
}

test();
?>