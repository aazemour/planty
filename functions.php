<?php

// Action qui permet de charger des scripts dans notre thème
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    // Chargement du style.css du thème parent Twenty Twenty
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    // Chargement du css/theme.css pour nos personnalisations
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
}

require 'plugin-ajaxy-button-cf7.php';

function ajouter_lien_admin_menu($items, $args)
{
    // Vérifier si le menu est le menu principal et que l'utilisateur est connecté
    if ($args->theme_location == 'primary' && is_user_logged_in()) {
        // Construire le lien d'administration avec la classe "admin-menu-link"
        $lien_admin = '<li><a href="' . admin_url() . '" class="admin-menu-link">Admin</a></li>';

        // Trouver le premier </li>
        $position = strpos($items, '</li>');

        if ($position !== false) {
            // Insérer le lien d'administration après le premier </li>
            $items = substr_replace($items, $lien_admin, $position + 5, 0);
        }
    }

    return $items;
}

// Filtrer les éléments du menu
add_filter('wp_nav_menu_items', 'ajouter_lien_admin_menu', 10, 2);