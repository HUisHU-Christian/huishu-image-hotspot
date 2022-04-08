<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );?>
<?php
// Register Custom Post Type
function hu_ihotspot_cpt_func() {

	$labels = array(
		'name'                  => _x( 'Image Hotspot', 'Post Type General Name', 'huishu-image-hotspot' ),
		'singular_name'         => _x( 'Image Hotspot', 'Post Type Singular Name', 'huishu-image-hotspot' ),
		'menu_name'             => __( 'Image Hotspot', 'huishu-image-hotspot' ),
		'name_admin_bar'        => __( 'Image Hotspot', 'huishu-image-hotspot' ),
		'archives'              => __( 'Item Archives', 'huishu-image-hotspot' ),
		'parent_item_colon'     => __( 'Parent Item:', 'huishu-image-hotspot' ),
		'all_items'             => __( 'All Items', 'huishu-image-hotspot' ),
		'add_new_item'          => __( 'Add New Item', 'huishu-image-hotspot' ),
		'add_new'               => __( 'Add New', 'huishu-image-hotspot' ),
		'new_item'              => __( 'New Item', 'huishu-image-hotspot' ),
		'edit_item'             => __( 'Edit Item', 'huishu-image-hotspot' ),
		'update_item'           => __( 'Update Item', 'huishu-image-hotspot' ),
		'view_item'             => __( 'View Item', 'huishu-image-hotspot' ),
		'search_items'          => __( 'Search Item', 'huishu-image-hotspot' ),
		'not_found'             => __( 'Not found', 'huishu-image-hotspot' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'huishu-image-hotspot' ),
		'featured_image'        => __( 'Featured Image', 'huishu-image-hotspot' ),
		'set_featured_image'    => __( 'Set featured image', 'huishu-image-hotspot' ),
		'remove_featured_image' => __( 'Remove featured image', 'huishu-image-hotspot' ),
		'use_featured_image'    => __( 'Use as featured image', 'huishu-image-hotspot' ),
		'insert_into_item'      => __( 'Insert into item', 'huishu-image-hotspot' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'huishu-image-hotspot' ),
		'items_list'            => __( 'Items list', 'huishu-image-hotspot' ),
		'items_list_navigation' => __( 'Items list navigation', 'huishu-image-hotspot' ),
		'filter_items_list'     => __( 'Filter items list', 'huishu-image-hotspot' ),
	);
	$args = array(
		'label'                 => __( 'Image Hotspot', 'huishu-image-hotspot' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'points_image', $args );

}
add_action( 'init', 'hu_ihotspot_cpt_func', 0 );

//Add admin inline style
function hu_ihotspot_admin_css() {
	global $post_type;
	$post_types = array(
		'points_image'
	);
	if(in_array($post_type, $post_types))
		echo '<style type="text/css">#post-preview, #view-post-btn,#message.notice-success a{display: none;}</style>';
}
add_action( 'admin_head-post-new.php', 'hu_ihotspot_admin_css' );
add_action( 'admin_head-post.php', 'hu_ihotspot_admin_css' );

//Add row to admin column
add_filter( 'page_row_actions', 'hu_ihotspot_row_actions', 10, 2 );
add_filter( 'post_row_actions', 'hu_ihotspot_row_actions', 10, 2 );
function hu_ihotspot_row_actions( $actions, $post ) {
	if($post->post_type == 'points_image'){
	    unset( $actions['inline hide-if-no-js'] );
	    unset( $actions['view'] );
	}
    return $actions;
}

//Add new column
function hu_ihotspot_cpt_admin_columns( $columns ) {
	$columns = array(
		'cb' 			=> '<input type="checkbox" />',
		'title' 		=> __( 'Title','huishu-image-hotspot' ),
		'shortcode' 	=> __( 'Shortcode','huishu-image-hotspot' ),
		'date' 			=> __( 'Date','huishu-image-hotspot' ),
	);
	return $columns;
}
add_filter( 'manage_edit-points_image_columns', 'hu_ihotspot_cpt_admin_columns' ) ;

//Add content to colum
function hu_ihotspot_manage_points_image_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'shortcode' :
			echo '[hu_ihotspot id="'.$post->ID.'"]';
			break;
		default :
			break;
	}
}
add_action( 'manage_points_image_posts_custom_column', 'hu_ihotspot_manage_points_image_columns', 10, 2 );