<?php

namespace app\views\regles;

use app\models\ModelePage;

class ReglesGenerales
{
    public function show(): void {
        ob_start();
        ?>

        <nav>
            <a href="#ancreHockeySurGlace">Hockey sur Glace</a>
            <a href="#ancrePatinoire">Patinoire</a>
            <a href="#ancreTempsDeJeu">Temps de Jeu</a>
            <a href="#ancreEquipes">Les equipes</a>
            <a href="#ancreSystemePoints">Systeme de points</a>
        </nav>

        <button type="button" aria-label="toggle curtain navigation" class="nav-toggler">
            <span class="line l1"></span>
            <span class="line l2"></span>
            <span class="line l3"></span>
        </button>

        <div class="pageContent">
            <a id="ancreHockeySurGlace"></a>
            <div class="contentBloc">
                <label class="contentTitle">
                    le hockey sur \glace
                </label>
                <label class="contentText">
                    LE HOCKEY SUR GLACE EST UN SPORT COLLECTIF RAPIDE QUI SE JOUE SUR LA <label class="importantWord">GLACE</label> DANS UNE <label class="importantWord">PATINOIRE</label>
                    <br> <br> <br>
                    CHAQUE <label class="importantWord">joueur</label> PORTE DES <label class="importantWord">patins</label> ET A UNE <label class="importantWord">crosse</label>
                    <br> <br> <br>
                    le but est de mettre le <label class="importantWord">palet</label> dans les <label class="importantWord">cages</label> adverses
                    en le frappant avec la crosse
                    <br> <br> <br>
                    l'Équipe gagnante est celle qui a marqué le plus de <label class="importantWord">buts</label> a la fin du <label class="importantWord">match</label>
                </label>
            </div>
            <a id="ancrePatinoire"></a>
            <div class="contentBloc">
                <label class="contentTitle">
                    la patinoire
                </label>
                <label class="contentText">
                    Le hockey sur glace se joue dans une <label class="importantWord">patinoire</label>
                    <br> <br> <br>
                    La surface de jeu mesure <label class="importantWord">60 x 30 mètres</label>
                    <br> <br> <br>
                    elle est entourée par une <label class="importantWord">protection de 347 cm de haut</label> afin de protéger les spectateurs du palet
                    <br> <br> <br>
                    La glace est marquée par <label class="importantWord">3 zones</label> marquées par des cercles de <label class="importantWord">mise-au-jeu</label> où le jeu peut reprendre après un arrêt de jeu
                    <br> <br> <br>
                    <label class="importantWord">2 cages</label> sont présentes : une à chaque extrémité et sont placées au milieu de la ligne
                    <br> <br> <br>
                    Devant chaque but se trouve une <label class="importantWord">zone</label> où le gardien peut saisir le palet avec ses gants
                    <br> <br> <br>
                    Le <label class="importantWord">gardien de but</label> se tient devant la cage et il <u>ne peut pas être bousculé</u>
                </label>
            </div>
            <a id="ancreTempsDeJeu"></a>
            <div class="contentBloc">
                <label class="contentTitle">
                    le temps de jeu
                </label>
                <label class="contentText">
                    Un match de hockey sur glace est composé de <label class="importantWord">3 périodes de 20 minutes </label> entre lesquelles ont lieu des <label class="importantWord">pauses de 15 minutes</label>
                    <br> <br> <br>
                    les équipes <u>changent de côté</u> entre chaque période
                    <br> <br> <br>
                    Lors d'un match, chaque équipe a droit à un <label class="importantWord">temps mort unique de 30 secondes</label> pendant lequel le jeu est arrêté
                    <br> <br> <br>
                    Si le <label class="importantWord">palet est cassé</label>, le jeu doit s'arrêter <label class="importantWord">immédiatement</label> mais <u>ce n'est pas le cas pour les crosses cassés</u>
                    <br> <br> <br>
                    Le <label class="importantWord">palet doit toujours être en mouvement</label> et le jeu doit être arrêté si un joueur refuse d'essayer de le jouer en avant ou s’il l’immobilise
                    <br> <br> <br>
                    En cas d'<label class="importantWord">égalité</label> après 3 périodes, il y a <label class="importantWord">prolongation</label> : <label class="importantWord">chaque équipe doit retirer un joueur</label> et la règle du <label class="importantWord">but en or</label> rentre en jeu : le premier but marqué décide du vainqueur du match
                    <br> <br> <br>
                    En cas de <label class="importantWord">match nul après prolongation</label>, le match est décidé par une séance de <label class="importantWord">tirs au but</label> (3 tirs par équipe)
                    <br> <br> <br>
                    Le <label class="importantWord">vainqueur</label> d'un match reçoit normalement <label class="importantWord">3 points</label>, mais <u>si le match est décidé en prolongation</u>, <label class="importantWord">2 points</label> sont attribués à l'équipe gagnante et l'équipe perdante obtient <label class="importantWord">1 point</label>
                    <br> <br> <br>
                    Un match est jugé par <label class="importantWord">2 arbitres principaux</label> et <label class="importantWord">2 arbitres de ligne</label>
                </label>
            </div>
            <a id="ancreEquipes"></a>
            <div class="contentBloc">
                <label class="contentTitle">
                    les equipes
                </label>
                <label class="contentText">
                    les 2 équipes sont composées de <label class="importantWord">5 joueurs de champ</label> et d'<label class="importantWord">un gardien de but</label>
                    <br> <br> <br>
                    Les joueurs de champ ont une <label class="importantWord">crosse</label>, un <label class="importantWord">casque</label> (avec une grille / visière pour protéger le visage des crosses / du palet), des <label class="importantWord">gants</label>, des <label class="importantWord">patins</label> et d'<label class="importantWord">autres équipements de protection</label> portés sous l'<label class="importantWord">uniforme de l'équipe</label>
                    <br> <br> <br>
                    Le gardien de but est équipé à peu près de la même façon, mais il porte également une <label class="importantWord">épaulière</label>, de grands <label class="importantWord">protège-tibias</label> qui, en plus de le protéger, servent à empêcher le palet d'entrer dans les cages
                </label>
            </div>
            <a id="ancreSystemePoints"></a>
            <div class="contentBloc lastContentBloc">
                <label class="contentTitle">
                    le systeme de points
                </label>
                <label class="contentText">
                    Lorsqu'un but est marqué, le <label class="importantWord">buteur</label> reçoit un point dans le <label class="importantWord">rapport de match</label>, et jusqu'à <label class="importantWord">2 coéquipiers assistants</label> peuvent recevoir 1 point chacun
                    <br> <br> <br>
                    En plus du score, les statistiques <label class="importantWord">plus/moins</label> sont utilisées en hockey sur glace pour savoir si un joueur
                    est sur la glace dans une <label class="importantWord">chaîne productive</label> ou non, c'est-à-dire un score positif ou négatif
                    <br> <br> <br>
                    Les <label class="importantWord">points positifs</label> sont marqués lorsque <label class="importantWord">le joueur est dans la chaîne</label>,
                    tandis que les <label class="importantWord">points négatifs</label> sont marqués lorsque <label class="importantWord">l'adversaire marque</label>
                    pendant que le joueur est sur la glace
                    <br> <br> <br>
                    En outre, des statistiques sont généralement conservées sur tout : le <label class="importantWord">pourcentage d'arrêt du gardien de but</label>, les <label class="importantWord">buts en infériorité numérique</label> et les <label class="importantWord">mises-en-jeu gagnées</label>
                </label>
            </div>
        </div>
        <script src="/assets/javaScript/Regles.js"></script>
        <?php (new ModelePage('Règles du Hockey sur Glace', ob_get_clean(), 'regles'))->show();
    }
}