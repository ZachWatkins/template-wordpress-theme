<?php
/**
 * Genesis admin customizations.
 * @author Zachary K. Watkins <zwatkins.it@gmail.com>
 * @since      0.1.0
 * @package    template-genesis-theme
 * @subpackage template-genesis-theme/genesis
 */

namespace Theme\Genesis;

/**
 * Sets up the Admin portions of the Genesis Framework to suit our needs.
 */
class Admin
{
    public function __construct()
    {
            // Declare default Genesis settings for this theme.
            add_action("after_switch_theme", [
                $this,
                "genesis_default_theme_settings",
            ]);

            // Add the responsive viewport.
            $this->add_responsive_viewport();

            // Add the responsive viewport.
            $this->add_accessibility();

            // Keep Genesis from loading any stylesheets.
            $this->remove_stylesheet();

            // Force IE out of compatibility mode.
            add_action("genesis_meta", [$this, "fix_compatibility_mode"]);

            // Specify the favicon location.
            add_filter("genesis_pre_load_favicon", [$this, "add_favicon"]);

            // Create the structural wraps.
            $this->add_structural_wraps();

            // Clean up the comment area.
            add_filter("comment_form_defaults", [$this, "cleanup_comment_text"]);

            // Remove profile fields.
            add_action("admin_init", [$this, "remove_profile_fields"]);

            // Remove unneeded layouts.
            $this->remove_genesis_layouts();

            // Remove unneeded sidebars.
            $this->remove_genesis_sidebars();

            // Add widget areas.
            $this->add_widget_areas();

            // Remove site description.
            remove_action(
                "genesis_site_description",
                "genesis_seo_site_description",
            );

            // Move Genesis in-post SEO box to a lower position.
            remove_action("admin_menu", "genesis_add_inpost_seo_box");
            add_action("admin_menu", [$this, "move_inpost_seo_box"]);

            // Move Genesis in-post layout box to a lower position.
            remove_action("admin_menu", "genesis_add_inpost_layout_box");
            add_action("admin_menu", [$this, "move_inpost_layout_box"]);

            // Remove some Genesis settings metaboxes.
            add_action("genesis_theme_settings_metaboxes", [
                $this,
                "remove_genesis_metaboxes",
            ]);

            // Remove unneeded default header styles.
            remove_action("wp_head", "genesis_custom_header_style");

            // Add Read More excerpt link.
            add_filter("excerpt_more", [$this, "auto_excerpt_more"], 11);
        }

        /**
         * Add default theme setting values.
         *
         * @since 0.4.10
         * @return void
         */
        public function genesis_default_theme_settings()
        {
            if (!function_exists("genesis_update_settings")) {
                return;
            }

            $settings = [
                "site_layout" => "content-sidebar",
                "content_archive" => "excerpts",
                "content_archive_thumbnail" => 1,
                "image_size" => "archive",
                "image_alignment" => "",
                "posts_nav" => "numeric",
            ];

            genesis_update_settings($settings);
        }

        /**
         * Adds the responsive viewport meta tag
         *
         * @since 0.1.0
         * @return void
         */
        private function add_responsive_viewport()
        {
            add_theme_support("genesis-responsive-viewport");
        }

        /**
         * Adds the responsive viewport meta tag
         *
         * @since 0.1.0
         * @return void
         */
        private function add_accessibility()
        {
            add_theme_support("genesis-accessibility", [
                "search-form",
                "skip-links",
            ]);
        }

        /**
         * Removes any stylesheet Genesis may try to load
         *
         * @since 0.1.0
         * @return void
         */
        private function remove_stylesheet()
        {
            remove_action("genesis_meta", "genesis_load_stylesheet");
        }

        /**
         * Forces IE out of compatibility mode
         *
         * @since 0.1.0
         * @return void
         */
        public function fix_compatibility_mode()
        {
            echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">';
        }

        /**
         * Changes the Genesis default favicon location
         *
         * @since 0.1.0
         * @param string $favicon_url The default favicon location.
         * @return string
         */
        public function add_favicon($favicon_url)
        {
            return AF_THEME_DIRURL . "/images/favicon.ico";
        }

        /**
         * Adds structural wraps to the specified elements
         *
         * @since 0.1.0
         * @return void
         */
        private function add_structural_wraps()
        {
            add_theme_support("genesis-structural-wraps", [
                "header",
                "menu-primary",
                "site-inner",
                "footer",
            ]);
        }

        /**
         * Remove unneeded user profile fields
         *
         * @since 0.1.0
         * @return void
         */
        public function remove_profile_fields()
        {
            remove_action("show_user_profile", "genesis_user_options_fields");
            remove_action("edit_user_profile", "genesis_user_options_fields");
            remove_action("show_user_profile", "genesis_user_archive_fields");
            remove_action("edit_user_profile", "genesis_user_archive_fields");
            remove_action("show_user_profile", "genesis_user_seo_fields");
            remove_action("edit_user_profile", "genesis_user_seo_fields");
            remove_action("show_user_profile", "genesis_user_layout_fields");
            remove_action("edit_user_profile", "genesis_user_layout_fields");
        }

        /**
         * Removes any layouts that we don't need
         *
         * @since 0.1.0
         * @return void
         */
        private function remove_genesis_layouts()
        {
            genesis_unregister_layout("sidebar-content");
            genesis_unregister_layout("content-sidebar-sidebar");
            genesis_unregister_layout("sidebar-sidebar-content");
            genesis_unregister_layout("sidebar-content-sidebar");
        }

        /**
         * Removes any default sidebars that we don't need
         *
         * @since 0.1.0
         * @return void
         */
        private function remove_genesis_sidebars()
        {
            unregister_sidebar("sidebar-alt");
            unregister_sidebar("header-right");
        }

        /**
         * Adds sidebars
         *
         * @since 1.0.6
         * @return void
         */
        private function add_widget_areas()
        {
            genesis_register_sidebar([
                "name" => __("Primary Navigation Search", "template-genesis-theme"),
                "id" => "af4-header-right",
                "description" => __(
                    "This is the widget area for the search feature on the right side of the navigation menu.",
                    "template-genesis-theme",
                ),
            ]);
        }

        /**
         * Cleans up the default comments text
         *
         * @since 0.1.0
         * @param array $args The default arguments.
         * @return array The new arguments
         */
        public function cleanup_comment_text($args)
        {
            $args["comment_notes_before"] = "";
            $args["comment_notes_after"] = "";

            return $args;
        }

        /**
         * Moves the Genesis in-post SEO box to a lower position
         *
         * @since 0.1.0
         * @author Bill Erickson
         * @return void
         */
        public function move_inpost_seo_box()
        {
            if (genesis_detect_seo_plugins()) {
                return;
            }

            foreach ((array) get_post_types(["public" => true]) as $type) {
                if (post_type_supports($type, "genesis-seo")) {
                    add_meta_box(
                        "genesis_inpost_seo_box",
                        __("Theme SEO Settings", "template-genesis-theme"),
                        "genesis_inpost_seo_box",
                        $type,
                        "normal",
                        "default",
                    );
                }
            }
        }

        /**
         * Moves the Genesis in-post layout box to a lower postion
         *
         * @since 0.1.0
         * @return void
         */
        public function move_inpost_layout_box()
        {
            if (!current_theme_supports("genesis-inpost-layouts")) {
                return;
            }

            foreach ((array) get_post_types(["public" => true]) as $type) {
                if (post_type_supports($type, "genesis-layouts")) {
                    add_meta_box(
                        "genesis_inpost_layout_box",
                        __("Layout Settings", "genesis"),
                        "genesis_inpost_layout_box",
                        $type,
                        "normal",
                        "default",
                    );
                }
            }
        }

        /**
         * Adds attributes for sticky navigation and add wrap for header layout requirements
         *
         * @since 0.1.0
         * @param string $_genesis_theme_settings_pagehook The hook name for the genesis theme setting.
         * @return void
         */
        public function remove_genesis_metaboxes($_genesis_theme_settings_pagehook)
        {
            if (!is_super_admin()) {
                remove_meta_box(
                    "genesis-theme-settings-version",
                    $_genesis_theme_settings_pagehook,
                    "main",
                );
            }

            remove_meta_box(
                "genesis-theme-settings-nav",
                $_genesis_theme_settings_pagehook,
                "main",
            );
            remove_meta_box(
                "genesis-theme-settings-scripts",
                $_genesis_theme_settings_pagehook,
                "main",
            );
        }

        /**
         * Adds the Read More link to post excerpts
         *
         * @since 0.1.0
         * @param string $more The current "more" text.
         * @return string
         */
        public function auto_excerpt_more($more)
        {
            return '... <span class="read-more"><a href="' .
                get_permalink() .
                '">' .
                __("Read More &rarr;", "template-genesis-theme") .
                "</a></span>";
        }

        /**
         * Filter only post_date for post meta.
         *
         * @since 0.5.14
         * @param string $info Current post meta with shortcodes.
         * @return string
         */
        public function date_only($info)
        {
            return "[post_date] [post_edit]";
        }
    }

}
