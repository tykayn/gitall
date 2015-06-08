<?php

// dossier d'output
if( !file_exists($output_folder)){
    mkdir($output_folder) || die('impossible de créer le dossier d\' output. ' . $output_folder);
}
// écrire dans les fichiers
$out = $output_folder .'index.html';
if( file_exists($out)){
    unlink($out);
    $messages .= '<br/> html régénéré';
}
file_put_contents($out, $html);