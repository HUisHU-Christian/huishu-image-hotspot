<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'admin_init', 'hu_ihp_register_mysettings' );
function hu_ihp_register_mysettings() {
    register_setting( 'ihp-options-group','ihp_options' );
}

add_action( 'admin_menu', 'hu_ihp_admin_menu' );
function hu_ihp_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=points_image',
        __( 'Image Hotspot settings', 'huishu-image-hotspot' ),
        __( 'Settings', 'huishu-image-hotspot' ),
        'manage_options',
        'huishu-image-hotspot',
        'hu_ihp_callback'
    );
}

function hu_ihp_callback(){
    $popup_type = hu_get_ihp_options('popup_type');
    ?>
    <div class="wrap">
        <h1><?php _e('Image Hotspot settings', 'huishu-image-hotspot');?></h1>
        <form method="post" action="options.php" novalidate="novalidate">
            <?php settings_fields( 'ihp-options-group' );?>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row"><label><?php _e('Popup type on mobile', 'huishu-image-hotspot')?></label></th>
                    <td>
                        <div class="tet_style_radio tet_style_radio_banner">
                            <label style="margin-right: 10px;">
                                <input type="radio" name="ihp_options[popup_type]" value="2" <?php checked('2', $popup_type, true);?>> Full Screen
                            </label>
                            <label>
                                <input type="radio" name="ihp_options[popup_type]" value="1" <?php checked('1', $popup_type, true);?>> Normal - Tooltip
                            </label>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php do_settings_sections('ihp-options-group', 'default'); ?>

            <?php submit_button();?>
        </form>
    </div>
<?php
}

function hu_ihp_action_links( $links, $file ) {
    if ( strpos( $file, 'hu-image-hotspot.php' ) !== false ) {
        $settings_link = '<a href="' . admin_url( 'edit.php?post_type=points_image&page=hu-image-hotspot' ) . '" title="'.__('Settings').'">' . __( 'Settings' ) . '</a>';
        array_unshift( $links, $settings_link );
    }
    return $links;
}
add_filter( 'plugin_action_links_' . HU_IHOTSPOT_BASENAME, 'hu_ihp_action_links', 10, 2 );

function hu_get_ihp_options($name = ''){
    $options = wp_parse_args(get_option('ihp_options'),array(
        'popup_type' => 1,
    ));
    if($name){
        return (isset($options[$name]) && $options[$name]) ? $options[$name] : '';
    }
    return $options;
}

add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
    $popup_type = hu_get_ihp_options('popup_type');
    if ( $popup_type == 2 ) {
        $classes[] = 'ihp_popup_full';
    }
    return $classes;
}