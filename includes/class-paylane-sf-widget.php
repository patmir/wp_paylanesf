<?php
class Paylane_Sf_Widget extends WP_Widget
{

	// Main constructor
	public function __construct()
	{
		parent::__construct(
			'paylane_sf_widget',
			__('Paylane SF Widget', 'text_domain'),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form($instance)
	{
		$defaults = array(
			'podziekowania' => "Dziękujemy za wsparcie!"
		);
		extract(wp_parse_args(( array )$instance, $defaults));
		?>
	<p>Ustawienia widgetu są dostępne w panelu admina -> Ustawienia -> Paylane SF</p>
	<p> Jeśli nie podano adres strony z podziękowaniem, dodaj treść w polu <code>Podziękowania</code></p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('podziekowania')); ?>"><?php _e('Podziękowania:', 'text_domain'); ?></label>
		<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('podziekowania')); ?>" name="<?php echo esc_attr($this->get_field_name('podziekowania')); ?>"><?php echo wp_kses_post($podziekowania); ?></textarea>
	</p>
<?php
}

// Update widget settings
public function update($new_instance, $old_instance)
{
	$instance = $old_instance;
	$instance['podziekowania'] = isset($new_instance['podziekowania']) ? wp_kses_post($new_instance['podziekowania']) : '';
	return $instance;
}

// Display the widget
public function widget($args, $instance)
{
	wp_enqueue_script('paylane-sf-widget-js');
	extract($args);
	$podziekowania = isset($instance['podziekowania']) ? $instance['podziekowania'] : 'Dziękujemy za wsparcie!';
	include_once(PAYLANE_SF_VIEWS_PATH . 'widget.php');
	$admin_ajax_url = admin_url('admin-ajax.php', $protocol);

	//za pomocą tej funkcji przekazujemy zmienną zawierająca adres, do javascript  
	wp_localize_script('paylane-sf-widget-js', 'ajax_options', array('admin_ajax_url' => $admin_ajax_url));
}

public function register_paylane_sf_widget()
{
	register_widget('Paylane_Sf_Widget');
}

public function register_paylance_sfwidgets_scripts()
{
	wp_register_script('paylane-sf-widget-js', plugin_dir_url(__FILE__) . '../views/js/widget.js', array('jquery'), false, true);
}

public function paylane_sf_get_hash()
{
	global $wpdb;
	$amount =  $_POST['amount'];
	$calling_url_isQuery = parse_url($_POST['source'], PHP_URL_QUERY);
	$options = get_option('paylane_sf_settings');
	$mid = isset($options['mid']) ? $options['mid'] : '';
	$salt = isset($options['salt']) ? $options['salt'] : '';
	$url = isset($options['url']) && !empty($options['url']) ? $options['url'] : $_POST['source'] . (isset($calling_url_isQuery) ? "&paylaneSFTY=1" : "?paylaneSFTY=1");

	$desc = "FWN_" . substr(md5(mt_rand()), 0, 10);
	$type = "S";
	$currency = "PLN";
	$trans_desc = "DAROWIZNA NA CELE STATUTOWE"; // . $amount . " " . $currency;
	$hash = SHA1($salt + "|" + $desc + "|" + $amount + "|" + $currency + "|" + $type);

	?>
	<form action="https://secure.paylane.com/order/cart.html" method="post">
		<input type="hidden" name="amount" value="<?= $amount; ?>">
		<input type="hidden" name="currency" value="<?= $currency; ?>">
		<input type="hidden" name="merchant_id" value="<?= $mid; ?>">
		<input type="hidden" name="description" value="<?= $desc; ?>" />
		<input type="hidden" name="transaction_description" value="<?= $trans_desc; ?>" />
		<input type="hidden" name="transaction_type" value="<?= $type; ?>">
		<input type="hidden" name="language" value="pl">
		<input type="hidden" name="hash" value="<?= $hash; ?>" />
		<input type="hidden" name="back_url" value="<?= $url; ?>">
	</form>

	<?php
	wp_die();
}
}
?>