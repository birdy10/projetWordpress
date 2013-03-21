<?php
/**
 * Created by Romain ARDIET & Franck GORIN
 * Date: 21/03/13
 * Time: 14:11
 */

/**
 * Class Data qui gère les données des posts (votes, noms, etc)
 */
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

}