<?php
/**
 * lister les commits de git
 */
// config
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
//$file = __DIR__ . '/gitall.sh';
//$f = fopen($file, "r");
//$command = file_get_contents($file);
//shell_exec($commande) || die('erreur avec le script shell');

$file = __DIR__ . '/git-history.txt';

// ouvrir le fichier texte
$f = fopen($file, "r");
$content = file_get_contents($file);

//var_dump($file);
//var_dump($content);
//var_dump(count($lignes));

// couper par ligne
$lignes = explode(';', $content);
// trier
$group = [];
$byDate = [];
foreach ($lignes as $l) {
    $boom = explode('/', $l);
    $date = $boom[0];
    $auth = $boom[1];
    $sha = $boom[2];
    $msg = $boom[3];
// conversion de date

    $timestamp = strtotime($date);


    $commit = [
        'date' => $timestamp,
        'auth' => $auth,
        'sha' => $sha,
        'msg' => $msg,
    ];
    $byDate[$timestamp] = $commit;
}
// préparer l'affichage
$display = '';

// init des tranches
$oldAn = null;
$an = date('Y');
$oldMois = null;
$mois = date('m');
$jour = date('d');
$heure = date('H');

foreach ($byDate as $d) {

    $timestamp = $d['date'];
    //test de tranche différente
//    var_dump($timestamp);
    $an = date('Y', $timestamp);
    $mois = date('m', $timestamp);
//    $jour = date('d', $timestamp);
//    $heure = date('H', $timestamp);

    if($an != $oldAn){
        $display .= '<h2>'.$an.'</h2>';
    }
    if($mois != $oldMois){
        $display .= '<h3>'.$mois.'</h3>';
    }

    $display .= '<br/> '.date('Y m d H:i:s',$timestamp).' '.$d['msg'];
    $oldAn = $an;
    $oldMois = $mois;
}


// output html
$rep = '<h1>Git log all</h1>';
$rep .= 'Projet commencé il y a x jours';
$rep .= '<br/>' . $display;
$rep .= '<hr/>' . $content;
?>

<html>
<head>
    <meta charset="UTF-8"></meta>
    <title>Git log all</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <?php echo $rep; ?>
</div>
</body>
</html>