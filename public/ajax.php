<?php
// ajax.php
require_once __DIR__ . '/../vendor/autoload.php';
use config\BaseDeDonnee;
use app\controllers\TableauDeBord;
header( 'Content-Type: application/json' );

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if ( isset( $_POST['createSomthing'] ) ) {
        // Here you parse the button value and return the result in JSON format
        $button_value = $_POST['createSomthing'];

        (new TableauDeBord())->creerSalle();
        BaseDeDonnee::getCodeJeuActuel();

        $response = array(
            'message' => 'The ' . $button_value . ' button has been clicked!',
            'value' => $_SESSION['codeJeu'],
            'status'  => true,
        );
        echo json_encode( $response );
        exit;
    }
}
