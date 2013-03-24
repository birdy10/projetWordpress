<?php
/**
 * Created by the fat IDE JetBrains PhpStorm.
 * User: Franck GORIN
 * Date: 22/03/13 - 11:38
 */
include_once('Data.class.php');

class ManageVotes {

    /**
     * Constructeur
     */
    public function __construct(){
        // fonction de load js
        add_action( 'wp_print_scripts', array( $this, 'loadJS' ) );
    }

    public function addVote(){

    }

    public function loadJS(){
    }

    public function loadCSS(){

    }

    public function createHTMLToVote(){

        $_oData = new Data();
        $_aAllPosts = $_oData->getAllPosts();

        $_sHTML = "<div class='main'>
                        <ul id='og-grid' class='og-grid'>";

        foreach($_aAllPosts as $_oPost)
        {
            if($_oPost){
                $_aImg = wp_get_attachment_image_src( get_post_thumbnail_id( $_oPost->ID ));

                $_sHTML .= "<li>
                                <a href='".get_permalink($_oPost->ID)."' id='".$_oPost->ID."' data-largesrc='".$_aImg[0]."' data-title='".get_the_title($_oPost->ID)."' data-description='".get_post_field('post_content', $_oPost->ID)."'>
                                    ".get_the_post_thumbnail($_oPost->ID, 'thumbnail')."
                                </a>
                            </li>";
            }
        }

        $_sHTML .= "    </ul>
                    </div>";

        return $_sHTML;

    }

}