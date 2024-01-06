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
        if($_SESSION['erreurAjoutQuestion'] == 'true'){
            $messageLog = 'Impossible d\'effectuer la requête, tous les champs ne sont pas remplis';
            $message = 'Impossible d\'effectuer la requête, tous les champs ne sont pas remplis';
        }else{
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

}
