<?php


function writeToFile($fileName, $content) {
    $f = fopen($fileName, 'w');
    fwrite($f, $content);
    fclose($f);
}

function sortTranslations($fileName) {
    $translations = array();    // associative: translation key value pair
    $comments = array();        // associative: hold all comments as an array against the key 
    $commentsStack = array();   // linear: temporary area to store comments
    $output = '';               // str; final sorted translations

    if ($file = fopen($fileName, 'r')) {
        while(!feof($file)) {
            $line = trim(fgets($file));
            if (!$line) continue;   // ignore empty lines [optional]
            if (strpos( $line, '#' ) !== 0) {
                // line is not comment
                $part = explode('=', $line);
                $key = trim($part[0]);
                $val = trim($part[1]);
                $translations[$key] = $val; //build translation pair
                if (count($commentsStack)) {
                    // there are comments in the stack, create new pair to be used later on
                    $comments[$key] = $commentsStack;
                    $commentsStack = array();
                }
            }
            else {
                // line is a comment
                if (count($commentsStack)) {
                    array_push($commentsStack, $line);  // there are multi-line comment, otherwise got it cleaned in #22
                }
                else {
                    $commentsStack = array($line);      // first comment line
                }

            }
        }
        fclose($file);
    }

    asort($translations);  // sort in ASC

    foreach($translations as $key=>$val) {
        if (isset($comments[$key])) {
            $output .= implode(PHP_EOL, $comments[$key]) . PHP_EOL;    // join multi line or single comments 
        }
        $output .= $key . '=' . $val . PHP_EOL;                        // the translaiton pair
    }
    return $output;
}

$sorted = sortTranslations('.properties');
writeToFile('sorted.properties', $sorted);

echo '<h1>Sorting Done!</h1>';
echo 'Srouce file: .properties<Br/>';
echo 'New File: sorted.properties';
//  echo '<pre>';
//  print_r($sorted);

     ?>