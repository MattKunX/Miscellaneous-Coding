<?php
/*
    Scoreboard
    Rank domains based on total bonus gb per domain.
    domain +20 points per email
    100 points 3gb
    200 points 8gb
    300 points 15gb
    500 points 25gb
*/
function solution($emails) {
    $matches = null;
    $scores = [];
    
    foreach ($emails as $email) {
        preg_match('/@(.*)/', $email, $matches);
        
        if (isset($scores[$matches[1]]))
            $scores[$matches[1]] += 20;
        else
            $scores[$matches[1]] = 20;
    }
 
    foreach ($scores as $k => $score) {
        if ($score >= 500)
            $scores[$k] = 25;
        else if ($score >= 300)
            $scores[$k] = 15;
        else if ($score >= 200)
            $scores[$k] = 8;
        else if ($score >= 100)
            $scores[$k] = 3;
        else
            $scores[$k] = 0;
    }
    krsort($scores);
    natsort($scores);
    $scores = array_reverse($scores);

    return array_keys($scores);
}

function test() {
    $results = [];
    $results[] = solution(["john.doe@mit.edu", "admin@rain.ifmo.ru", "noname@mit.edu"]) === ["mit.edu", "rain.ifmo.ru"];
    $results[] = solution(["b@harvard.edu", 
                            "c@harvard.edu", 
                            "d@harvard.edu", 
                            "e@harvard.edu", 
                            "f@harvard.edu", 
                            "a@student.spbu.ru", 
                            "b@student.spbu.ru", 
                            "c@student.spbu.ru", 
                            "d@student.spbu.ru", 
                            "e@student.spbu.ru", 
                            "f@student.spbu.ru", 
                            "g@student.spbu.ru"]) === ["harvard.edu", "student.spbu.ru"];
    $results[] = solution(["a@rain.ifmo.ru", 
                            "b@rain.ifmo.ru", 
                            "c@rain.ifmo.ru", 
                            "d@rain.ifmo.ru", 
                            "e@rain.ifmo.ru", 
                            "noname@mit.edu"]) === ["rain.ifmo.ru", "mit.edu"];
    $results[] = solution(["john.doe@mit.edu", "admin@rain.ifmo.ru"]) === ["mit.edu", "rain.ifmo.ru"];
    $results[] = solution(["a@rain.ifmo.ru", 
                            "b@rain.ifmo.ru", 
                            "c@rain.ifmo.ru", 
                            "d@rain.ifmo.ru", 
                            "e@rain.ifmo.ru", 
                            "f@rain.ifmo.ru", 
                            "g@rain.ifmo.ru", 
                            "h@rain.ifmo.ru", 
                            "i@rain.ifmo.ru", 
                            "j@rain.ifmo.ru", 
                            "k@rain.ifmo.ru", 
                            "l@rain.ifmo.ru", 
                            "m@rain.ifmo.ru", 
                            "n@rain.ifmo.ru", 
                            "o@rain.ifmo.ru", 
                            "p@rain.ifmo.ru", 
                            "q@rain.ifmo.ru", 
                            "r@rain.ifmo.ru", 
                            "s@rain.ifmo.ru", 
                            "t@rain.ifmo.ru", 
                            "u@rain.ifmo.ru", 
                            "v@rain.ifmo.ru", 
                            "w@rain.ifmo.ru", 
                            "x@rain.ifmo.ru", 
                            "y@rain.ifmo.ru", 
                            "a@mit.edu.ru", 
                            "b@mit.edu.ru", 
                            "c@mit.edu.ru", 
                            "d@mit.edu.ru", 
                            "e@mit.edu.ru", 
                            "f@mit.edu.ru", 
                            "g@mit.edu.ru", 
                            "h@mit.edu.ru", 
                            "i@mit.edu.ru", 
                            "j@mit.edu.ru", 
                            "k@mit.edu.ru", 
                            "l@mit.edu.ru", 
                            "m@mit.edu.ru", 
                            "n@mit.edu.ru", 
                            "o@mit.edu.ru"]) === ["rain.ifmo.ru", "mit.edu.ru"];
    $results[] = solution(["b@rain.ifmo.ru", 
                            "c@rain.ifmo.ru", 
                            "d@rain.ifmo.ru", 
                            "e@rain.ifmo.ru", 
                            "f@rain.ifmo.ru", 
                            "g@rain.ifmo.ru", 
                            "h@rain.ifmo.ru", 
                            "i@rain.ifmo.ru", 
                            "j@rain.ifmo.ru", 
                            "k@rain.ifmo.ru", 
                            "l@rain.ifmo.ru", 
                            "m@rain.ifmo.ru", 
                            "n@rain.ifmo.ru", 
                            "o@rain.ifmo.ru", 
                            "p@rain.ifmo.ru", 
                            "q@rain.ifmo.ru", 
                            "r@rain.ifmo.ru", 
                            "s@rain.ifmo.ru", 
                            "t@rain.ifmo.ru", 
                            "u@rain.ifmo.ru", 
                            "v@rain.ifmo.ru", 
                            "w@rain.ifmo.ru", 
                            "x@rain.ifmo.ru", 
                            "y@rain.ifmo.ru", 
                            "a@mit.edu.ru", 
                            "b@mit.edu.ru", 
                            "c@mit.edu.ru", 
                            "d@mit.edu.ru", 
                            "e@mit.edu.ru", 
                            "f@mit.edu.ru", 
                            "g@mit.edu.ru", 
                            "h@mit.edu.ru", 
                            "i@mit.edu.ru", 
                            "j@mit.edu.ru", 
                            "k@mit.edu.ru", 
                            "l@mit.edu.ru", 
                            "m@mit.edu.ru", 
                            "n@mit.edu.ru", 
                            "o@mit.edu.ru"]) === ["mit.edu.ru", "rain.ifmo.ru"];

    var_dump($results);
}

test();
?>