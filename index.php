<?php
/**
 * lister les commits de git
 */
// config
$file = __DIR__ . '/git-history.txt';

// ouvrir le fichier texte
$f = fopen($file, "r");
$content = file_get_contents($file) ;
//var_dump($file);
//var_dump($content);
var_dump(count($lignes));

// couper par ligne
$lignes = explode('\n', $content);
// conversion de date

// trier

// output html
$rep = '<h1>Git log all</h1>';
$rep .= 'Projet commencé il y a x jours';
$rep .= '<br/>' .$content ;
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