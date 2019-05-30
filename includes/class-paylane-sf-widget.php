<?php 
class Paylane_Sf_Widget extends WP_Widget {

// Main constructor
public function __construct() {
    parent::__construct(
		'paylane_sf_widget',
		__( 'Paylane SF Widget', 'text_domain' ),
		array(
			'customize_selective_refresh' => true,
		)
	);
}

// The widget form (for the backend )
public function form( $instance ) {	

   // $options = get_option('paylane_sf_settings');
    ?>
    <p>Ustawienia widgetu są dostępne w panelu admina -> Ustawienia -> Paylane SF</p>
<?php
}

// Update widget settings
public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
	 //$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
	return $instance;
}

// Display the widget
public function widget( $args, $instance ) {   
	wp_enqueue_script('paylane-sf-widget-js');
    include_once(PAYLANE_SF_VIEWS_PATH . 'widget.php');
	$admin_ajax_url = admin_url( 'admin-ajax.php', $protocol );  
  
	//za pomocą tej funkcji przekazujemy zmienną zawierająca adres, do javascript  
	wp_localize_script( 'paylane-sf-widget-js', 'ajax_options', array('admin_ajax_url' => $admin_ajax_url) );

}

public function register_paylane_sf_widget() {
	register_widget( 'Paylane_Sf_Widget' );
}

public function register_paylance_sfwidgets_scripts() {
    wp_register_script('paylane-sf-widget-js', plugin_dir_url( __FILE__ ).'../views/js/widget.js', array ('jquery'), false, true);
}

public function paylane_sf_get_hash(){
	global $wpdb;
	$amount =  $_POST['amount'];
	$options = get_option('paylane_sf_settings');
   	$mid = isset($options['mid']) ? $options['mid'] : '';
   	$salt = isset($options['salt']) ? $options['salt'] : '';
	$url = isset($options['url']) ? $options['url'] : null;

	$desc = "FWN_".substr(md5(mt_rand()), 0, 10);
	$type = "S";
	$currency = "PLN";
	$trans_desc = "DAROWIZNA NA KWOTE ".$amount." ".$currency;
	$hash = SHA1($salt+"|"+$desc+"|"+$amount+"|"+$currency+"|"+$type);
	?>
	<form action="https://secure.paylane.com/order/cart.html" method="post">
	<input type="hidden" name="amount" value="<?=$amount;?>">
    <input type="hidden" name="currency" value="<?=$currency;?>">
    <input type="hidden" name="merchant_id" value="<?=$mid;?>">
    <input type="hidden" name="description" value="<?=$desc;?>" />
    <input type="hidden" name="transaction_description" value="<?=$trans_desc;?>" />
    <input type="hidden" name="transaction_type" value="<?=$type;?>">
    <input type="hidden" name="language" value="pl">
    <input type="hidden" name="hash" value="<?=$hash;?>" />
 	<input type="hidden" name="back_url" value="<?=$url;?>">
	</form>

<?php
	wp_die();
}
}
?>