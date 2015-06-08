<?php
// rendu en csv
//var_dump($csv);
$out = __DIR__ . '/output/gitall.csv';
if( file_exists($out)){
    unlink($out);
    $messages .= '<br/> gitall.csv régénéré';
}


file_put_contents($out, $csv) || die('erreur avec le csv');