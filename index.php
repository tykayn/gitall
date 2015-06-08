<?php
/**
 * lister les commits de git
 */
// config
$separator = '/';
$author = '--author=""';
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
$file = __DIR__ . '/gitall.sh';
$f = fopen($file, "r");



$command = 'git log --pretty=format:"%cd '.$separator.' %cn'.$separator.' %h'.$separator.' %s;" --full-history '.$author;
//remplir le fichier bash
shell_exec($command.' > gitall.sh');
// ouvrir le fichier texte
$f = fopen($file, "r");
$content = file_get_contents($file);
var_dump($content);
$ret = shell_exec($command.' 2>&1');
var_dump($ret);
//die('erreur avec le script shell');

$file = __DIR__ . '/git-history.txt';
$joursFr = [
    "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim",
];
$moisFr = [
    "01" => "Jan", "02" => "Fév", "03" => "Mar", "04" => "Avr", "05" => "Mai", "06" => "Juin", "07" => "Juillet",
    "08" => "Aoû", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Déc"
];


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

$countcommits = count($byDate);
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
        $display .= '<small class="row-fluid">semaine ' . $semaine . ' </small>';
    }
    if ($jour != $oldJour) {
        $display .= '<h4>' . $joursFr[date('w', $timestamp) - 1] . ' ' . $jour . ' </h4>';
    }
    if ($heure != $oldHeure) {
        $display .= '<h5>' . $heure . 'h</h5>';
    }

    $display .= '<div class="row">
<div class="col-lg-2 text-right">' . date('i:s', $timestamp) . '</div>
 <div class="col-lg-10">  ' . $d['msg'] . '</div>
 </div>';
    $oldAn = $an;
    $oldMois = $mois;
    $oldSemaine = $semaine;
    $oldHeure = $heure;
    $oldJour = $jour;
}


// calcul du début
$firstDate = array_shift($byDate);
$lastDate = array_pop($byDate);
$ts1 = $firstDate['date'];
$ts2 = $lastDate['date'];

$datediff = $ts1 - $ts2;

$secPerDay = 3600 * 24;
$datediff = $datediff / $secPerDay;
if ($datediff < 2) {
    $datediff = round($datediff * 24, 1) . ' h';
} else {
    $datediff = $datediff . ' jours';
}
echo '<br/>';
//var_dump($datediff);
// output html
$rep = '';
$rep .= 'Projet commencé il y a ' . ceil($datediff) . '. ' . $countcommits . ' commits';
$rep .= '<br/>' . $display;
//$rep .= '<hr/>' . $content;
?>

<html>
<head>
    <meta charset="UTF-8"></meta>
    <title>Git log all</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row-fluid">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Feuille de route</h1>
                </div>
                <div class="panel-body">
                    <?php echo $rep; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h2>Options</h2>
            <form action="/" method="get">
                tri par auteur
                <input type="text" name="a"/>
                <input type="submit" value="mettre à jour"/>
            </form>
        </div>
    </div>



    <h1>Fonctionnement</h1>

    <div class="row-fluid">
        <div class="col-lg-5">
            cette page php permet de vous fournir un log complet par tranches de votre historique git. copiez
            l'index.php dans votre dossier de projet initialisé avec git. accédez à la page php, et hop miracle voici un
            résumé html daté de tous les commits.
            <hr/>
            Git log all
            <hr/>
            <a href="http://artlemoine.com" class="btn btn-primary">portfolio</a>
            <a href="http://github.com/tykayn" class="btn btn-primary">github tykayn</a>
        </div>
        <div class="col-lg-7">

        </div>
    </div>


</div>
<style>
    h2 {
        margin-left: 0.5em;
    }

    h3 {
        margin-left: 1em;
    }

    h4 {
        margin-left: 3em;
    }

    h5 {
        margin-left: 4em;
    }
</style>
</body>
</html>