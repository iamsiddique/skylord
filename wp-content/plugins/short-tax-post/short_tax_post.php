<?php
/*
* Plugin Name: Reales WP STPT
* Description: Creates shortcodes, register custom taxonomies and post types
* Version: 1.0.3
* Author: Marius Nastase
* Author URI: http://mariusn.com
*/


add_action( 'plugins_loaded', 'reales_load_textdomain' );
function reales_load_textdomain() {
    load_plugin_textdomain( 'reales', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 *****************************************************************************
 * Shortcodes
 *****************************************************************************
 */

if( !function_exists('reales_register_buttons') ): 
    function reales_register_buttons($buttons) {
        array_push($buttons, "|", "services");
        array_push($buttons, "|", "recent_properties");
        array_push($buttons, "|", "featured_properties");
        array_push($buttons, "|", "featured_agents");
        array_push($buttons, "|", "testimonials");
        array_push($buttons, "|", "latest_posts");
        array_push($buttons, "|", "featured_posts");
        array_push($buttons, "|", "column");

        return $buttons;
    }
endif;

if( !function_exists('reales_add_plugins') ): 
    function reales_add_plugins($plugin_array) {
        $plugin_array['services'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['recent_properties'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['featured_properties'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['featured_agents'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['testimonials'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['latest_posts'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['featured_posts'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        $plugin_array['column'] = plugin_dir_url( __FILE__ ) . '/js/shortcodes.js';
        return $plugin_array;
    }
endif;

if( !function_exists('reales_register_plugin_buttons') ): 
    function reales_register_plugin_buttons() {
        if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if(get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', 'reales_add_plugins');
            add_filter('mce_buttons_3', 'reales_register_buttons');
        }
    }
endif;

if( !function_exists('reales_register_shortcodes') ): 
    function reales_register_shortcodes() {
        add_shortcode('services', 'reales_services_shortcode');
        add_shortcode('recent_properties', 'reales_recent_properties_shortcode');
        add_shortcode('featured_properties', 'reales_featured_properties_shortcode');
        add_shortcode('featured_agents', 'reales_featured_agents_shortcode');
        add_shortcode('testimonials', 'reales_testimonials_shortcode');
        add_shortcode('latest_posts', 'reales_latest_posts_shortcode');
        add_shortcode('featured_posts', 'reales_featured_posts_shortcode');
        add_shortcode('column', 'reales_column_shortcode');
    }
endif;

add_action('init', 'reales_register_plugin_buttons');
add_action('init', 'reales_register_shortcodes');

/**
 * Services shortcode
 */
if( !function_exists('reales_services_shortcode') ): 
    function reales_services_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'stitle' => 'Services Title',
            'show' => '4',
            's1icon' => 'icon-pointer',
            's1title' => '1st Service Title',
            's1text' => '1st Service Text',
            's1link' => '#',
            's2icon' => 'icon-users',
            's2title' => '2nd Service Title',
            's2text' => '2nd Service Text',
            's2link' => '#',
            's3icon' => 'icon-home',
            's3title' => '3rd Service Title',
            's3text' => '3rd Service Text',
            's3link' => '3rd Service Link',
            's4icon' => 'icon-cloud-upload',
            's4title' => '4th Service Title',
            's4text' => '4th Service Text',
            's4link' => '#'
        ), $attrs));

        $return_string = '<h2 class="osLight centered">' . esc_html($stitle) . '</h2>';
        $return_string .= '<div class="row pb40">';

        if(esc_html($show) == '2') {
            $return_string .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<span class="' . esc_attr($s1icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s1title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s1text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<span class="' . esc_attr($s2icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s2title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s2text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';
        } else if(esc_html($show) == '3') {
            $return_string .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<span class="' . esc_attr($s1icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s1title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s1text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<span class="' . esc_attr($s2icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s2title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s2text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s3link) . '">';
            $return_string .= '<span class="' . esc_attr($s3icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s3title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s3text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';
        } else {
            $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s1link) . '">';
            $return_string .= '<span class="' . esc_attr($s1icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s1title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s1text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s2link) . '">';
            $return_string .= '<span class="' . esc_attr($s2icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s2title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s2text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s3link) . '">';
            $return_string .= '<span class="' . esc_attr($s3icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s3title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s3text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';

            $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 s-menu-item">';
            $return_string .= '<a href="' . esc_url($s4link) . '">';
            $return_string .= '<span class="' . esc_attr($s4icon) . ' s-icon"></span>';
            $return_string .= '<div class="s-content">';
            $return_string .= '<h2 class="centered s-main osLight">' . esc_html($s4title) . '</h2>';
            $return_string .= '<h3 class="s-sub osLight">' . esc_html($s4text) . '</h3>';
            $return_string .= '</div>';
            $return_string .= '</a>';
            $return_string .= '</div>';
        }

        $return_string .= '</div>';

        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Recent properties shortcode
 */
if( !function_exists('reales_recent_properties_shortcode') ): 
    function reales_recent_properties_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Recently Listed Properties'
        ), $attrs));

        if(isset($attrs['show']) && is_numeric($attrs['show'])) {
            $show = $attrs['show'];
        } else {
            $show = '6';
        }

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'property',
            'order' => 'DESC',
            'post_status'      => 'publish');
        $posts = wp_get_recent_posts($args);

        $return_string = '<h2 class="centered osLight">' . esc_html($title) . '</h2>';
        $return_string .= '<div class="row pb40">';
        foreach($posts as $post) : 
            $gallery = get_post_meta($post["ID"], 'property_gallery', true);
            $images = explode("~~~", $gallery);
            $price = get_post_meta($post["ID"], 'property_price', true);
            $reales_general_settings = get_option('reales_general_settings');
            $currency = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
            $currency_pos = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
            $price_label = get_post_meta($post["ID"], 'property_price_label', true);
            setlocale(LC_MONETARY, 'en_US');
            $address = get_post_meta($post["ID"], 'property_address', true);
            $city = get_post_meta($post["ID"], 'property_city', true);
            $zip = get_post_meta($post["ID"], 'property_zip', true);
            $country = get_post_meta($post["ID"], 'property_country', true);
            $type =  wp_get_post_terms($post["ID"], 'property_type_category');

            if(intval($show) % 3 == 0) {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">';
            } else {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
            }
            $return_string .= '<a href="' . esc_url(get_permalink($post["ID"])) . '" class="propWidget-2">';
            $return_string .= '<div class="fig">';
            $return_string .= '<img src="' . esc_url($images[1]) . '" alt="' . esc_attr($post["post_title"]) . '" class="scale" data-scale="best-fill" data-align="center">';
            $return_string .= '<img src="' . esc_url($images[1]) . '" alt="' . esc_attr($post["post_title"]) . '" class="blur scale" data-scale="best-fill" data-align="center">';
            $return_string .= '<div class="opac"></div>';
            if($currency_pos == 'before') {
                $return_string .= '<div class="priceCap osLight"><span>' . esc_html($currency) . money_format('%!.0i', esc_html($price)) . esc_html($price_label) . '</span></div>';
            } else {
                $return_string .= '<div class="priceCap osLight"><span>' . money_format('%!.0i', esc_html($price)) . esc_html($currency) . esc_html($price_label) . '</span></div>';
            }
            if($type) {
                $return_string .= '<div class="figType">' . esc_html($type[0]->name) . '</div>';
            }
            $return_string .= '<h3 class="osLight">' . esc_html($post["post_title"]) . '</h3>';
            $return_string .= '<div class="address">';
            if($address != '') {
                $return_string .= esc_html($address) . ', ';
            }
            if($city != '') {
                $return_string .= esc_html($city) . ', ';
            }
            $return_string .= esc_html($country);
            $return_string .= '</div></div>';
            $return_string .= '</a>';
            $return_string .= '</div>';
        endforeach;
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Featured properties shortcode
 */
if( !function_exists('reales_featured_properties_shortcode') ): 
    function reales_featured_properties_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Featured Properties'
        ), $attrs));

        if(isset($attrs['show']) && is_numeric($attrs['show'])) {
            $show = $attrs['show'];
        } else {
            $show = '3';
        }

        $args = array(
            'numberposts'   => $show,
            'post_type'        => 'property',
            'order' => 'DESC',
            'meta_key'         => 'property_featured',
            'meta_value'       => '1',
            'post_status'      => 'publish');
        $posts = get_posts($args);

        $return_string = '<h2 class="centered osLight">' . esc_html($title) . '</h2>';
        $return_string .= '<div class="row pb40">';
        foreach($posts as $post) : setup_postdata($post);
            $gallery = get_post_meta($post->ID, 'property_gallery', true);
            $images = explode("~~~", $gallery);
            $price = get_post_meta($post->ID, 'property_price', true);
            $reales_general_settings = get_option('reales_general_settings');
            $currency = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
            $currency_pos = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
            $price_label = get_post_meta($post->ID, 'property_price_label', true);
            setlocale(LC_MONETARY, 'en_US');
            $address = get_post_meta($post->ID, 'property_address', true);
            $city = get_post_meta($post->ID, 'property_city', true);
            $zip = get_post_meta($post->ID, 'property_zip', true);
            $country = get_post_meta($post->ID, 'property_country', true);
            $type =  wp_get_post_terms($post->ID, 'property_type_category');

            if(intval($show) % 3 == 0) {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">';
            } else {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
            }
            $return_string .= '<a href="' . esc_url(get_permalink($post->ID)) . '" class="propWidget-2">';
            $return_string .= '<div class="fig">';
            $return_string .= '<img src="' . esc_url($images[1]) . '" alt="' . esc_attr($post->post_title) . '" class="scale" data-scale="best-fill" data-align="center">';
            $return_string .= '<img src="' . esc_url($images[1]) . '" alt="' . esc_attr($post->post_title) . '" class="blur scale" data-scale="best-fill" data-align="center">';

            $return_string .= '<div class="opac"></div>';
            if($currency_pos == 'before') {
                $return_string .= '<div class="priceCap osLight"><span>' . esc_html($currency) . money_format('%!.0i', esc_html($price)) . esc_html($price_label) . '</span></div>';
            } else {
                $return_string .= '<div class="priceCap osLight"><span>' . money_format('%!.0i', esc_html($price)) . esc_html($currency) . esc_html($price_label) . '</span></div>';
            }
            if($type) {
                $return_string .= '<div class="figType">' . esc_html($type[0]->name) . '</div>';

            }
            $return_string .= '<h3 class="osLight">' . esc_html($post->post_title) . '</h3>';
            $return_string .= '<div class="address">';
            if($address != '') {
                $return_string .= esc_html($address) . ', ';
            }
            if($city != '') {
                $return_string .= esc_html($city) . ', ';
            }
            $return_string .= esc_html($country);
            $return_string .= '</div></div>';
            $return_string .= '</a>';
            $return_string .= '</div>';
        endforeach;
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Featured agents shortcode
 */
if( !function_exists('reales_featured_agents_shortcode') ): 
    function reales_featured_agents_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Our Agents'
        ), $attrs));

        if(isset($attrs['show']) && is_numeric($attrs['show'])) {
            $show = $attrs['show'];
        } else {
            $show = '4';
        }

        $args = array(
                'posts_per_page'   => $show,
                'post_type'        => 'agent',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'meta_key'         => 'agent_featured',
                'meta_value'       => '1',
                'post_status'      => 'publish' );
        $posts = get_posts($args);

        $return_string = '<h2 class="centered osLight">' . esc_html($title) . '</h2>';
        $return_string .= '<div class="row pb40">';
        foreach($posts as $post) : setup_postdata($post);
            $avatar = get_post_meta($post->ID, 'agent_avatar', true);
            if($avatar != '') {
                $avatar_src = $avatar;
            } else {
                $avatar_src = get_template_directory_uri().'/images/avatar.png';
            }
            $email = get_post_meta($post->ID, 'agent_email', true);
            $facebook = get_post_meta($post->ID, 'agent_facebook', true);
            $twitter = get_post_meta($post->ID, 'agent_twitter', true);
            $google = get_post_meta($post->ID, 'agent_google', true);
            $linkedin = get_post_meta($post->ID, 'agent_linkedin', true);

            if(intval($show) % 3 == 0) {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">';
            } else {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
            }
            $return_string .= '<div class="agent">';
            $return_string .= '<a href="' . esc_url(get_permalink($post->ID)) . '" class="agent-avatar">';
            $return_string .= '<img src="' . esc_url($avatar_src) . '" alt="' . esc_attr($post->post_title) . '">';
            $return_string .= '<div class="ring"></div>';
            $return_string .= '</a>';
            $return_string .= '<div class="agent-name osLight">' . esc_html($post->post_title) . '</div>';
            $return_string .= '<div class="agent-contact">';
            $return_string .= '<a href="' . esc_url(get_permalink($post->ID)) . '" class="btn btn-sm btn-icon btn-round btn-o btn-green"><span class="fa fa-link"></span></a> ';
            if($facebook && $facebook != '') {
                $return_string .= '<a href="' . esc_url($facebook) . '" class="btn btn-sm btn-icon btn-round btn-o btn-facebook" target="_blank"><span class="fa fa-facebook"></span></a> ';
            }
            if($twitter && $twitter != '') {
                $return_string .= '<a href="' . esc_url($twitter) . '" class="btn btn-sm btn-icon btn-round btn-o btn-twitter" target="_blank"><span class="fa fa-twitter"></span></a> ';
            }
            if($google && $google != '') {
                $return_string .= '<a href="' . esc_url($google) . '" class="btn btn-sm btn-icon btn-round btn-o btn-google" target="_blank"><span class="fa fa-google-plus"></span></a> ';
            }
            if($linkedin && $linkedin != '') {
                $return_string .= '<a href="' . esc_url($linkedin) . '" class="btn btn-sm btn-icon btn-round btn-o btn-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>';
            }
            $return_string .= '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
        endforeach;
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Testimonials shortcode
 */
if( !function_exists('reales_testimonials_shortcode') ): 
    function reales_testimonials_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Testimonials'
        ), $attrs));

        $args = array(
                'posts_per_page'   => 4,
                'post_type'        => 'testimonials',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_status'      => 'publish' );
        $posts = get_posts($args);

        $return_string = '<h2 class="centered osLight">' . esc_html($title) . '</h2>';
        $return_string .= '<div class="row pb40">';
        $return_string .= '<div id="home-testimonials" class="carousel slide carousel-wb mb20" data-ride="carousel">';
        $return_string .= '<ol class="carousel-indicators">';
        for($i = 0; $i < count($posts); $i++) {
            $return_string .= '<li data-target="#home-testimonials" data-slide-to="' . esc_attr($i) . '"';
            if($i == 0) $return_string .= 'class="active"';
            $return_string .= ' ></li>';
        }
        $return_string .= '</ol>';
        $return_string .= '<div class="carousel-inner">';
        $counter = 0;
        foreach($posts as $post) : setup_postdata($post);
            $avatar = get_post_meta($post->ID, 'testimonials_avatar', true);
            if($avatar != '') {
                $avatar_src = $avatar;
            } else {
                $avatar_src = get_template_directory_uri().'/images/avatar.png';
            }
            $text = get_post_meta($post->ID, 'testimonials_text', true);

            $return_string .= '<div class="item';
            if($counter == 0) $return_string .= ' active';
            $return_string .= '">';
            $return_string .= '<img src="' . esc_url($avatar_src) . '" class="home-testim-avatar" alt="' . esc_attr($post->post_title) . '">';
            $return_string .= '<div class="home-testim">';
            $return_string .= '<div class="home-testim-text">' . esc_html($text) . '</div>';
            $return_string .= '<div class="home-testim-name">' . esc_html($post->post_title) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
            $counter++;
        endforeach;
        $return_string .= '</div>';
        $return_string .= '</div>';
        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Latest blog posts shortcode
 */
if( !function_exists('reales_latest_posts_shortcode') ): 
    function reales_latest_posts_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Recently Listed Properties'
        ), $attrs));

        if(isset($attrs['show']) && is_numeric($attrs['show'])) {
            $show = $attrs['show'];
        } else {
            $show = '4';
        }

        $args = array(
            'numberposts'   => $show,
            'post_type'     => 'post',
            'orderby'       => 'post_date',
            'order'         => 'DESC',
            'post_status'   => 'publish');
        $posts = wp_get_recent_posts($args, OBJECT);

        $return_string = '<h2 class="centered osLight">' . esc_html($title) . '</h2>';
        $return_string .= '<div class="row pb40">';

        foreach($posts as $post) : 
            if(intval($show) % 3 == 0) {
                $return_string .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">';
            } else {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
            }
            $return_string .= '<div class="article bg-w">';

            $post_link = get_permalink($post->ID);
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

            $return_string .= '<a href="' . esc_url($post_link) . '" class="image">';
            $return_string .= '<div class="img" style="background-image: url(' . esc_url($post_image[0]) . ')"></div>';
            $return_string .= '</a>';
            $return_string .= '<div class="article-category">';

            $categories = get_the_category($post->ID);
            $separator = ' ';
            $output = '';
            if($categories) {
                foreach($categories as $category) {
                    $output .= '<a class="text-green" href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'reales' ), $category->name ) ) . '">' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                }
                $return_string .= trim($output, $separator);
            }

            $return_string .= '</div>';
            $return_string .= '<h3><a href="' . esc_url($post_link) . '">' . esc_html($post->post_title) . '</a></h3>';

            $post_author = get_the_author_meta( 'display_name' , $post->post_author );
            $post_date = get_the_date('F j, Y',$post->ID);

            $return_string .= '<div class="footer">' . esc_html($post_author) . ', ' . esc_html($post_date) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
        endforeach;

        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Featured blog posts shortcode
 */
if( !function_exists('reales_featured_posts_shortcode') ): 
    function reales_featured_posts_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Featured Listed Properties'
        ), $attrs));

        if(isset($attrs['show']) && is_numeric($attrs['show'])) {
            $show = $attrs['show'];
        } else {
            $show = '4';
        }

        $args = array(
            'numberposts'   => $show,
            'post_type'     => 'post',
            'orderby'       => 'post_date',
            'meta_key'      => 'post_featured',
            'meta_value'    => '1',
            'order'         => 'DESC',
            'post_status'   => 'publish');
        $posts = wp_get_recent_posts($args, OBJECT);

        $return_string = '<h2 class="centered osLight">' . esc_html($title) . '</h2>';
        $return_string .= '<div class="row pb40">';

        foreach($posts as $post) : 
            if(intval($show) % 3 == 0) {
                $return_string .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">';
            } else {
                $return_string .= '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">';
            }
            $return_string .= '<div class="article bg-w">';

            $post_link = get_permalink($post->ID);
            $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

            $return_string .= '<a href="' . esc_url($post_link) . '" class="image">';
            $return_string .= '<div class="img" style="background-image: url(' . esc_url($post_image[0]) . ')"></div>';
            $return_string .= '</a>';
            $return_string .= '<div class="article-category">';

            $categories = get_the_category($post->ID);
            $separator = ' ';
            $output = '';
            if($categories) {
                foreach($categories as $category) {
                    $output .= '<a class="text-green" href="' . esc_url(get_category_link( $category->term_id )) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'reales' ), $category->name ) ) . '">' . esc_html($category->cat_name) . '</a>' . esc_html($separator);
                }
                $return_string .= trim($output, $separator);
            }

            $return_string .= '</div>';
            $return_string .= '<h3><a href="' . esc_url($post_link) . '">' . esc_html($post->post_title) . '</a></h3>';

            $post_author = get_the_author_meta( 'display_name' , $post->post_author );
            $post_date = get_the_date('F j, Y',$post->ID);

            $return_string .= '<div class="footer">' . esc_html($post_author) . ', ' . esc_html($post_date) . '</div>';
            $return_string .= '</div>';
            $return_string .= '</div>';
        endforeach;

        $return_string .= '</div>';

        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }
endif;

/**
 * Columns shortcode
 */
if( !function_exists('reales_column_shortcode') ): 
    function reales_column_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
            'type' => '',
        ), $attrs));

        $return_string = '';

        switch($type) {
            case 'one_half':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pb20">' . $content . '</div>';
                break;
            case 'one_half_last':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pb20">' . $content . '</div>';
                $return_string .= '<div class="clearfix"></div>';
                break;
            case 'one_third':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pb20">' . $content . '</div>';
                break;
            case 'one_third_last':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pb20">' . $content . '</div>';
                $return_string .= '<div class="clearfix"></div>';
                break;
            case 'one_fourth':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pb20">' . $content . '</div>';
                break;
            case 'one_fourth_last':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pb20">' . $content . '</div>';
                $return_string .= '<div class="clearfix"></div>';
                break;
            case 'two_third':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pb20">' . $content . '</div>';
                break;
            case 'two_third_last':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pb20">' . $content . '</div>';
                $return_string .= '<div class="clearfix"></div>';
                break;
            case 'three_fourth':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pb20">' . $content . '</div>';
                break;
            case 'three_fourth_last':
                $return_string .= '<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pb20">' . $content . '</div>';
                $return_string .= '<div class="clearfix"></div>';
                break;
        }

        wp_reset_query();
        return $return_string;
    }
endif;


/**
 *****************************************************************************
 * Custom post types
 *****************************************************************************
 */

/**
 * Register property custom post type
 */
if( !function_exists('reales_register_property_type_init') ): 
    function reales_register_property_type_init() {
        wp_enqueue_style('reales_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_style('datepicker_style', plugins_url( '/css/datepicker.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?sensor=true&amp;libraries=geometry&amp;libraries=places', array('jquery'), '1.0', true);
        wp_enqueue_script('boostrap-datepicker', plugins_url( '/js/bootstrap-datepicker.js', __FILE__ ), false, '1.0', true);
        wp_enqueue_script('property', plugins_url( '/js/property.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('property', 'property_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'plugins_url' => plugins_url( '/images/', __FILE__ ),
                  'browse_text' => __('Browse...', 'reales'),
                  'delete_photo' => __('Delete', 'reales')
            )
        );
    }
endif;
add_action('init', 'reales_register_property_type_init');

if( !function_exists('reales_register_property_type') ): 
    function reales_register_property_type() {
        register_post_type('property', array(
            'labels' => array(
                'name'                  => __('Properties','reales'),
                'singular_name'         => __('Property','reales'),
                'add_new'               => __('Add New Property','reales'),
                'add_new_item'          => __('Add Property','reales'),
                'edit'                  => __('Edit','reales'),
                'edit_item'             => __('Edit Property','reales'),
                'new_item'              => __('New Property','reales'),
                'view'                  => __('View','reales'),
                'view_item'             => __('View Property','reales'),
                'search_items'          => __('Search Properties','reales'),
                'not_found'             => __('No Properties found','reales'),
                'not_found_in_trash'    => __('No Properties found in Trash','reales'),
                'parent'                => __('Parent Property', 'reales'),
            ),
            'public'                => true,
            'exclude_from_search '  => false,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'properties'),
            'supports'              => array('title', 'editor', 'thumbnail', 'comments'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'reales_add_property_metaboxes',
            'menu_icon'             => plugins_url( '/images/property-icon.png', __FILE__ )
        ));

        // add property category custom taxonomy (e.g. apartments/houses)
        register_taxonomy('property_category', 'property', array(
            'labels' => array(
                'name'              => __('Property Categories','reales'),
                'add_new_item'      => __('Add New Property Category','reales'),
                'new_item_name'     => __('New Property Category','reales')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'listings')
        ));

        // add property type custom taxonomy (e.g. for rent/for sale)
        register_taxonomy('property_type_category', 'property', array(
            'labels' => array(
                'name'              => __('Property Types','reales'),
                'add_new_item'      => __('Add New Property Type','reales'),
                'new_item_name'     => __('New Property Type','reales')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'type')
        ));
    }
endif;
add_action('init', 'reales_register_property_type');

if( !function_exists('reales_insert_default_terms') ): 
    function reales_insert_default_terms() {
        reales_register_property_type();
        wp_insert_term('Apartment', 'property_category', $args = array());
        wp_insert_term('House', 'property_category', $args = array());
        wp_insert_term('Land', 'property_category', $args = array());
        wp_insert_term('For Rent', 'property_type_category', $args = array());
        wp_insert_term('For Sale', 'property_type_category', $args = array());
    }
endif;
register_activation_hook( __FILE__, 'reales_insert_default_terms' );

/**
 * Add property post type metaboxes
 */
if( !function_exists('reales_add_property_metaboxes') ): 
    function reales_add_property_metaboxes() {
        add_meta_box('property-location-section', __('Location', 'reales'), 'reales_property_location_render', 'property', 'normal', 'default');
        add_meta_box('property-details-section', __('Details', 'reales'), 'reales_property_details_render', 'property', 'normal', 'default');
        add_meta_box('property-additional-section', __('Additional Information', 'reales'), 'reales_property_additional_render', 'property', 'normal', 'default');
        add_meta_box('property-amenities-section', __('Amenities', 'reales'), 'reales_property_amenities_render', 'property', 'normal', 'default');
        add_meta_box('property-plans-section', __('Floor Plans', 'reales'), 'reales_property_plans_render', 'property', 'normal', 'default');
        add_meta_box('property-agent-section', __('Agent', 'reales'), 'reales_property_agent_render', 'property', 'normal', 'default');
        add_meta_box('property-video-section', __('Video', 'reales'), 'reales_property_video_render', 'property', 'normal', 'default');
        add_meta_box('property-gallery-section', __('Photo Gallery', 'reales'), 'reales_property_gallery_render', 'property', 'normal', 'default');
        add_meta_box('property-featured-section', __('Featured', 'reales'), 'reales_property_featured_render', 'property', 'side', 'default');
    }
endif;

if( !function_exists('reales_property_location_render') ): 
    function reales_property_location_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_city">' . __('City', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_city" name="property_city" placeholder="' . __('Enter a city name', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_city', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_lat">' . __('Latitude', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_lat" name="property_lat" value="' . esc_attr(get_post_meta($post->ID, 'property_lat', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_lng">' . __('Longitude', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_lng" name="property_lng" value="' . esc_attr(get_post_meta($post->ID, 'property_lng', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <div id="propMapView"></div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_address">' . __('Address', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_address" name="property_address" placeholder="' . __('Enter address', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_address', true)) . '" />
                            <input id="placePinBtn" type="button" class="button" value="' . __('Place pin by address', 'reales') . '">
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_state">' . __('County/State', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_state" name="property_state" placeholder="' . __('Enter county/state', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_state', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_state">' . __('Neighborhood', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_neighborhood" name="property_neighborhood" placeholder="' . __('Enter neighborhood', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_neighborhood', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_zip">' . __('Zip Code', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_zip" name="property_zip" placeholder="' . __('Enter zip code', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_zip', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_country">' . __('Country', 'reales') . '</label><br />';
                            print reales_country_list(esc_html(get_post_meta($post->ID, 'property_country', true)));
                            print '
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_property_details_render') ): 
    function reales_property_details_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $reales_general_settings = get_option('reales_general_settings');

        $price = (esc_html(get_post_meta($post->ID, 'property_price', true)) != '') ? esc_html(get_post_meta($post->ID, 'property_price', true)) : 0;
        $currency_symbol = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
        $unit = isset($reales_general_settings['reales_unit_field']) ? $reales_general_settings['reales_unit_field'] : '';

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_price">' . __('Price', 'reales') . ' (' . esc_html($currency_symbol) . ')' . '</label><br />
                            <input type="text" class="formInput" id="property_price" name="property_price" placeholder="' . __('Enter price', 'reales') . '" value="' . esc_attr($price) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_price_label">' . __('Price Label (e.g. "per month")', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_price_label" name="property_price_label" placeholder="' . __('Enter price label', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_price_label', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_area">' . __('Area', 'reales') . ' (' . esc_html($unit) . ')' . '</label><br />
                            <input type="text" class="formInput" id="property_area" name="property_area" placeholder="' . __('Enter area', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_area', true)) . '" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_bedrooms">' . __('Bedrooms', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_bedrooms" name="property_bedrooms" placeholder="' . __('Enter number of bedrooms', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_bedrooms', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_bathrooms">' . __('Bathrooms', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_bathrooms" name="property_bathrooms" placeholder="' . __('Enter number of bathrooms', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_bathrooms', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_property_additional_render') ): 
    function reales_property_additional_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $reales_fields_settings = get_option('reales_fields_settings');
        $counter = 0;

        if(is_array($reales_fields_settings)) {
            print '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
            foreach ($reales_fields_settings as $key => $value) {
                $counter++;
                if(($counter - 1) % 3 == 0) {
                    print '<tr>';
                }
                print '
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="' . $key . '">' . $value['label'] . '</label><br />';
                if($value['type'] == 'date_field') {
                    print '<input type="text" name="' . $key . '" id="' . $key . '" class="formInput datePicker" value="' . esc_attr(get_post_meta($post->ID, $key, true)) . '" />';
                } else {
                    print '<input type="text" name="' . $key . '" id="' . $key . '" class="formInput" value="' . esc_attr(get_post_meta($post->ID, $key, true)) . '" />';
                }
                print   '</div>
                    </td>';
                if($counter % 3 == 0) {
                    print '</tr>';
                }
            }
            print '</table>';
        } else {
            print __('No addtional information fields defined', 'reales');
        }
    }
endif;

if( !function_exists('reales_property_amenities_render') ): 
    function reales_property_amenities_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $reales_amenities_settings = get_option('reales_amenities_settings');
        $amenities_list = array();
        $amenities = isset($reales_amenities_settings['reales_amenities_field']) ? $reales_amenities_settings['reales_amenities_field'] : '';
        $amenities_list = explode(',', $amenities);
        $counter = 0;

        if($amenities != '') {
            print '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
            foreach($amenities_list as $key => $value) {
                if($value != '') {
                    $counter++;
                    $post_var_name = str_replace(' ', '_', trim($value));

                    if(($counter - 1) % 3 == 0) {
                        print '<tr>';
                    }
                    $input_name = reales_substr45(sanitize_title($post_var_name));
                    $input_name = sanitize_key($input_name);
                    print '
                        <td width="33%" valign="top" align="left">
                            <p class="meta-options"> 
                                <input type="hidden" name="' . $input_name . '" value="">
                                <input type="checkbox" name="' . $input_name . '" value="1" ';

                    if (get_post_meta($post->ID, $input_name, true) == 1) {
                        print ' checked ';
                    }
                    print ' />
                                <label for="' . $input_name . '">' . $value . '</label>
                            </p>
                        </td>';
                    if($counter % 3 == 0) {
                        print '</tr>';
                    }
                }
            }
            print '</table>';
        } else {
            print __('No amenities defined', 'reales');
        }
    }
endif;

if( !function_exists('reales_property_plans_render') ): 
    function reales_property_plans_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $plans = array();
        $images_list = esc_html(get_post_meta($post->ID, 'property_plans', true));
        $images = explode('~~~', $images_list);

        print '<input type="hidden" id="property_plans" name="property_plans" value="' . esc_attr(get_post_meta($post->ID, 'property_plans', true)) . '" />';
        print '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="propPlansList">';
        foreach($images as $image) {
            if($image != '') {
                print '<tr><td valign="middle" align="left"><img src="' . esc_url($image) . '" /></td><td valign="middle" align="right"><a href="javascript:void(0);" class="delImage">' . __('Delete', 'reales') . '</a></td></tr>';
            }
        }
        print '</table>';
        print '<input id="addImageBtn" type="button" class="button" value="' . __('Add plan image', 'reales') . '" />';
    }
endif;

if( !function_exists('reales_property_agent_render') ): 
    function reales_property_agent_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $mypost = $post->ID;
        $originalpost = $post;
        $agent_list = '';
        $selected_agent = esc_html(get_post_meta($mypost, 'property_agent', true));

        $args = array(
            'post_type' => 'agent',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $agent_selection = new WP_Query($args);

        while($agent_selection->have_posts()) {
            $agent_selection->the_post();
            $the_id = get_the_ID();

            $agent_list .= '<option value="' . esc_attr($the_id) . '"';
                if ($the_id == $selected_agent) {
                    $agent_list .= ' selected';
                }
                $agent_list .= '>' . get_the_title() . '</option>';
        }

        wp_reset_postdata();
        $post = $originalpost;

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_agent">' . __('Assign an Agent', 'reales') . '</label><br />
                            <select id="property_agent" name="property_agent">
                                <option value="">none</option>
                                ' . $agent_list . '
                            </select>
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_property_video_render') ): 
    function reales_property_video_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $selected_source = esc_html(get_post_meta($post->ID, 'property_video_source', true));

        if($selected_source == 'youtube') {
            $source_list = '<option value="">none</option>
                            <option value="youtube" selected>' . __('youtube', 'reales') . '</option>
                            <option value="vimeo">' . __('vimeo', 'reales') . '</option>';
        } else if($selected_source == 'vimeo') {
            $source_list = '<option value="">none</option>
                            <option value="youtube">' . __('youtube', 'reales') . '</option>
                            <option value="vimeo" selected>' . __('vimeo', 'reales') . '</option>';
        } else {
            $source_list = '<option value="" selected>none</option>
                            <option value="youtube">' . __('youtube', 'reales') . '</option>
                            <option value="vimeo">' . __('vimeo', 'reales') . '</option>';
        }

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_video_source">' . __('Video source', 'reales') . '</label><br />
                            <select id="property_video_source" name="property_video_source">
                                ' . $source_list . '
                            </select>
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="property_video_id">' . __('Video ID', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="property_video_id" name="property_video_id" placeholder="' . __('Enter video ID', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'property_video_id', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">&nbsp;</td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_property_gallery_render') ): 
    function reales_property_gallery_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');
        $gallery = array();
        $photos_list = esc_html(get_post_meta($post->ID, 'property_gallery', true));
        $photos = explode('~~~', $photos_list);

        print '<input type="hidden" id="property_gallery" name="property_gallery" value="' . esc_attr(get_post_meta($post->ID, 'property_gallery', true)) . '" />';
        print '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="propGalleryList">';
        foreach($photos as $photo) {
            if($photo != '') {
                print '<tr><td valign="middle" align="left"><img src="' . esc_url($photo) . '" /></td><td valign="middle" align="right"><a href="javascript:void(0);" class="delPhoto">' . __('Delete', 'reales') . '</a></td></tr>';
            }
        }
        print '</table>';
        print '<input id="addPhotoBtn" type="button" class="button" value="' . __('Add photo', 'reales') . '" />';
    }
endif;

if( !function_exists('reales_property_featured_render') ): 
    function reales_property_featured_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'property_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <input type="hidden" name="property_featured" value="">
                            <input type="checkbox" name="property_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'property_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="property_featured">' . __('Set as Featured', 'reales') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_property_meta_save') ): 
    function reales_property_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['property_noncename']) && wp_verify_nonce($_POST['property_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['property_city'])) {
            update_post_meta($post_id, 'property_city', sanitize_text_field($_POST['property_city']));
        }
        if(isset($_POST['property_lat'])) {
            update_post_meta($post_id, 'property_lat', sanitize_text_field($_POST['property_lat']));
        }
        if(isset($_POST['property_lng'])) {
            update_post_meta($post_id, 'property_lng', sanitize_text_field($_POST['property_lng']));
        }
        if(isset($_POST['property_address'])) {
            update_post_meta($post_id, 'property_address', sanitize_text_field($_POST['property_address']));
        }
        if(isset($_POST['property_state'])) {
            update_post_meta($post_id, 'property_state', sanitize_text_field($_POST['property_state']));
        }
        if(isset($_POST['property_neighborhood'])) {
            update_post_meta($post_id, 'property_neighborhood', sanitize_text_field($_POST['property_neighborhood']));
        }
        if(isset($_POST['property_zip'])) {
            update_post_meta($post_id, 'property_zip', sanitize_text_field($_POST['property_zip']));
        }
        if(isset($_POST['property_country'])) {
            update_post_meta($post_id, 'property_country', sanitize_text_field($_POST['property_country']));
        }
        if(isset($_POST['property_price'])) {
            update_post_meta($post_id, 'property_price', sanitize_text_field($_POST['property_price']));
        }
        if(isset($_POST['property_price_label'])) {
            update_post_meta($post_id, 'property_price_label', sanitize_text_field($_POST['property_price_label']));
        }
        if(isset($_POST['property_area'])) {
            update_post_meta($post_id, 'property_area', sanitize_text_field($_POST['property_area']));
        }
        if(isset($_POST['property_bedrooms'])) {
            update_post_meta($post_id, 'property_bedrooms', sanitize_text_field($_POST['property_bedrooms']));
        }
        if(isset($_POST['property_bathrooms'])) {
            update_post_meta($post_id, 'property_bathrooms', sanitize_text_field($_POST['property_bathrooms']));
        }

        $reales_amenities_settings = get_option('reales_amenities_settings');
        $amenities_list = array();
        $amenities = isset($reales_amenities_settings['reales_amenities_field']) ? $reales_amenities_settings['reales_amenities_field'] : '';
        $amenities_list = explode(',', $amenities);
        foreach($amenities_list as $key => $value) {
            $post_var_name = str_replace(' ', '_', trim($value));
            $input_name = reales_substr45(sanitize_title($post_var_name));
            $input_name = sanitize_key($input_name);

            if(isset($_POST[$input_name])) {
                update_post_meta($post_id, $input_name, sanitize_text_field($_POST[$input_name]));
            }
        }

        if(isset($_POST['property_plans'])) {
            update_post_meta($post_id, 'property_plans', sanitize_text_field($_POST['property_plans']));
        }

        $reales_fields_settings = get_option('reales_fields_settings');
        if(is_array($reales_fields_settings)) {
            foreach ($reales_fields_settings as $key => $value) {
                if(isset($_POST[$key])) {
                    update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
                }
            }
        }

        if(isset($_POST['property_agent'])) {
            update_post_meta($post_id, 'property_agent', sanitize_text_field($_POST['property_agent']));
        }
        if(isset($_POST['property_video_source'])) {
            update_post_meta($post_id, 'property_video_source', sanitize_text_field($_POST['property_video_source']));
        }
        if(isset($_POST['property_video_id'])) {
            update_post_meta($post_id, 'property_video_id', sanitize_text_field($_POST['property_video_id']));
        }
        if(isset($_POST['property_gallery'])) {
            update_post_meta($post_id, 'property_gallery', sanitize_text_field($_POST['property_gallery']));
        }
        if(isset($_POST['property_featured'])) {
            update_post_meta($post_id, 'property_featured', sanitize_text_field($_POST['property_featured']));
        }
    }
endif;
add_action('save_post', 'reales_property_meta_save');

if( !function_exists('reales_country_list') ): 
    function reales_country_list($selected) {
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $country_select = '<select id="property_country" name="property_country">';

        if ($selected == '') {
            $reales_general_settings = get_option('reales_general_settings');
            if(isset($reales_general_settings['reales_country_field'])) {
                $selected = $reales_general_settings['reales_country_field'];
            }
        }

        foreach ($countries as $country) {
            $country_select .= '<option value="' . esc_attr($country) . '"';
            if ($selected == $country) {
                $country_select .= 'selected="selected"';
            }
            $country_select .= '>' . esc_html($country) . '</option>';
        }
        $country_select.='</select>';

        return $country_select;
    }
endif;

if( !function_exists('reales_substr45') ): 
    function reales_substr45($string) {
        return substr($string, 0, 45);
    }
endif;

if( !function_exists('reales_change_property_default_title') ): 
    function reales_change_property_default_title($title){
        $screen = get_current_screen();
        if ('property' == $screen->post_type) {
            $title = __('Enter property title here', 'reales');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'reales_change_property_default_title');


/**
 * Register agent custom post type
 */
if( !function_exists('reales_register_agent_type_init') ): 
    function reales_register_agent_type_init() {
        wp_enqueue_style('reales_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_script('agent', plugins_url( '/js/agent.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('agent', 'agent_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'browse_text' => __('Browse...', 'reales')
            )
        );
    }
endif;
add_action('init', 'reales_register_agent_type_init');

if( !function_exists('reales_register_agent_type') ): 
    function reales_register_agent_type() {
        register_post_type('agent', array(
            'labels' => array(
                'name'                  => __('Agents','reales'),
                'singular_name'         => __('Agent','reales'),
                'add_new'               => __('Add New Agent','reales'),
                'add_new_item'          => __('Add Agent','reales'),
                'edit'                  => __('Edit','reales'),
                'edit_item'             => __('Edit Agent','reales'),
                'new_item'              => __('New Agent','reales'),
                'view'                  => __('View','reales'),
                'view_item'             => __('View Agent','reales'),
                'search_items'          => __('Search Agents','reales'),
                'not_found'             => __('No Agents found','reales'),
                'not_found_in_trash'    => __('No Agents found in Trash','reales'),
                'parent'                => __('Parent Agent', 'reales'),
            ),
            'public'                => true,
            'exclude_from_search '  => true,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'agents'),
            'supports'              => array('title', 'thumbnail'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'reales_add_agent_metaboxes',
            'menu_icon'             => plugins_url( '/images/agent-icon.png', __FILE__ )
        ));
    }
endif;
add_action('init', 'reales_register_agent_type');

function reales_add_agent_metaboxes() {
    add_meta_box('agent-about-section', __('About', 'reales'), 'reales_agent_about_render', 'agent', 'normal', 'default');
    add_meta_box('agent-details-section', __('Details', 'reales'), 'reales_agent_details_render', 'agent', 'normal', 'default');
    add_meta_box('agent-avatar-section', __('Avatar', 'reales'), 'reales_agent_avatar_render', 'agent', 'normal', 'default');
    add_meta_box('agent-user-section', __('User', 'reales'), 'reales_agent_user_render', 'agent', 'normal', 'default');
    add_meta_box('agent-featured-section', __('Featured', 'reales'), 'reales_agent_featured_render', 'agent', 'side', 'default');
}

if( !function_exists('reales_agent_about_render') ): 
    function reales_agent_about_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'agent_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <textarea class="agentAbout" id="agent_about" name="agent_about" placeholder="' . __('Enter agent info here', 'reales') . '">' . esc_html(get_post_meta($post->ID, 'agent_about', true)) . '</textarea>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_agent_details_render') ): 
    function reales_agent_details_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'agent_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_specs">' . __('Specialities', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_specs" name="agent_specs" placeholder="' . __('Enter specialities', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_specs', true)) . '" />
                        </div>
                    </td>
                    <td width="50%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_email">' . __('Email', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_email" name="agent_email" placeholder="' . __('Enter email', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_email', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_phone">' . __('Phone', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_phone" name="agent_phone" placeholder="' . __('Enter phone', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_phone', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_mobile">' . __('Mobile', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_mobile" name="agent_mobile" placeholder="' . __('Enter phone', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_mobile', true)) . '" />
                        </div>
                    </td>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_skype">' . __('Skype', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_skype" name="agent_skype" placeholder="' . __('Enter Skype ID', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_skype', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_facebook">' . __('Facebook', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_facebook" name="agent_facebook" placeholder="' . __('Enter Facebook profile URL', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_facebook', true)) . '" />
                        </div>
                    </td>
                    <td width="50%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_twitter">' . __('Twitter', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_twitter" name="agent_twitter" placeholder="' . __('Enter Twitter profile URL', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_twitter', true)) . '" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_google">' . __('Google+', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_google" name="agent_google" placeholder="' . __('Enter Google+ profile URL', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_google', true)) . '" />
                        </div>
                    </td>
                    <td width="50%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_linkedin">' . __('LinkedIn', 'reales') . '</label><br />
                            <input type="text" class="formInput" id="agent_linkedin" name="agent_linkedin" placeholder="' . __('Enter LinkedIn profile URL', 'reales') . '" value="' . esc_attr(get_post_meta($post->ID, 'agent_linkedin', true)) . '" />
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_agent_user_render') ): 
    function reales_agent_user_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'agent_noncename');

        $selected_user = esc_html(get_post_meta($post->ID, 'agent_user', true));
        $users = get_users();
        $users_list = '';

        foreach ( $users as $user ) {
            $users_list .= '<option value="' . $user->ID . '"';
            if ($user->ID == $selected_user) {
                $users_list .= ' selected';
            }
            $users_list .= '>' . $user->user_login . ' - ' . $user->first_name . ' ' . $user->last_name . '</option>';
        }

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="33%" valign="top" align="left">
                        <div class="adminField">
                            <label for="agent_user">' . __('Assign a User', 'reales') . '</label><br />
                            <select id="agent_user" name="agent_user">
                                <option value="">none</option>
                                ' . $users_list . '
                            </select>
                        </div>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_agent_avatar_render') ): 
    function reales_agent_avatar_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'agent_noncename');

        print '
            <input id="agent_avatar" name="agent_avatar" type="text" size="60" value="' . esc_attr(get_post_meta($post->ID, 'agent_avatar', true)) . '" />
            <input id="agentAvatarBtn" type="button"  class="button" value="' . __('Browse...','reales') . '" />';
    }
endif;

if( !function_exists('reales_agent_featured_render') ): 
    function reales_agent_featured_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'agent_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <input type="hidden" name="agent_featured" value="">
                            <input type="checkbox" name="agent_featured" value="1" ';
                            if (esc_html(get_post_meta($post->ID, 'agent_featured', true)) == 1) {
                                print ' checked ';
                            }
                            print ' />
                            <label for="agent_featured">' . __('Set as Featured', 'reales') . '</label>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_agent_meta_save') ): 
    function reales_agent_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['agent_noncename']) && wp_verify_nonce($_POST['agent_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['agent_about'])) {
            update_post_meta($post_id, 'agent_about', sanitize_text_field($_POST['agent_about']));
        }
        if(isset($_POST['agent_specs'])) {
            update_post_meta($post_id, 'agent_specs', sanitize_text_field($_POST['agent_specs']));
        }
        if(isset($_POST['agent_email'])) {
            update_post_meta($post_id, 'agent_email', sanitize_text_field($_POST['agent_email']));
        }
        if(isset($_POST['agent_phone'])) {
            update_post_meta($post_id, 'agent_phone', sanitize_text_field($_POST['agent_phone']));
        }
        if(isset($_POST['agent_mobile'])) {
            update_post_meta($post_id, 'agent_mobile', sanitize_text_field($_POST['agent_mobile']));
        }
        if(isset($_POST['agent_skype'])) {
            update_post_meta($post_id, 'agent_skype', sanitize_text_field($_POST['agent_skype']));
        }
        if(isset($_POST['agent_facebook'])) {
            update_post_meta($post_id, 'agent_facebook', sanitize_text_field($_POST['agent_facebook']));
        }
        if(isset($_POST['agent_twitter'])) {
            update_post_meta($post_id, 'agent_twitter', sanitize_text_field($_POST['agent_twitter']));
        }
        if(isset($_POST['agent_google'])) {
            update_post_meta($post_id, 'agent_google', sanitize_text_field($_POST['agent_google']));
        }
        if(isset($_POST['agent_linkedin'])) {
            update_post_meta($post_id, 'agent_linkedin', sanitize_text_field($_POST['agent_linkedin']));
        }
        if(isset($_POST['agent_user'])) {
            update_post_meta($post_id, 'agent_user', sanitize_text_field($_POST['agent_user']));
        }
        if(isset($_POST['agent_avatar'])) {
            update_post_meta($post_id, 'agent_avatar', sanitize_text_field($_POST['agent_avatar']));
        }
        if(isset($_POST['agent_featured'])) {
            update_post_meta($post_id, 'agent_featured', sanitize_text_field($_POST['agent_featured']));
        }
    }
endif;
add_action('save_post', 'reales_agent_meta_save');

if( !function_exists('reales_change_agent_default_title') ): 
    function reales_change_agent_default_title($title) {
        $screen = get_current_screen();
        if ('agent' == $screen->post_type) {
            $title = __('Enter agent name here', 'reales');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'reales_change_agent_default_title');


/**
 * Register testimonials custom post type
 */
if( !function_exists('reales_register_testimonials_type_init') ): 
    function reales_register_testimonials_type_init() {
        wp_enqueue_style('reales_plugin_style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all');
        wp_enqueue_script('testimonials', plugins_url( '/js/testimonials.js', __FILE__ ), false, '1.0', true);

        wp_localize_script('testimonials', 'testimonials_vars', 
            array('admin_url' => get_admin_url(),
                  'theme_url' => get_template_directory_uri(),
                  'browse_text' => __('Browse...', 'reales')
            )
        );
    }
endif;
add_action('init', 'reales_register_testimonials_type_init');

if( !function_exists('reales_register_testimonials_type') ): 
    function reales_register_testimonials_type() {
        register_post_type('testimonials', array(
            'labels' => array(
                'name'                  => __('Testimonials','reales'),
                'singular_name'         => __('Testimonial','reales'),
                'add_new'               => __('Add New Testimonial','reales'),
                'add_new_item'          => __('Add Testimonial','reales'),
                'edit'                  => __('Edit','reales'),
                'edit_item'             => __('Edit Testimonial','reales'),
                'new_item'              => __('New Testimonial','reales'),
                'view'                  => __('View','reales'),
                'view_item'             => __('View Testimonial','reales'),
                'search_items'          => __('Search Testimonials','reales'),
                'not_found'             => __('No Testimonials found','reales'),
                'not_found_in_trash'    => __('No Testimonials found in Trash','reales'),
                'parent'                => __('Parent Testimonial', 'reales'),
            ),
            'public'                => true,
            'exclude_from_search '  => true,
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'testimonials'),
            'supports'              => array('title', 'thumbnail'),
            'can_export'            => true,
            'register_meta_box_cb'  => 'reales_add_testimonials_metaboxes',
            'menu_icon'             => plugins_url( '/images/testimonials-icon.png', __FILE__ )
        ));
    }
endif;
add_action('init', 'reales_register_testimonials_type');

if( !function_exists('reales_add_testimonials_metaboxes') ): 
    function reales_add_testimonials_metaboxes() {
        add_meta_box('testimonials-text-section', __('What the customer says', 'reales'), 'reales_testimonials_text_render', 'testimonials', 'normal', 'default');
        add_meta_box('testimonials-section', __('Avatar', 'reales'), 'reales_testimonials_avatar_render', 'testimonials', 'normal', 'default');
    }
endif;

if( !function_exists('reales_testimonials_text_render') ): 
    function reales_testimonials_text_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'testimonilas_noncename');

        print '
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" valign="top" align="left">
                        <p class="meta-options">
                            <textarea class="agentAbout" id="testimonials_text" name="testimonials_text" placeholder="' . __('Enter what the customer says here', 'reales') . '">' . esc_html(get_post_meta($post->ID, 'testimonials_text', true)) . '</textarea>
                        </p>
                    </td>
                </tr>
            </table>';
    }
endif;

if( !function_exists('reales_testimonials_avatar_render') ): 
    function reales_testimonials_avatar_render($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'testimonilas_noncename');

        print '
            <input id="testimonials_avatar" name="testimonials_avatar" type="text" size="60" value="' . esc_attr(get_post_meta($post->ID, 'testimonials_avatar', true)) . '" />
            <input id="testimonialsAvatarBtn" type="button"  class="button" value="' . __('Browse...','reales') . '" />';
    }
endif;

if( !function_exists('reales_testimonials_meta_save') ): 
    function reales_testimonials_meta_save($post_id) {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['testimonilas_noncename']) && wp_verify_nonce($_POST['testimonilas_noncename'], basename(__FILE__))) ? 'true' : 'false';

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        if(isset($_POST['testimonials_text'])) {
            update_post_meta($post_id, 'testimonials_text', sanitize_text_field($_POST['testimonials_text']));
        }
        if(isset($_POST['testimonials_avatar'])) {
            update_post_meta($post_id, 'testimonials_avatar', sanitize_text_field($_POST['testimonials_avatar']));
        }
    }
endif;
add_action('save_post', 'reales_testimonials_meta_save');

if( !function_exists('reales_change_testimonials_default_title') ): 
    function reales_change_testimonials_default_title($title) {
        $screen = get_current_screen();
        if ('testimonials' == $screen->post_type) {
            $title = __('Enter customer name here', 'reales');
        }
        return $title;
    }
endif;
add_filter('enter_title_here', 'reales_change_testimonials_default_title');
?>