<?php
//Definimos las variables
$mezco_sms = array( 	
	'plugin' 		=> 'Wocommerce - Mezco SMS', 
	'plugin_uri' 	=> 'woo-mezco-sms', 
	'donacion' 		=> 'https://sms.adensoft.net/donacion',
	'soporte' 		=> 'https://sms.adensoft.net/ticket-de-soporte',
	'plugin_url' 	=> 'https://sms.adensoft.net/woocommerce', 
	'ajustes' 		=> 'admin.php?page=mezco_sms', 
	'puntuacion' 	=> 'https://wordpress.org/support/view/plugin-reviews/woo-mezco-sms' 
);

//Carga el idioma
load_plugin_textdomain( 'woo-mezco-sms', null, dirname( DIRECCION_mezco_sms ) . '/languages' );

//Carga la configuración del plugin
$mezco_sms_settings = get_option( 'mezco_sms_settings' );

//Enlaces adicionales personalizados
function mezco_sms_enlaces( $enlaces, $archivo ) {
	global $mezco_sms;

	if ( $archivo == DIRECCION_mezco_sms ) {
		$enlaces[] = '<a href="' . $mezco_sms['donacion'] . '" target="_blank" title="' . __( 'Make a donation by ', 'woo-mezco-sms' ) . 'MEZCO"><span class="genericon genericon-cart"></span></a>';
		$enlaces[] = '<a href="'. $mezco_sms['plugin_url'] . '" target="_blank" title="' . $mezco_sms['plugin'] . '"><strong class="adensoft">MEZCO</strong></a>';
		$enlaces[] = '<a href="https://www.facebook.com/adensoft" title="' . __( 'Follow us on ', 'woo-mezco-sms' ) . 'Facebook" target="_blank"><span class="genericon genericon-facebook-alt"></span></a> <a href="https://twitter.com/adensoft" title="' . __( 'Follow us on ', 'woo-mezco-sms' ) . 'Twitter" target="_blank"><span class="genericon genericon-twitter"></span></a> <a href="https://plus.google.com/+adensoft" title="' . __( 'Follow us on ', 'woo-mezco-sms' ) . 'Google+" target="_blank"><span class="genericon genericon-googleplus-alt"></span></a> <a href="https://es.linkedin.com/in/adensoft" title="' . __( 'Follow us on ', 'woo-mezco-sms' ) . 'LinkedIn" target="_blank"><span class="genericon genericon-linkedin"></span></a>';
		$enlaces[] = '<a href="https://profiles.wordpress.org/adensoft/" title="' . __( 'More plugins on ', 'woo-mezco-sms' ) . 'WordPress" target="_blank"><span class="genericon genericon-wordpress"></span></a>';
		$enlaces[] = '<a href="info@adensoft.net" title="' . __( 'Contact with us by ', 'woo-mezco-sms' ) . 'e-mail"><span class="genericon genericon-mail"></span></a> <a href="skype:adensoft" title="' . __( 'Contact with us by ', 'woo-mezco-sms' ) . 'Skype"><span class="genericon genericon-skype"></span></a>';
		$enlaces[] = mezco_sms_plugin( $mezco_sms['plugin_uri'] );
	}

	return $enlaces;
}
add_filter( 'plugin_row_meta', 'mezco_sms_enlaces', 10, 2 );

//Añade el botón de configuración
function mezco_sms_enlace_de_ajustes( $enlaces ) { 
	global $mezco_sms;

	$enlaces_de_ajustes = array( 
		'<a href="' . $mezco_sms['ajustes'] . '" title="' . __( 'Settings of ', 'woo-mezco-sms' ) . $mezco_sms['plugin'] .'">' . __( 'Settings', 'woo-mezco-sms' ) . '</a>', 
		'<a href="' . $mezco_sms['soporte'] . '" title="' . __( 'Support of ', 'woo-mezco-sms' ) . $mezco_sms['plugin'] .'">' . __( 'Support', 'woo-mezco-sms' ) . '</a>' 
	);
	foreach( $enlaces_de_ajustes as $enlace_de_ajustes )	{
		array_unshift( $enlaces, $enlace_de_ajustes );
	}

	return $enlaces; 
}
$plugin = DIRECCION_mezco_sms; 
add_filter( "plugin_action_links_$plugin", 'mezco_sms_enlace_de_ajustes' );

//Obtiene toda la información sobre el plugin
function mezco_sms_plugin( $nombre ) {
	global $mezco_sms;
	
	$argumentos	= ( object ) array( 
		'slug'		=> $nombre 
	);
	$consulta	= array( 
		'action'	=> 'plugin_information', 
		'timeout'	=> 15, 
		'request'	=> serialize( $argumentos )
	);
	$respuesta	= get_transient( 'mezco_sms_plugin' );
	if ( false === $respuesta ) {
		$respuesta = wp_remote_post( 'https://api.wordpress.org/plugins/info/1.0/', array( 
			'body'	=> $consulta
		) );
		set_transient( 'mezco_sms_plugin', $respuesta, 24 * HOUR_IN_SECONDS );
	}
	if ( !is_wp_error( $respuesta ) ) {
		$plugin = get_object_vars( unserialize( $respuesta['body'] ) );
	} else {
		$plugin['rating'] = 100;
	}

	$rating = array(
	   'rating'		=> $plugin['rating'],
	   'type'		=> 'percent',
	   'number'		=> $plugin['num_ratings'],
	);
	ob_start();
	wp_star_rating( $rating );
	$estrellas = ob_get_contents();
	ob_end_clean();

	return '<a title="' . sprintf( __( 'Please, rate %s:', 'woo-mezco-sms' ), $mezco_sms['plugin'] ) . '" href="' . $mezco_sms['puntuacion'] . '?rate=5#postform" class="estrellas">' . $estrellas . '</a>';
}

//Hoja de estilo
function mezco_sms_estilo() {
	wp_register_style( 'mezco_sms_hoja_de_estilo', plugins_url( 'assets/css/style.css', DIRECCION_mezco_sms ) );
	wp_enqueue_style( 'mezco_sms_hoja_de_estilo'  ); //Carga la hoja de estilo
	wp_style_add_data( 'mezco_sms_hoja_de_estilo', 'rtl', 'replace' );

}
add_action( 'admin_enqueue_scripts', 'mezco_sms_estilo' );

//Eliminamos todo rastro del plugin al desinstalarlo
function mezco_sms_desinstalar() {
	delete_option( 'mezco_sms_settings' );
	delete_transient( 'mezco_sms_plugin' );
}
register_uninstall_hook( __FILE__, 'mezco_sms_desinstalar' );
