<?php
/**
 * @package WordPress
 * @subpackage Reales
 */
?>

<div class="similar">
    <h3><?php esc_html_e('Properties Listed by Agent', 'reales'); ?></h3>
    <?php
    $orig_post = $post;

    $args = array(
        'post_type' => 'property',
        'post_status' => 'publish',
    );

    $args['meta_query'] = array(
        array(
            'key'     => 'property_agent',
            'value'   => $orig_post->ID
        )
    );

    $my_query = new wp_query($args);

    if($my_query->have_posts()) { ?>
    <div class="row">
        <?php while( $my_query->have_posts() ) {
            $my_query->the_post();

            $s_id = get_the_ID();
            $s_link = get_permalink($s_id);
            $s_title = get_the_title($s_id);
            $s_gallery = get_post_meta($s_id, 'property_gallery', true);
            $s_images = explode("~~~", $s_gallery);

            $s_price = get_post_meta($s_id, 'property_price', true);
            $reales_general_settings = get_option('reales_general_settings');
            $s_currency = isset($reales_general_settings['reales_currency_symbol_field']) ? $reales_general_settings['reales_currency_symbol_field'] : '';
            $s_currency_pos = isset($reales_general_settings['reales_currency_symbol_pos_field']) ? $reales_general_settings['reales_currency_symbol_pos_field'] : '';
            $s_price_label = get_post_meta($s_id, 'property_price_label', true);
            setlocale(LC_MONETARY, 'en_US');
            $s_address = get_post_meta($s_id, 'property_address', true);
            $s_city = get_post_meta($s_id, 'property_city', true);
            $s_state = get_post_meta($s_id, 'property_state', true);
            $s_neighborhood = get_post_meta($s_id, 'property_neighborhood', true);
            $s_zip = get_post_meta($s_id, 'property_zip', true);
            $s_country = get_post_meta($s_id, 'property_country', true);
            $s_type =  wp_get_post_terms($s_id, 'property_type_category');
        ?>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <a href="<?php echo esc_url($s_link); ?>" class="similarProp card-min">
                <div class="image"><img src="<?php echo esc_url($s_images[1]); ?>" alt="<?php echo esc_attr($s_title); ?>"></div>
                <div class="info text-nowrap">
                    <div class="name"><?php echo esc_html($s_title); ?></div>
                    <div class="address">
                        <?php 
                        if($s_address != '') {
                            echo esc_html($s_address) . ', ';
                        }
                        if($s_neighborhood != '') {
                            echo esc_html($s_neighborhood) . ', ';
                        }
                        if($s_city != '') {
                            echo esc_html($s_city) . ', ';
                        }
                        if($s_state != '') {
                            echo esc_html($s_state) . ', ';
                        }
                        if($s_zip != '') {
                            echo esc_html($s_zip) . ', ';
                        }
                        if($s_country != '') {
                            echo esc_html($s_country);
                        }
                        ?>
                    </div>
                    <?php if($s_type) {
                        $s_type_name = $s_type[0]->name;
                    } else {
                        $s_type_name = '';
                    } ?>
                    <?php if($s_currency_pos == 'before') { ?>
                    <div class="price"><?php echo esc_html($s_currency) . money_format('%!.0i', esc_html($s_price)) . esc_html($s_price_label) . ' '; ?><span class="badge"><?php echo esc_html($s_type_name); ?></span></div>
                    <?php } else { ?>
                    <div class="price"><?php echo money_format('%!.0i', esc_html($s_price)) . esc_html($s_currency) . esc_html($s_price_label) . ' '; ?><span class="badge"><?php echo esc_html($s_type_name); ?></span></div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </a>
        </div>
        <?php } ?>
    </div>

    <?php } else {
        print '<div class="noProp">' . __('No listed properties found.', 'reales') . '</div>';
    }

    $post = $orig_post;
    wp_reset_query();
    ?>
</div>
