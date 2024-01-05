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
        $reponse = array(
            'message' => 'The add question button has been clicked',
            'status'  => true,
        );
        echo json_encode( $reponse );
        exit;
    }

}
