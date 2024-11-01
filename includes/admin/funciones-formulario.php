<?php
global $mezco_sms_settings, $wpml_activo;

//Control de tabulación
$tab = 1;

//WPML
if ( function_exists( 'icl_register_string' ) || !$wpml_activo ) { //Versión anterior a la 3.2
	$mensaje_pedido		= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_pedido', $mezco_sms_settings['mensaje_pedido'] ) : $mezco_sms_settings['mensaje_pedido'];
	$mensaje_recibido	= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_recibido', $mezco_sms_settings['mensaje_recibido'] ) : $mezco_sms_settings['mensaje_recibido'];
	$mensaje_procesando	= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_procesando', $mezco_sms_settings['mensaje_procesando'] ) : $mezco_sms_settings['mensaje_procesando'];
	$mensaje_completado	= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_completado', $mezco_sms_settings['mensaje_completado'] ) : $mezco_sms_settings['mensaje_completado'];
	$mensaje_nota		= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_nota', $mezco_sms_settings['mensaje_nota'] ) : $mezco_sms_settings['mensaje_nota'];
} else if ( $wpml_activo ) { //Versión 3.2 o superior
	$mensaje_pedido		= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_pedido'], 'mezco_sms', 'mensaje_pedido' );
	$mensaje_recibido	= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_recibido'], 'mezco_sms', 'mensaje_recibido' );
	$mensaje_procesando	= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_procesando'], 'mezco_sms', 'mensaje_procesando' );
	$mensaje_completado	= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_completado'], 'mezco_sms', 'mensaje_completado' );
	$mensaje_nota		= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_nota'], 'mezco_sms', 'mensaje_nota' );
}

//Listado de proveedores SMS
$listado_de_proveedores = array( 
	
	"mezcosms" 		=> "Mezco Sms",
	
);
asort( $listado_de_proveedores, SORT_NATURAL | SORT_FLAG_CASE ); //Ordena alfabeticamente los proveedores

//Campos necesarios para cada proveedor
$campos_de_proveedores = array( 
	"bulksms" 			=> array( 
		"usuario_bulksms" 					=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_bulksms" 				=> __( 'password', 'woo-mezco-sms' ),
		"servidor_bulksms"					=> __( 'host', 'woo-mezco-sms' ),
	),
	"clickatell" 		=> array( 
		"identificador_clickatell" 			=> __( 'sender ID', 'woo-mezco-sms' ),
		"usuario_clickatell" 				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_clickatell" 			=> __( 'password', 'woo-mezco-sms' ),
	),
	"clockwork" 		=> array( 
		"identificador_clockwork" 			=> __( 'key', 'woo-mezco-sms' ),
	),
	"esebun" 			=> array( 
		"usuario_esebun" 					=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_esebun" 				=> __( 'password', 'woo-mezco-sms' ),
		"identificador_esebun" 				=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"isms" 				=> array( 
		"usuario_isms" 						=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_isms" 					=> __( 'password', 'woo-mezco-sms' ),
		"telefono_isms" 					=> __( 'mobile number', 'woo-mezco-sms' ),
	),
	"labsmobile"		=> array(
		"identificador_labsmobile"			=> __( 'client', 'woo-mezco-sms' ),
		"usuario_labsmobile"				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_labsmobile"				=> __( 'password', 'woo-mezco-sms' ),
		"sid_labsmobile"					=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"mobtexting"		=> array( 
		"clave_mobtexting"					=> __( 'key', 'woo-mezco-sms' ),
		"identificador_mobtexting"			=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"moplet" 			=> array( 
		"clave_moplet" 						=> __( 'authentication key', 'woo-mezco-sms' ),
		"identificador_moplet" 				=> __( 'sender ID', 'woo-mezco-sms' ),
		"ruta_moplet" 						=> __( 'route', 'woo-mezco-sms' ),
		"servidor_moplet" 					=> __( 'host', 'woo-mezco-sms' ),
	),
	"moreify" 			=> array( 
		"proyecto_moreify"					=> __( 'project', 'woo-mezco-sms' ),
		"identificador_moreify" 			=> __( 'authentication Token', 'woo-mezco-sms' ),
	),
	"msg91" 			=> array( 
		"clave_msg91" 						=> __( 'authentication key', 'woo-mezco-sms' ),
		"identificador_msg91" 				=> __( 'sender ID', 'woo-mezco-sms' ),
		"ruta_msg91" 						=> __( 'route', 'woo-mezco-sms' ),
	),
	"msgwow" 			=> array( 
		"clave_msgwow"						=> __( 'key', 'woo-mezco-sms' ),
		"identificador_msgwow"				=> __( 'sender ID', 'woo-mezco-sms' ),
		"ruta_msgwow" 						=> __( 'route', 'woo-mezco-sms' ),
		"servidor_msgwow"					=> __( 'host', 'woo-mezco-sms' ),
	),
	"mvaayoo" 			=> array( 
		"usuario_mvaayoo" 					=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_mvaayoo" 				=> __( 'password', 'woo-mezco-sms' ),
		"identificador_mvaayoo" 			=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"nexmo" 			=> array( 
		"clave_nexmo"						=> __( 'key', 'woo-mezco-sms' ),
		"identificador_nexmo"				=> __( 'authentication Token', 'woo-mezco-sms' ),
	),
	"open_dnd" 			=> array( 
		"identificador_open_dnd" 			=> __( 'sender ID', 'woo-mezco-sms' ),
		"usuario_open_dnd" 					=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_open_dnd" 				=> __( 'password', 'woo-mezco-sms' ),
	),
	"plivo"				=> array(
		"usuario_plivo"						=> __( 'authentication ID', 'woo-mezco-sms' ),
		"clave_plivo"						=> __( 'authentication Token', 'woo-mezco-sms' ),
		"identificador_plivo"				=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"routee"			=> array( 
		"usuario_routee" 					=> __( 'application ID', 'woo-mezco-sms' ),
		"contrasena_routee"					=> __( 'application secret', 'woo-mezco-sms' ),
		"identificador_routee"				=> __( 'sender ID', 'woo-mezco-sms' ),
	), 
	"sipdiscount"		=> array( 
		"usuario_sipdiscount" 				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_sipdiscount"			=> __( 'password', 'woo-mezco-sms' ),
	), 
	"smscountry" 		=> array( 
		"usuario_smscountry"				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_smscountry" 			=> __( 'password', 'woo-mezco-sms' ),
		"sid_smscountry" 					=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"smsdiscount"		=> array( 
		"usuario_smsdiscount" 				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_smsdiscount"			=> __( 'password', 'woo-mezco-sms' ),
	), 
	"smslane" 			=> array( 
		"usuario_smslane" 					=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_smslane" 				=> __( 'password', 'woo-mezco-sms' ),
		"sid_smslane" 						=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"solutions_infini" 	=> array( 
		"clave_solutions_infini" 			=> __( 'key', 'woo-mezco-sms' ),
		"identificador_solutions_infini" 	=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"mezcosms" 		=> array( 
		"clave_mezcosms" 					=> __( 'key', 'woo-mezco-sms' ),
		"identificador_mezcosms"		 	=> __( 'sender ID', 'woo-mezco-sms' ),
	),
	"twilio" 			=> array( 
		"clave_twilio" 						=> __( 'account Sid', 'woo-mezco-sms' ),
		"identificador_twilio" 				=> __( 'authentication Token', 'woo-mezco-sms' ),
		"telefono_twilio" 					=> __( 'mobile number', 'woo-mezco-sms' ),
	),
	"twizo" 			=> array( 
		"clave_twizo"						=> __( 'key', 'woo-mezco-sms' ),
		"identificador_twizo"				=> __( 'sender ID', 'woo-mezco-sms' ),
		"servidor_twizo"					=> __( 'host', 'woo-mezco-sms' ),
	),
	"voipbuster"		=> array( 
		"usuario_voipbuster" 				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_voipbuster"				=> __( 'password', 'woo-mezco-sms' ),
	), 
	"voipbusterpro"		=> array( 
		"usuario_voipbusterpro"				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_voipbusterpro"			=> __( 'password', 'woo-mezco-sms' ),
	), 
	"voipstunt"			=> array( 
		"usuario_voipstunt" 				=> __( 'username', 'woo-mezco-sms' ),
		"contrasena_voipstunt" 				=> __( 'password', 'woo-mezco-sms' ),
	), 
);

//Opciones de campos de selección de los proveedores
$opciones_de_proveedores = array(
	"servidor_bulksms"	=> array(
		"bulksms.vsms.net"		=> __( 'International', 'woo-mezco-sms' ), 
		"www.bulksms.co.uk"		=> __( 'UK', 'woo-mezco-sms' ),
		"usa.bulksms.com"		=> __( 'USA', 'woo-mezco-sms' ),
		"bulksms.2way.co.za"	=> __( 'South Africa', 'woo-mezco-sms' ),
		"bulksms.com.es"		=> __( 'Spain', 'woo-mezco-sms' ),
	),
	"servidor_moplet"	=> array(
		"0"						=> __( 'International', 'woo-mezco-sms' ), 
		"1"						=> __( 'USA', 'woo-mezco-sms' ), 
		"91"					=> __( 'India', 'woo-mezco-sms' ),
	),	
	"ruta_moplet"		=> array(
		1						=> 1, 
		4						=> 4,
	),
	"ruta_msg91"		=> array(
		"default"				=> __( 'Default', 'woo-mezco-sms' ), 
		1						=> 1, 
		4						=> 4,
	),
	"ruta_msgwow"		=> array(
		1						=> 1, 
		4						=> 4,
	),
	"servidor_msgwow"	=> array(
		"0"						=> __( 'International', 'woo-mezco-sms' ), 
		"1"						=> __( 'USA', 'woo-mezco-sms' ), 
		"91"					=> __( 'India', 'woo-mezco-sms' ), 
	),	
	"servidor_twizo"	=> array(
		"api-asia-01.twizo.com"	=> __( 'Singapore', 'woo-mezco-sms' ), 
		"api-eu-01.twizo.com"	=> __( 'Germany', 'woo-mezco-sms' ), 
	),
);

//Listado de estados de pedidos
$listado_de_estados				= wc_get_order_statuses();
$listado_de_estados_temporal	= array();
$estados_originales				= array( 
	'pending',
	'failed',
	'on-hold',
	'processing',
	'completed',
	'refunded',
	'cancelled',
);
foreach( $listado_de_estados as $clave => $estado ) {
	$nombre_de_estado = str_replace( "wc-", "", $clave );
	if ( !in_array( $nombre_de_estado, $estados_originales ) ) {
		$listado_de_estados_temporal[$estado] = $nombre_de_estado;
	}
}
$listado_de_estados = $listado_de_estados_temporal;

//Listado de mensajes personalizados
$listado_de_mensajes = array(
	'todos'					=> __( 'All messages', 'woo-mezco-sms' ),
	'mensaje_pedido'		=> __( 'Owner custom message', 'woo-mezco-sms' ),
	'mensaje_recibido'		=> __( 'Order on-hold custom message', 'woo-mezco-sms' ),
	'mensaje_procesando'	=> __( 'Order processing custom message', 'woo-mezco-sms' ),
	'mensaje_completado'	=> __( 'Order completed custom message', 'woo-mezco-sms' ),
	'mensaje_nota'			=> __( 'Notes custom message', 'woo-mezco-sms' ),
);

/*
Pinta el campo select con el listado de proveedores
*/
function mezco_sms_listado_de_proveedores( $listado_de_proveedores ) {
	global $mezco_sms_settings;
	
	foreach ( $listado_de_proveedores as $valor => $proveedor ) {
		$chequea = ( isset( $mezco_sms_settings['servicio'] ) && $mezco_sms_settings['servicio'] == $valor ) ? ' selected="selected"' : '';
		echo '<option value="' . $valor . '"' . $chequea . '>' . $proveedor . '</option>' . PHP_EOL;
	}
}

/*
Pinta los campos de los proveedores
*/
function mezco_sms_campos_de_proveedores( $listado_de_proveedores, $campos_de_proveedores, $opciones_de_proveedores ) {
	global $mezco_sms_settings, $tab;
	
	foreach ( $listado_de_proveedores as $valor => $proveedor ) {
		foreach ( $campos_de_proveedores[$valor] as $valor_campo => $campo ) {
			if ( array_key_exists( $valor_campo, $opciones_de_proveedores ) ) { //Campo select
				echo '
  <tr valign="top" class="' . $valor . '"><!-- ' . $proveedor . ' -->
	<th scope="row" class="titledesc"> <label for="mezco_sms_settings[' . $valor_campo . ']">' .ucfirst( $campo ) . ':' . '
	  <span class="woocommerce-help-tip" data-tip="' . sprintf( __( 'The %s for your account in %s', 'woo-mezco-sms' ), $campo, $proveedor ) . '"></span></label></th>
	<td class="forminp forminp-number"><select class="wc-enhanced-select" id="mezco_sms_settings[' . $valor_campo . ']" name="mezco_sms_settings[' . $valor_campo . ']" tabindex="' . $tab++ . '">
				';
				foreach ( $opciones_de_proveedores[$valor_campo] as $valor_opcion => $opcion ) {
					$chequea = ( isset( $mezco_sms_settings[$valor_campo] ) && $mezco_sms_settings[$valor_campo] == $valor_opcion ) ? ' selected="selected"' : '';
					echo '<option value="' . $valor_opcion . '"' . $chequea . '>' . $opcion . '</option>' . PHP_EOL;
				}
				echo '          </select></td>
  </tr>
				';
			} else { //Campo input
				echo '
  <tr valign="top" class="' . $valor . '"><!-- ' . $proveedor . ' -->
	<th scope="row" class="titledesc"> <label for="mezco_sms_settings[' . $valor_campo . ']">' . ucfirst( $campo ) . ':' . '
	  <span class="woocommerce-help-tip" data-tip="' . sprintf( __( 'The %s for your account in %s', 'woo-mezco-sms' ), $campo, $proveedor ) . '"></span></label></th>
	<td class="forminp forminp-number"><input type="text" id="mezco_sms_settings[' . $valor_campo . ']" name="mezco_sms_settings[' . $valor_campo . ']" size="50" value="' . ( isset( $mezco_sms_settings[$valor_campo] ) ? $mezco_sms_settings[$valor_campo] : '' ) . '" tabindex="' . $tab++ . '" /></td>
  </tr>
				';
			}
		}
	}
}

/*
Pinta los campos del formulario de envío
*/
function mezco_sms_campos_de_envio() {
	global $mezco_sms_settings;

	$pais					= new WC_Countries();
	$campos					= $pais->get_address_fields( $pais->get_base_country(), 'shipping_' ); //Campos ordinarios
	$campos_personalizados	= apply_filters( 'woocommerce_checkout_fields', array() );
	if ( isset( $campos_personalizados['shipping'] ) ) {
		$campos += $campos_personalizados['shipping'];
	}
	foreach ( $campos as $valor => $campo ) {
		$chequea = ( isset( $mezco_sms_settings['campo_envio'] ) && $mezco_sms_settings['campo_envio'] == $valor ) ? ' selected="selected"' : '';
		if ( isset( $campo['label'] ) ) {
			echo '<option value="' . $valor . '"' . $chequea . '>' . $campo['label'] . '</option>' . PHP_EOL;
		}
	}
}

/*
Pinta el campo select con el listado de estados de pedido
*/
function mezco_sms_listado_de_estados( $listado_de_estados ) {
	global $mezco_sms_settings;

	foreach( $listado_de_estados as $nombre_de_estado => $estado ) {
		$chequea = '';
		if ( isset( $mezco_sms_settings['estados_personalizados'] ) ) {
			foreach ( $mezco_sms_settings['estados_personalizados'] as $estado_personalizado ) {
				if ( $estado_personalizado == $estado ) {
					$chequea = ' selected="selected"';
				}
			}
		}
		echo '<option value="' . $estado . '"' . $chequea . '>' . $nombre_de_estado . '</option>' . PHP_EOL;
	}
}

/*
Pinta el campo select con el listado de mensajes personalizados
*/
function mezco_sms_listado_de_mensajes( $listado_de_mensajes ) {
	global $mezco_sms_settings;
	
	$chequeado = false;
	foreach ( $listado_de_mensajes as $valor => $mensaje ) {
		if ( isset( $mezco_sms_settings['mensajes'] ) && in_array( $valor, $mezco_sms_settings['mensajes'] ) ) {
			$chequea	= ' selected="selected"';
			$chequeado	= true;
		} else {
			$chequea	= '';
		}
		$texto = ( !isset( $mezco_sms_settings['mensajes'] ) && $valor == 'todos' && !$chequeado ) ? ' selected="selected"' : '';
		echo '<option value="' . $valor . '"' . $chequea . $texto . '>' . $mensaje . '</option>' . PHP_EOL;
	}
}
