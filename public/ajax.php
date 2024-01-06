<?php
// ajax.php
require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\TableauDeBord\TableauDeBord;
use config\BaseDeDonnee;

header( 'Content-Type: application/json' );

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( isset( $_POST['changerCodeJeu'] ) ) {
        // Here you parse the button value and return the result in JSON format
        $nomBouton = $_POST['changerCodeJeu'];

        (new TableauDeBord())->creerSalle();
        BaseDeDonnee::getCodeJeuActuel();

        $reponse = array(
            'message' => 'Le bouton ' . $nomBouton . ' a été cliqué',
            'value' => $_SESSION['codeJeu'],
            'status'  => true,
        );
        echo json_encode( $reponse );
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

}
