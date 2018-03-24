<?php
/**
 * Exclude Checkbox in Page Attributes
 */


// Exclude from WP Menu
function custom_wp_list_pages_excludes( $exclude_array ) {
    global $wpdb;
    $sitemap_excludes = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} LEFT JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) WHERE {$wpdb->posts}.post_type = 'page' AND ({$wpdb->postmeta}.meta_key='hide_from_menu' AND {$wpdb->postmeta}.meta_value!=0)" );
    if ( $sitemap_excludes ) {
        $exclude_array = array_merge( $exclude_array, $sitemap_excludes );
    }
    return $exclude_array;
}
add_filter( 'wp_list_pages_excludes', 'custom_wp_list_pages_excludes' );


// Add Custom Field: hide_from_menu
add_action('page_attributes_misc_attributes', 'cslice_createCustomField', 10, 1);
function cslice_createCustomField() {
    $post_id = get_the_ID();
  
    if (get_post_type($post_id) != 'page') {
        return;
    }
  
    $value = get_post_meta($post_id, 'hide_from_menu', true);
    wp_nonce_field('cslice_hide_nonce_'.$post_id, 'cslice_hide_nonce');
    ?>
    <div style="float: right; margin: 3px;">
        <label><input type="checkbox" value="1" <?php checked($value, true, true); ?> name="hide_from_menu" />Hide From Menu</label>
    </div>
    <?php
}

// Save Custom Field
add_action('save_post', 'cslice_saveCustomField');
function cslice_saveCustomField($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (
        !isset($_POST['cslice_hide_nonce']) ||
        !wp_verify_nonce($_POST['cslice_hide_nonce'], 'cslice_hide_nonce_'.$post_id)
    ) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['hide_from_menu'])) {
        update_post_meta($post_id, 'hide_from_menu', $_POST['hide_from_menu']);
    } else {
        delete_post_meta($post_id, 'hide_from_menu');
    }
}