<?php
/**
 * Created by Romain ARDIET & Franck GORIN
 * Date: 21/03/13
 * Time: 14:11
 */

/**
 * Class Data qui gère les données des posts (votes, noms, etc)
 */

//require_once ($_SERVER["DOCUMENT_ROOT"] . '/projetWordpress/wp-blog-header.php');


class Data
{

    /**
     * Constructeur
     */
    public function __construct()
    {

    }

    /**
     * Fonction qui récupère tous les posts
     *
     * @param null
     * @return array de posts (objets)
     */
    public function getAllPosts()
    {
        $args = array(
            'post_type'       => 'post',
            'post_status'     => 'publish',
            'suppress_filters' => true
        );

        $_aPosts = get_posts( $args ); // récupère un objet qui contient tous les posts

        return $_aPosts;
    }

    /**
     * Fonction qui récupère la valeur du champ personnalisé 'votes' du post
     *
     * @param $postID
     * @return int nombre de posts
     */
    public function getVotesByPostId($_iPostID)
    {
        $_aVote = get_post_meta($_iPostID, "votes", true);

        return $_aVote;
    }


    /**
    * Fonction qui ajoute un vote à un post spécifique (incrémente le nombre de votes)
    *
    * @param $postID
    * @return void
    */
    public function addVotes($_iPostID){  
        $_iVotesNumber = get_post_meta($_iPostID, 'votes', true);   
        $_iVotesNumber++;
        update_post_meta($_iPostID, 'votes', $_iVotesNumber);
    }


    public function createDataForJson(){
        $_oData = new Data();
        $_oAllPosts = $_oData->getAllPosts();

        $_aJson;
        foreach($_oAllPosts as $_aPost)
        {
            $_iVote = $_oData->getVotesByPostId($_aPost->ID);

            if(isset($_iVote)) {
                $_iVote = $_iVote;
            } else {
                $_iVote = 0;
            }
            // Create a PHP array and echo it as JSON
            $_aJson['titles'][] = $_aPost->post_title;
            $_aJson['votes'][] = (int)$_iVote;
        }

        return json_encode($_aJson);
    }


    public function createFileJson($_aJson){

        $filename = 'dataJson.json';
        
        if(!$fp = fopen($filename, 'w+')){
            echo "Echec de l'ouverture du fichier";
            exit;
        }else{
            fwrite($fp, $_aJson);
            fclose($fp);
        }
    }

}