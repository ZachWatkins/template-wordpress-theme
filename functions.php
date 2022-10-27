<?php
/**
 * Template Genesis Theme functions and definitions.
 *
 * @package template-genesis-theme
 * @author  Zachary K. Watkins <zwatkins.it@gmail.com>
 * @license GPL-2.0+
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 */

require_once __DIR__ . '/vendor/autoload.php';

define( 'THEME_SLUG', 'template-genesis-theme' );
define( 'THEME_DIRPATH', get_stylesheet_directory() );
define( 'THEME_DIRURL', get_stylesheet_directory_uri() );

add_action( 'wp_enqueue_scripts', 'genesis_parent_theme_enqueue_styles' );

/**
 * Enqueue styles for the theme.
 *
 * @return void
 */
function genesis_parent_theme_enqueue_styles(): void {
    wp_enqueue_style(
        'genesis-style',
        get_template_directory_uri() . '/style.css',
        false,
        filemtime( get_template_directory() . '/style.css' )
    );
    wp_enqueue_style(
        'template-genesis-theme-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'genesis-style' ),
        filemtime( get_stylesheet_directory_uri() . '/style.css' )
    );
}
