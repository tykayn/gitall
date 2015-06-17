# gitall
create a dated history of your commits in a readble way by adding a php file in your project.
Clone this into your git versionned project, navigate to the cloned folder via your browser, and bam! you know stuff about your logs.
Caution! your folder needs execution rights to generate the output files of the logs.

## Usage
look at the French version bewlow:
-----

# Français
cette page php permet de vous fournir un log complet par tranches de votre historique git.

## Utilisation
vous aurez besoin de:
    * git
    * php installé sur votre machine
    * un projet initialisé avec git. De préférence il y a pas mal de temps.

Clonez ce dépot dans le dossier de votre projet.
```bash
    git clone https://github.com/tykayn/gitall.git
 ```
vous obtiendrez un dossier nommé __gitall__.
dedans, le fichier index.php, une fois éxécuté va s'appuyer sur un log git et générer une feuille de route de votre projet dans plusieurs formats.
Actuellement sont supportés le HTML et le csv.

le HTML montre:
    * le nombre de jours de weekend où vous avez commité
    * le nombre de jours entre le premier et le dernier commit
    * un graphique de fréquence de commit (avec canvas.js)
    * une répartition journalière de vos commits.

le CSV totalise moins d'infos et est exportable dans n'importe quel tableur.

## TODO
    ### rendus:
    * ajouts et suppressions par commit
    * volume de code réalisé
    * graphique des heures où l'on commit le plus
    * coloration des commits effectués en dehors d'heures de bureau
    ### infos d'efficacité
    * savoir quels sont les fichiers les plus commités
    * savoir quels sont les fichiers présentant le plus de difficultés selon si on retouche souvent les mêmes lignes.
