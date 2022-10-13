<?php

namespace PauseRenewalActions\Admin;

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );
add_action( 'admin_menu', __NAMESPACE__ . '\create_options_menu' );
add_action( 'admin_init', __NAMESPACE__ . '\settings_init' );
add_action( 'admin_notices', __NAMESPACE__ . '\maybe_show_warning' );
add_filter( 'plugin_action_links_' . PAUSE_RENEWAL_ACTIONS_BASENAME, __NAMESPACE__ . '\add_action_links' );

/**
 * Enqueues the things for the tools page.
 *
 * @param string $hook_suffix The current admin page.
 *
 * @return void
 */
function enqueue_scripts( string $hook_suffix ) {
	if ( 'tools_page_pause_renewal_actions_options' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_style( 'pause-renewal-actions-admin-style', PAUSE_RENEWAL_ACTIONS_URL . 'assets/css/admin-styles.css', array(), '0.0' );
}

/**
 * Adds the options page under Tools > Pause Renewal Actions.
 *
 * @return void
 */
function create_options_menu() {
	add_submenu_page(
		'tools.php',
		esc_html__( 'Pause Renewal Actions', 'pause-renewal-actions' ),
		esc_html__( 'Pause Renewal Actions', 'pause-renewal-actions' ),
		'manage_options',
		'pause_renewal_actions_options',
		__NAMESPACE__ . '\render_options_html'
	);
}

/**
 * Registers the fields on the Tools page.
 *
 * @return void
 */
function settings_init() {
	// Register settings for Pause Renewal Actions
	register_setting( 'pause-renewal-actions', 'pause_renewal_actions_toggle' );

	// Register section for the settings
	add_settings_section(
		'pause_renewal_actions_option',
		'',
		null,
		'pause_renewal_actions_options'
	);

	add_settings_field(
		'pause_renewal_actions_toggle',
		esc_html__( 'Pause renewal actions', 'pause-renewal-actions' ),
		__NAMESPACE__ . '\render_field',
		'pause_renewal_actions_options',
		'pause_renewal_actions_option',
		array(
			'type'      => 'checkbox',
			'name'      => 'pause_renewal_actions_toggle',
			'class'     => 'pause-renewal-actions-toggle',
			'label_for' => 'pause_renewal_actions_toggle',
		)
	);
}

/**
 * Renders the HTML for the settings.
 *
 * @param array $args Arguments passed to the fields.
 *
 * @return void
 */
function render_field( array $args = array() ) {

	if ( 'on' === get_option( 'pause_renewal_actions_toggle' ) ) {
		$checked = ' checked="checked" '; }
		$html  = '';
		$html .= '<input id="' . esc_attr( $args['name'] ) . '" 
		class="' . esc_attr( $args['class'] ) . '" 
        name="' . esc_attr( $args['name'] ) . '" 
        type="checkbox" ' . $checked . '/>';

		echo $html;
}

/**
 * Renders the HTML for the options page.
 *
 * @return void
 */
function render_options_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="pause-renewal-actions-settings-wrap">
		<h1 id="pause-renewal-actions-settings-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p>Notes:
			<ul>
				<li>This pauses `woocommerce_scheduled_subscription_payment` actions. </li>
				<li>As soon as they are unpaused, any past-due actions will start to run.</li>
				<li>This does not pause any other actions, such as failed payment retries.</li>
			</ul>
		</p>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'pause-renewal-actions' );
			do_settings_sections( 'pause_renewal_actions_options' );
			?>
			<input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
		</form>
	</div>
	<?php
}

/**
 * Adds the action link on plugins page
 *
 * @return array
 */

function add_action_links( $actions ) {
	$links = array(
		'<a href="' . admin_url( 'tools.php?page=pause_renewal_actions_options' ) . '">Toggle</a>',
	);

	return array_merge( $actions, $links );
}

/**
 * Display Warning that Pause Renewal Actions is activated.
 *
 */
function maybe_show_warning() {
	if ( 'on' === get_option( 'pause_renewal_actions_toggle' ) ) {
		echo "\n<div class='notice notice-info'><p>";
		echo '<strong>';
			esc_html_e( 'Renewal actions are currently paused', 'pause-renewal-actions' );
		echo '</strong>';
		echo '</p></div>';
	}
}
