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
$joursFr = [
    "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim",
];
$moisFr = [
    "01" => "Jan", "02" => "Fév", "03" => "Mar", "04" => "Avr", "05" => "Mai", "06" => "Juin", "07" => "Juillet",
    "08" => "Aoû", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Déc"
];
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
    $timestamp = strtotime($date);
    if (!$timestamp) {
        continue;
    }
    $auth = $boom[1];
    $sha = $boom[2];
    $msg = $boom[3];
// conversion de date


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

$oldSemaine = null;
$semaine = date('W');

$oldMois = null;
$mois = date('m');

$oldJour = null;
$jour = date('d');

$oldHeure = null;
$heure = date('H');

foreach ($byDate as $d) {

    $timestamp = $d['date'];
    //test de tranche différente
    $an = date('Y', $timestamp);
    $mois = date('m', $timestamp);
    $jour = date('d', $timestamp);
    $heure = date('H', $timestamp);
    $semaine = date('W', $timestamp);

    if ($an != $oldAn) {
        $display .= '<h2>' . $an . '</h2>';
    }
    if ($mois != $oldMois) {
        $display .= '<hr/><h3>' . $moisFr[$mois] . '</h3>';
    }
    if ($semaine != $oldSemaine) {
        $display .= '<small class="row-fluid">semaine '. $semaine. ' </small>';
    }
    if ($jour != $oldJour) {
        $display .= '<h4>'. $joursFr[date('w', $timestamp) - 1] . ' ' .$jour. ' </h4>';
    }
    if ($heure != $oldHeure) {
        $display .= '<h5>' . $heure . 'h</h5>';
    }

    $display .= '<div class="row">
<div class="col-lg-2">' . date('i:s', $timestamp) . '</div>
 <div class="col-lg-10">  ' . $d['msg'] . '</div>
 </div>';
    $oldAn = $an;
    $oldMois = $mois;
    $oldSemaine = $semaine;
    $oldHeure = $heure;
    $oldJour = $jour;
}


// calcul du début

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