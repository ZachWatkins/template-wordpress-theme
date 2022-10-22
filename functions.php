<?php
/**
 * Template Genesis Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package template-genesis-theme
 */

require_once __DIR__.'/vendor/autoload.php';

define('THEME_SLUG', 'template-genesis-theme');
define('THEME_DIRPATH', get_stylesheet_directory());
define('THEME_DIRURL', get_stylesheet_directory_uri());

add_action('wp_enqueue_scripts', 'genesis_parent_theme_enqueue_styles');


/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function genesis_parent_theme_enqueue_styles(): void
{
    wp_enqueue_style(
        'genesis-style',
        get_template_directory_uri().'/style.css',
    );
    wp_enqueue_style(
        'template-genesis-theme-style',
        get_stylesheet_directory_uri().'/style.css',
        ['genesis-style'],
    );

}//end genesis_parent_theme_enqueue_styles()
