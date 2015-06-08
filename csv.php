<?php
// rendu en csv
$out = __DIR__ . '/output/gitall.csv';
if( file_exists($out)){
    unlink($out);
    $messages .= '<br/> gitall.csv régénéré';
}

file_put_contents($out, $csv_html) || die('erreur avec le csv');
chmod($out, 0777);