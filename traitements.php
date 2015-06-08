<?php

$author = '';
$content = '';
if (isset($_POST['a'])) {
    $author = '--author="' . $_POST['a'] . '"';
}


$command = 'git log --pretty=format:"%cd ' . $separator . ' %cn' . $separator . ' %h' . $separator . ' %s' . $end . '" --full-history ' . $author;
//remplir le fichier bash
//$lines = shell_exec($command.' > gitall.sh');
$hist = shell_exec($command);
// ouvrir le fichier texte
//$file = __DIR__ . '/git-history.txt';
$ret = shell_exec($command . ' 2>&1') || die('erreur avec le script shell');
// écrire le fichier histoire
$bash_script = __DIR__ . '/gitall.sh';
//$f = fopen($file, "rw");
file_put_contents($bash_script, $command);

//$ret = shell_exec($command.' > git-history.txt;') || die('erreur avec git-history.txt');


$file = __DIR__ . '/git-history.txt';
$joursFr = [
    "Lun",
    "Mar",
    "Mer",
    "Jeu",
    "Ven",
    "Sam",
    "Dim",
];
$moisFr = [
    "01" => "Jan",
    "02" => "Fév",
    "03" => "Mar",
    "04" => "Avr",
    "05" => "Mai",
    "06" => "Juin",
    "07" => "Juillet",
    "08" => "Aoû",
    "09" => "Sep",
    "10" => "Oct",
    "11" => "Nov",
    "12" => "Déc"
];


// couper par ligne
$lignes = explode(';', $hist);
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

$csv = 'Date,Auteur, commit,message
';
$csv_html = $csv . '<br/>';
$joursDifferents = [];
$joursWeekend = 0;

foreach ($byDate as $d) {
    $jsemaine = $joursFr[date('w', $timestamp)-1];
    // compter les jours différents.
    if(!isset($joursDifferents[date('Y/m/d', $d['date'])])){
        $joursDifferents[date('Y/m/d', $d['date'])] = 1;
        // compter les jours de weekend
        if( in_array($jsemaine , ['samedi','dimanche'])){
            $joursWeekend++;
        }

    }




    $csv_part = date('Y/m/d H:i:s', $d['date']) . ',' . $d['auth'] . ',' . $d['sha'] . ',' . str_replace( ',' , ';', $d['msg']) . '
    ';
    $csv .= $csv_part;
    $csv_html .= $csv_part . '<br/>';
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
    $datediff = round($datediff) . ' jours';
}
echo '<br/>';
//var_dump($datediff);
// output html
$rep = '';
$rep .= 'Projet commencé il y a ' . $datediff . '. ' . $countcommits . ' commits';
$rep .= '<br/>' . $display;
//$rep .= '<hr/>' . $content;
