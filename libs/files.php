<?php
// écrire dans les fichiers
$out = __DIR__ . '/../output/index.html';
if( file_exists($out)){
    unlink($out);
    $messages .= '<br/> html régénéré';
}
file_put_contents($out, $html);