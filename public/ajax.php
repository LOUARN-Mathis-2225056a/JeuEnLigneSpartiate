<?php
// ajax.php
require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\TableauDeBord\TableauDeBord;
use app\controllers\TableauDesScores\TableauDesScores as tableauDesScoresController;
use app\models\BaseDeDonnee;
use app\models\EnvoyerEmails;

header( 'Content-Type: application/json' );

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) { //si c'est une méthode POST
    if ( isset( $_POST['changerCodeJeu'] ) ) { //une variable qu'on définie comme on veut pour executer la bonne partie de code
        //on execute le code qu'on veut executer
        $nomBouton = $_POST['changerCodeJeu'];
        (new TableauDeBord())->creerSalle();
        BaseDeDonnee::getCodeJeuActuel();

        //écriture de la réponse en JSON (syntaxe a respecter).
        $reponse = array(
            'message' => 'Le bouton ' . $nomBouton . ' a été cliqué', //message qu'on veut faire passer (mis dans la console du navigateur)
            'value' => $_SESSION['codeJeu'], //un valeur qu'on return
            'status'  => true, //aucune idée de ce que c'est mais c'est là
        );
        echo json_encode( $reponse ); //très important sinon on renvoi pas la réponse au client :3
        exit;
    }
    if ( isset( $_POST['ajouterQuestion'] ) ) {
        TableauDeBord::ajoutQuestion($_POST);
        if($_SESSION['erreurAjoutQuestion'] == '1'){
            $messageLog = 'Impossible d\'effectuer la requête, tous les champs ne sont pas remplis';
            $message = 'Impossible d\'effectuer la requête, tous les champs ne sont pas remplis';
        }elseif ($_SESSION['erreurAjoutQuestion'] == '2'){
            $messageLog = 'Il ne peut pas y avoir plus de 500 caractères dans un champ';
            $message = 'Il ne peut pas y avoir plus de 500 caractères dans un champ';
        }
        else{
            $messageLog = 'Requête correctement effectuée';
            $message = 'Question ajoutée à la base de donnée';
        }
        $reponse = array(
            'message' => $messageLog,
            'value' => $message,
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }
    if (isset($_POST['supprimerQuestion'])){

        TableauDeBord::supprimerQuestion($_POST);

        $id = $_POST['supprimerQuestion'];

        $reponse = array(
            'message' => 'Le bouton d\'id : ' . $id . ' a été cliqué',
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }

    if (isset($_POST['modifierQuestion'])){

        TableauDeBord::modifierQuestion($_POST);

        if($_SESSION['erreurModificationQuestion'] == '1'){
            $messageLog = 'Impossible d\'effectuer la requête veuillez remplir au moins 1 champs';
            $message = 'Impossible d\'effectuer la requête veuillez remplir au moins 1 champs';
        }elseif ($_SESSION['erreurModificationQuestion'] == '2'){
            $messageLog = 'impossible de modifier l\'attribut selectionné';
            $message = 'impossible de modifier l\'attribut selectionné';
        }
        elseif ($_SESSION['erreurModificationQuestion'] == '3'){
            $messageLog = 'Veuillez remplir l\'identifiant de la question';
            $message = 'Veuillez remplir l\'identifiant de la question';
        }
        elseif ($_SESSION['erreurModificationQuestion'] == '4'){
            $messageLog = 'Veuillez entrer un ID avec un valeur numérique';
            $message = 'Veuillez entrer un ID avec un valeur numérique';
        }
        elseif ($_SESSION['erreurModificationQuestion'] == '5'){
            $messageLog = 'Il ne peut pas y avoir plus de 500 caractères dans un champ';
            $message = 'Il ne peut pas y avoir plus de 500 caractères dans un champ';
        }
        else{
            $messageLog = 'Requête correctement effectuée';
            $message = 'Question correctement modifiée';
        }
        $reponse = array(
            'message' => $messageLog,
            'value' => $message,
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }
    if (isset($_POST['tailleTableauDesScores'])){

        $tableauDeJoueur = tableauDesScoresController::getTableauDesScores(intval($_POST['tailleTableauDesScores']));
        $tableauARendre = tableauDesScoresController::desObectifierLeTableau($tableauDeJoueur);

        $reponse = array(
            'message' => 'Demande traitée, réponse envoyées',
            'value' => $tableauARendre,
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }

    if (isset($_POST['obtenirQuestion'])){
        $touteLesQuestions = BaseDeDonnee::getTouteLesQuestions();

        $reponse = array(
            'message' => 'envoi de toutes les questions',
            'value' => $touteLesQuestions,
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }

    if (isset($_POST['lancerJeu'])){
        TableauDeBord::lancerJeu();

        $reponse = array(
            'message' => 'Les scores sont maintenant pris en compte',
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }

    if (isset($_POST['arreterJeu'])){
        TableauDeBord::arreterJeu();
        EnvoyerEmails::envoyerEmails();

        $reponse = array(
            'message' => 'Les scores ne seront plus mis a jour, les mails ont été envoyés',
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }

    if (isset($_POST['updateScore'])){



        BaseDeDonnee::updateScore($_POST['updateScore']);

        $reponse = array(
            'message' => 'Mise à jour du score',
            'value' => $_SESSION['joueurPseudo'],
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;

    }

}

