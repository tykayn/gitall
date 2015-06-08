<?php
/**
 * lister les commits de git
 */
// config
$separator = '/';
$end = ';';
$messages = '';
$out = __DIR__ . '/output/index.html';
require('traitements.php');
require('rendu.php');

if( file_exists($out)){
    unlink($out);
    $messages .= '<br/> html régénéré';
}
file_put_contents($out, $html);

require('csv.php');
?>
<html>
<head>
    <meta charset="UTF-8"></meta>
    <title>Git log all</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="well">
                <?php
                echo $stats;
                ?>
            </div>
            <?php
            echo $rep;
            ?>
        </div>
        <div class="col-lg-6">
            <form action="/" method="get">
                <fieldset>
                    <h2>Options</h2>
                    tri par auteur
                    <input type="text" name="a"/>
                    <input type="submit" value="mettre à jour"/>
                </fieldset>
            </form>
            <?php
            if($messages){
                echo'<div class="alert alert-info">'.$messages.'</div>';
            }
            ?>
            <div class="row">
                sorties générées:
                <ul>
                    <li>
                        html dans <a href="output/index.html">output/index.html</a>.
                    </li>
                    <li>
                        csv dans <a href="output/gitall.csv">output/gitall.csv</a>.
                    </li>
                </ul>
            </div>

            <hr/>
            <?php
            echo $csv_html;
            ?>
            <hr/>
            <h1>Fonctionnement</h1>
            cette page php permet de vous fournir un log complet par tranches de votre historique git.
            Clonez ce dépot dans le dossier de votre projet initialisé avec git. vous obtiendrez un dossier nommé
            <strong>gitall</strong>.
            accédez y via votre navigateur web, (par example via <a href="http://localhost/gitall/">http://localhost/gitall/</a> ) et hop miracle voici un résumé html daté de tous les commits au rendu
            configurable, exporté en différents formats dans le dossier <strong>gitall/output</strong>.
            <hr/>
            <div class="well">
                <a class="btn btn-primary" href="https://github.com/tykayn/gitall">
                    Git all</a>
                <hr/>
                <a href="http://artlemoine.com" class="btn btn-primary">portfolio</a>
                <a href="http://github.com/tykayn" class="btn btn-primary">github tykayn</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>