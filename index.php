<?php
/**
 * lister les commits de git
 */
// config
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
        'date' => $date,
        'auth' => $auth,
        'sha' => $sha,
        'msg' => $msg,
    ];
    $byDate[$timestamp] = $commit;
}
// préparer l'affichage
$display = '';
foreach ($byDate as $d) {

    //test de tranche différente
//    var_dump($timestamp);
//    $an = date('Y', $timestamp);
//    $mois = date('m', $timestamp);
//    $jour = date('d', $timestamp);
//    $heure = date('H', $timestamp);

    $display .= '<br/> '.$d[msg];
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
</head>
<body>
<?php echo $rep; ?>
</body>
</html>