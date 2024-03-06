<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\TableauDeBord as tableauDeBordView;
use config\BaseDeDonnee as BDD;

require_once __DIR__ . '/../../../vendor/autoload.php';
class TableauDeBord
{
    public function execute(): void {

        unset($_SESSION['creerSalleReponse']);

        ( new tableauDeBordView() )->show();
    }

    /**
     * <p>génère une chaîne de caractère aléatoire permettant de créer un code de jeu</p>
     * @param int $longueur
     * @return string
     * @throws \Random\RandomException
     */
    public static function generateurNomAleatoire(int $longueur):string
    {
        $alphabet = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nom = '';
        for ($i = 0; $i < $longueur; $i++) {
            $nom = $nom . $alphabet[random_int(0,strlen($alphabet))-1];
        }
        return $nom;
    }

    /**
     * <p>vérifie la taille d'une string</p>
     * @param $text
     * @return bool
     */
    public static function strDeBonneTaille($text):bool
    {
        return strlen($text)<=500;
    }

    /**
     * <p>éxécute les commandes pour réinitialiser la BDD et met a jour le code jeu avec un nouveau</p>
     * @return void
     * @throws \Random\RandomException
     */
    public function creerSalle():void
    {
        BDD::resetScore();
        BDD::miseAJourDuCodeJeu(self::generateurNomAleatoire(4));
    }

    /**
     * <p>Cette fonction fait toute les vérifications nécessaire pour savoir si un question est conforme (taille par exemple) et fait la requête pour l'inscrire dans la BDD</p>
     * @param $donneePOST
     * @return void
     */
    public static function ajoutQuestion($donneePOST):void
    {
        if( $donneePOST['question'] != '' and
            $donneePOST['vrai'] != '' and
            $donneePOST['faux'] != '' and
            $donneePOST['faux2'] != ''){
            if (self::strDeBonneTaille($donneePOST['question']) and
                self::strDeBonneTaille($donneePOST['vrai']) and
                self::strDeBonneTaille($donneePOST['faux']) and
                self::strDeBonneTaille($donneePOST['faux2'])){
                BDD::ajouterQuestion(
                    htmlspecialchars($donneePOST['question']),
                    htmlspecialchars($donneePOST['vrai']),
                    htmlspecialchars($donneePOST['faux']),
                    htmlspecialchars($donneePOST['faux2']));
            }else{
                error_log('Il ne faut pas dépasser les 500 caractères');
                $_SESSION['erreurAjoutQuestion'] = '2';
            }

        }else{
            error_log('Il faut remplir tous les champs');
            $_SESSION['erreurAjoutQuestion'] = '1';
        }
    }

    /**
     * <p>permet d'obtenir toute les question présente dans la BDD</p>
     * @return array|null
     */
    public static function getTouteLesQuestions():?array
    {
        return BDD::getTouteLesQuestions();
    }

    /**
     * <p>supprime une question selon l'ID donné</p>
     * @param $donneePost
     * @return void
     */
    public static function supprimerQuestion($donneePost):void
    {
        BDD::supprimerQuestion(intval($donneePost['supprimerQuestion']));
    }

    /**
     * <p>cette fonction modifie une question, aussi, si rien n'est donnée dans un champ, le champ ne sera pas modifier</p>
     * @param $donneePost
     * @return void
     */
    public static function modifierQuestion($donneePost):void
    {
        if(is_numeric($donneePost['id'])){
            $id = $donneePost['id'];
            if( $donneePost['question'] == '' and
                $donneePost['vrai'] == '' and
                $donneePost['faux'] == '' and
                $donneePost['faux2'] == ''){
                $_SESSION['erreurModificationQuestion'] = '1';
            }else{
                if( self::strDeBonneTaille($donneePost['question']) and
                    self::strDeBonneTaille($donneePost['vrai']) and
                    self::strDeBonneTaille($donneePost['faux']) and
                    self::strDeBonneTaille($donneePost['faux2'])){
                    if($donneePost['question'] != ''){
                        BDD::modifierQuestion(1,$id,$donneePost['question']);
                    }
                    if($donneePost['vrai'] != ''){
                        BDD::modifierQuestion(2,$id,$donneePost['vrai']);
                    }
                    if($donneePost['faux'] != ''){
                        BDD::modifierQuestion(3,$id,$donneePost['faux']);
                    }
                    if($donneePost['faux2'] != ''){
                        BDD::modifierQuestion(4,$id,$donneePost['faux2']);
                    }
                }else{
                    $_SESSION['erreurModificationQuestion'] = '5';
                }
            }

        }else{
            if($donneePost['id'] == ''){
                $_SESSION['erreurModificationQuestion'] = '3';
            }else{
                $_SESSION['erreurModificationQuestion'] = '4';
            }
        }

    }

    /**
     * <p>renvois vrai si le jeu est lancé, fau sinon</p>
     * @return bool
     */
    public static function jeuLance():bool
    {
        $_SESSION['accepterScore'] = BDD::getAccepterScore();
        if ($_SESSION['accepterScore'] == 1){
            return true;
        }
        return false;
    }

    /**
     * <p>permet l'acceptation des scores pour "lancer le jeu"</p>
     * @return void
     */
    public static function lancerJeu():void
    {
        BDD::lancerJeu();
    }

    /**
     * <p>"arrête le jeu" en refusant l'augmentation des scores des joueurs</p>
     * @return void
     */
    public static function arreterJeu():void
    {
        BDD::pauseJeu();
    }

}

