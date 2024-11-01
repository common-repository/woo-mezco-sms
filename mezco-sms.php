<?php
/*
Plugin Name: Wocommerce - Mezco SMS
Version: 1.0.1
Plugin URI: https://wordpress.org/plugins/woo-mezco-sms/
Description: Add to WooCommerce SMS notifications to your clients for order status changes. Also you can receive an SMS message when the shop get a new order and select if you want to send international SMS. The plugin add the international dial code automatically to the client phone number.
Author URI: https://adensoft.net/
Author: AdenSoft Developers
Requires at least: 3.8
Tested up to: 5.2
WC requires at least: 2.1
WC tested up to: 3.6

Text Domain: woo-mezco-sms
Domain Path: /languages

@package Wocommerce - Mezco SMS
@category Core
@author AdenSoft Developers
*/

//Igual no deberías poder abrirme
defined( 'ABSPATH' ) || exit;

//Definimos constantes
define( 'DIRECCION_mezco_sms', plugin_basename( __FILE__ ) );

//Funciones generales de MEZCO
include_once( 'includes/admin/funciones-mezco.php' );

//¿Está activo WooCommerce?
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_network_only_plugin( 'woocommerce/woocommerce.php' ) ) {
	//Cargamos funciones necesarias
	include_once( 'includes/admin/funciones.php' );

	//Comprobamos si está instalado y activo WPML
	$wpml_activo = function_exists( 'icl_object_id' );
	
	//Actualiza las traducciones de los mensajes SMS
	function mezco_registra_wpml( $mezco_sms_settings ) {
		global $wpml_activo;
		
		//Registramos los textos en WPML
		if ( $wpml_activo && function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'mezco_sms', 'mensaje_pedido', $mezco_sms_settings['mensaje_pedido'] );
			icl_register_string( 'mezco_sms', 'mensaje_recibido', $mezco_sms_settings['mensaje_recibido'] );
			icl_register_string( 'mezco_sms', 'mensaje_procesando', $mezco_sms_settings['mensaje_procesando'] );
			icl_register_string( 'mezco_sms', 'mensaje_completado', $mezco_sms_settings['mensaje_completado'] );
			icl_register_string( 'mezco_sms', 'mensaje_nota', $mezco_sms_settings['mensaje_nota'] );
		} else if ( $wpml_activo ) {
			do_action( 'wpml_register_single_string', 'mezco_sms', 'mensaje_pedido', $mezco_sms_settings['mensaje_pedido'] );
			do_action( 'wpml_register_single_string', 'mezco_sms', 'mensaje_recibido', $mezco_sms_settings['mensaje_recibido'] );
			do_action( 'wpml_register_single_string', 'mezco_sms', 'mensaje_procesando', $mezco_sms_settings['mensaje_procesando'] );
			do_action( 'wpml_register_single_string', 'mezco_sms', 'mensaje_completado', $mezco_sms_settings['mensaje_completado'] );
			do_action( 'wpml_register_single_string', 'mezco_sms', 'mensaje_nota', $mezco_sms_settings['mensaje_nota'] );
		}
	}
	
	//Inicializamos las traducciones y los proveedores
	function mezco_sms_inicializacion() {
		global $mezco_sms_settings;

		mezco_registra_wpml( $mezco_sms_settings );
	}
	add_action( 'init', 'mezco_sms_inicializacion' );

	//Pinta el formulario de configuración
	function mezco_sms_tab() {
		include( 'includes/admin/funciones-formulario.php' );
		include( 'includes/formulario.php' );
	}

	//Añade en el menú a WooCommerce
	function mezco_sms_admin_menu() {
		add_submenu_page( 'woocommerce', __( 'Mezco SMS Notifications', 'woo-mezco-sms' ),  __( 'SMS Notifications', 'woo-mezco-sms' ) , 'manage_woocommerce', 'mezco_sms', 'mezco_sms_tab' );
	}
	add_action( 'admin_menu', 'mezco_sms_admin_menu', 15 );

	//Carga los scripts y CSS de WooCommerce
	function mezco_sms_screen_id( $woocommerce_screen_ids ) {
		$woocommerce_screen_ids[] = 'woocommerce_page_mezco_sms';

		return $woocommerce_screen_ids;
	}
	add_filter( 'woocommerce_screen_ids', 'mezco_sms_screen_id' );

	//Registra las opciones
	function mezco_sms_registra_opciones() {
		global $mezco_sms_settings;
	
		register_setting( 'mezco_sms_settings_group', 'mezco_sms_settings', 'mezco_sms_update' );
		$mezco_sms_settings = get_option( 'mezco_sms_settings' );

		if ( isset( $mezco_sms_settings['estados_personalizados'] ) && !empty( $mezco_sms_settings['estados_personalizados'] ) ) { //Comprueba la existencia de estados personalizados
			foreach ( $mezco_sms_settings['estados_personalizados'] as $estado ) {
				add_action( "woocommerce_order_status_{$estado}", 'mezco_sms_procesa_estados', 10 );
			}
		}
	}
	add_action( 'admin_init', 'mezco_sms_registra_opciones' );
	
	function mezco_sms_update( $mezco_sms_settings ) {
		mezco_registra_wpml( $mezco_sms_settings );
		
		return $mezco_sms_settings;
	}

	//Procesa el SMS
	function mezco_sms_procesa_estados( $pedido, $notificacion = false ) {
		global $mezco_sms_settings, $wpml_activo;
		
		$numero_de_pedido	= $pedido;
		$pedido				= new WC_Order( $numero_de_pedido );
		$estado				= is_callable( array( $pedido, 'get_status' ) ) ? $pedido->get_status() : $pedido->status;

		//Comprobamos si se tiene que enviar el mensaje o no
		if ( isset( $mezco_sms_settings['mensajes'] ) ) {
			if ( $estado == 'on-hold' && !array_intersect( array( "todos", "mensaje_pedido", "mensaje_recibido" ), $mezco_sms_settings['mensajes'] ) ) {
				return;
			} else if ( $estado == 'processing' && !array_intersect( array( "todos", "mensaje_pedido", "mensaje_procesando" ), $mezco_sms_settings['mensajes'] ) ) {
				return;
			} else if ( $estado == 'completed' && !array_intersect( array( "todos", "mensaje_completado" ), $mezco_sms_settings['mensajes'] ) ) {
				return;
			}
		} else {
			return;
		}
		//Permitir que otros plugins impidan que se envíe el SMS
		if ( !apply_filters( 'mezco_sms_send_message', true, $pedido ) ) {
			return;
		}

		//Recoge datos del formulario de facturación
		$billing_country		= is_callable( array( $pedido, 'get_billing_country' ) ) ? $pedido->get_billing_country() : $pedido->billing_country;
		$billing_phone			= is_callable( array( $pedido, 'get_billing_phone' ) ) ? $pedido->get_billing_phone() : $pedido->billing_phone;
		$shipping_country		= is_callable( array( $pedido, 'get_shipping_country' ) ) ? $pedido->get_shipping_country() : $pedido->shipping_country;
		$campo_envio			= get_post_meta( $numero_de_pedido, $mezco_sms_settings['campo_envio'], false );
		$campo_envio			= ( isset( $campo_envio[0] ) ) ? $campo_envio[0] : '';
		$telefono				= mezco_sms_procesa_el_telefono( $pedido, $billing_phone, $mezco_sms_settings['servicio'] );
		$telefono_envio			= mezco_sms_procesa_el_telefono( $pedido, $campo_envio, $mezco_sms_settings['servicio'], false, true );
		$enviar_envio			= ( $telefono != $telefono_envio && isset( $mezco_sms_settings['envio'] ) && $mezco_sms_settings['envio'] == 1 ) ? true : false;
		$internacional			= ( $billing_country && ( WC()->countries->get_base_country() != $billing_country ) ) ? true : false;
		$internacional_envio	= ( $shipping_country && ( WC()->countries->get_base_country() != $shipping_country ) ) ? true : false;
		//Teléfono propietario
		if ( strpos( $mezco_sms_settings['telefono'], "|" ) ) {
			$administradores = explode( "|", $mezco_sms_settings['telefono'] ); //Existe más de uno
		}
		if ( isset( $administradores ) ) {
			foreach( $administradores as $administrador ) {
				$telefono_propietario[]	= mezco_sms_procesa_el_telefono( $pedido, $administrador, $mezco_sms_settings['servicio'], true );
			}
		} else {
			$telefono_propietario = mezco_sms_procesa_el_telefono( $pedido, $mezco_sms_settings['telefono'], $mezco_sms_settings['servicio'], true );	
		}
		
		//WPML
		if ( function_exists( 'icl_register_string' ) || !$wpml_activo ) { //Versión anterior a la 3.2
			$mensaje_pedido		= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_pedido', $mezco_sms_settings['mensaje_pedido'] ) : $mezco_sms_settings['mensaje_pedido'];
			$mensaje_recibido	= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_recibido', $mezco_sms_settings['mensaje_recibido'] ) : $mezco_sms_settings['mensaje_recibido'];
			$mensaje_procesando	= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_procesando', $mezco_sms_settings['mensaje_procesando'] ) : $mezco_sms_settings['mensaje_procesando'];
			$mensaje_completado	= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_completado', $mezco_sms_settings['mensaje_completado'] ) : $mezco_sms_settings['mensaje_completado'];
		} else if ( $wpml_activo ) { //Versión 3.2 o superior
			$mensaje_pedido		= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_pedido'], 'mezco_sms', 'mensaje_pedido' );
			$mensaje_recibido	= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_recibido'], 'mezco_sms', 'mensaje_recibido' );
			$mensaje_procesando	= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_procesando'], 'mezco_sms', 'mensaje_procesando' );
			$mensaje_completado	= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_completado'], 'mezco_sms', 'mensaje_completado' );
		}
		
		//Cargamos los proveedores SMS
		include_once( 'includes/admin/proveedores.php' );
		//Envía el SMS
		switch( $estado ) {
			case 'on-hold': //Pedido en espera
				if ( !!array_intersect( array( "todos", "mensaje_pedido" ), $mezco_sms_settings['mensajes'] ) && isset( $mezco_sms_settings['notificacion'] ) && $mezco_sms_settings['notificacion'] == 1 && !$notificacion ) {
					if ( !is_array( $telefono_propietario ) ) {
						mezco_sms_envia_sms( $mezco_sms_settings, $telefono_propietario, mezco_sms_procesa_variables( $mensaje_pedido, $pedido, $mezco_sms_settings['variables'] ) ); //Mensaje para el propietario
					} else {
						foreach( $telefono_propietario as $administrador ) {
							mezco_sms_envia_sms( $mezco_sms_settings, $administrador, mezco_sms_procesa_variables( $mensaje_pedido, $pedido, $mezco_sms_settings['variables'] ) ); //Mensaje para los propietarios
						}
					}
				}
						
				if ( !!array_intersect( array( "todos", "mensaje_recibido" ), $mezco_sms_settings['mensajes'] ) ) {
					//Limpia el temporizador para pedidos recibidos
					wp_clear_scheduled_hook( 'mezco_sms_ejecuta_el_temporizador' );

					$mensaje = mezco_sms_procesa_variables( $mensaje_recibido, $pedido, $mezco_sms_settings['variables'] ); //Mensaje para el cliente

					//Temporizador para pedidos recibidos
					if ( isset( $mezco_sms_settings['temporizador'] ) && $mezco_sms_settings['temporizador'] > 0 ) {
						wp_schedule_single_event( time() + ( absint( $mezco_sms_settings['temporizador'] ) * 60 * 60 ), 'mezco_sms_ejecuta_el_temporizador' );
					}
				}
				break;
			case 'processing': //Pedido procesando
				if ( !!array_intersect( array( "todos", "mensaje_pedido" ), $mezco_sms_settings['mensajes'] ) && isset( $mezco_sms_settings['notificacion'] ) && $mezco_sms_settings['notificacion'] == 1 && $notificacion ) {
					if ( !is_array( $telefono_propietario ) ) {
						mezco_sms_envia_sms( $mezco_sms_settings, $telefono_propietario, mezco_sms_procesa_variables( $mensaje_pedido, $pedido, $mezco_sms_settings['variables'] ) ); //Mensaje para el propietario
					} else {
						foreach( $telefono_propietario as $administrador ) {
							mezco_sms_envia_sms( $mezco_sms_settings, $administrador, mezco_sms_procesa_variables( $mensaje_pedido, $pedido, $mezco_sms_settings['variables'] ) ); //Mensaje para los propietarios
						}
					}
				}
				if ( !!array_intersect( array( "todos", "mensaje_procesando" ), $mezco_sms_settings['mensajes'] ) ) {
					$mensaje = mezco_sms_procesa_variables( $mensaje_procesando, $pedido, $mezco_sms_settings['variables'] );
				}
				break;
			case 'completed': //Pedido completado
				if ( !!array_intersect( array( "todos", "mensaje_completado" ), $mezco_sms_settings['mensajes'] ) ) {
					$mensaje = mezco_sms_procesa_variables( $mensaje_completado, $pedido, $mezco_sms_settings['variables'] );
				}
				break;
			default: //Pedido con estado personalizado
				$mensaje = mezco_sms_procesa_variables( $mezco_sms_settings[$estado], $pedido, $mezco_sms_settings['variables'] );
		}

		if ( isset( $mensaje ) && ( !$internacional || ( isset( $mezco_sms_settings['internacional'] ) && $mezco_sms_settings['internacional'] == 1 ) ) && !$notificacion ) {
			if ( !is_array( $telefono ) ) {
				mezco_sms_envia_sms( $mezco_sms_settings, $telefono, $mensaje ); //Mensaje para el teléfono de facturación
			} else {
				foreach( $telefono as $cliente ) {
					mezco_sms_envia_sms( $mezco_sms_settings, $cliente, $mensaje ); //Mensaje para los teléfonos recibidos
				}
			}
			if ( $enviar_envio ) {
				mezco_sms_envia_sms( $mezco_sms_settings, $telefono_envio, $mensaje ); //Mensaje para el teléfono de envío
			}
		}
	}
	add_action( 'woocommerce_order_status_pending_to_on-hold_notification', 'mezco_sms_procesa_estados', 10 ); //Funciona cuando el pedido es marcado como recibido
	add_action( 'woocommerce_order_status_failed_to_on-hold_notification', 'mezco_sms_procesa_estados', 10 );
	add_action( 'woocommerce_order_status_processing', 'mezco_sms_procesa_estados', 10 ); //Funciona cuando el pedido es marcado como procesando
	add_action( 'woocommerce_order_status_completed', 'mezco_sms_procesa_estados', 10 ); //Funciona cuando el pedido es marcado como completo

	function mezco_sms_notificacion( $pedido ) {
		mezco_sms_procesa_estados( $pedido, true );
	}
	add_action( 'woocommerce_order_status_pending_to_processing_notification', 'mezco_sms_notificacion', 10 ); //Funciona cuando el pedido es marcado directamente como procesando
	
	//Temporizador
	function mezco_sms_temporizador() {
		global $mezco_sms_settings;
		
		$pedidos = wc_get_orders( array(
			'limit'			=> -1,
			'date_created'	=> '<' . ( time() - ( absint( $mezco_sms_settings['temporizador'] ) * 60 * 60 ) - 1 ),
			'status'		=> 'on-hold',
		) );

		if ( $pedidos ) {
			foreach ( $pedidos as $pedido ) {
				mezco_sms_procesa_estados( is_callable( array( $pedido, 'get_id' ) ) ? $pedido->get_id() : $pedido->id, false );
			}
		}
	}
	add_action( 'mezco_sms_ejecuta_el_temporizador', 'mezco_sms_temporizador' );

	//Envía las notas de cliente por SMS
	function mezco_sms_procesa_notas( $datos ) {
		global $mezco_sms_settings, $wpml_activo;
		
		//Comprobamos si se tiene que enviar el mensaje
		if ( isset( $mezco_sms_settings['mensajes']) && !array_intersect( array( "todos", "mensaje_nota" ), $mezco_sms_settings['mensajes'] ) ) {
			return;
		}
	
		//Pedido
		$numero_de_pedido		= $datos['order_id'];
		$pedido					= new WC_Order( $numero_de_pedido );
		//Recoge datos del formulario de facturación
		$billing_country		= is_callable( array( $pedido, 'get_billing_country' ) ) ? $pedido->get_billing_country() : $pedido->billing_country;
		$billing_phone			= is_callable( array( $pedido, 'get_billing_phone' ) ) ? $pedido->get_billing_phone() : $pedido->billing_phone;
		$shipping_country		= is_callable( array( $pedido, 'get_shipping_country' ) ) ? $pedido->get_shipping_country() : $pedido->shipping_country;	
		$campo_envio			= get_post_meta( $numero_de_pedido, $mezco_sms_settings['campo_envio'], false );
		$campo_envio			= ( isset( $campo_envio[0] ) ) ? $campo_envio[0] : '';
		$telefono				= mezco_sms_procesa_el_telefono( $pedido, $billing_phone, $mezco_sms_settings['servicio'] );
		$telefono_envio			= mezco_sms_procesa_el_telefono( $pedido, $campo_envio, $mezco_sms_settings['servicio'], false, true );
		$enviar_envio			= ( isset( $mezco_sms_settings['envio'] ) && $telefono != $telefono_envio && $mezco_sms_settings['envio'] == 1 ) ? true : false;
		$internacional			= ( $billing_country && ( WC()->countries->get_base_country() != $billing_country ) ) ? true : false;
		$internacional_envio	= ( $shipping_country && ( WC()->countries->get_base_country() != $shipping_country ) ) ? true : false;
		//Recoge datos del formulario de facturación
		$billing_country		= is_callable( array( $pedido, 'get_billing_country' ) ) ? $pedido->get_billing_country() : $pedido->billing_country;
		$billing_phone			= is_callable( array( $pedido, 'get_billing_phone' ) ) ? $pedido->get_billing_phone() : $pedido->billing_phone;
		$shipping_country		= is_callable( array( $pedido, 'get_shipping_country' ) ) ? $pedido->get_shipping_country() : $pedido->shipping_country;
		$campo_envio			= get_post_meta( $numero_de_pedido, $mezco_sms_settings['campo_envio'], false );
		$campo_envio			= ( isset( $campo_envio[0] ) ) ? $campo_envio[0] : '';
		$telefono				= mezco_sms_procesa_el_telefono( $pedido, $billing_phone, $mezco_sms_settings['servicio'] );
		$telefono_envio			= mezco_sms_procesa_el_telefono( $pedido, $campo_envio, $mezco_sms_settings['servicio'], false, true );
		$enviar_envio			= ( $telefono != $telefono_envio && isset( $mezco_sms_settings['envio'] ) && $mezco_sms_settings['envio'] == 1 ) ? true : false;
		$internacional			= ( $billing_country && ( WC()->countries->get_base_country() != $billing_country ) ) ? true : false;
		$internacional_envio	= ( $shipping_country && ( WC()->countries->get_base_country() != $shipping_country ) ) ? true : false;

		//WPML
		if ( function_exists( 'icl_register_string' ) || !$wpml_activo ) { //Versión anterior a la 3.2
			$mensaje_nota		= ( $wpml_activo ) ? icl_translate( 'mezco_sms', 'mensaje_nota', $mezco_sms_settings['mensaje_nota'] ) : $mezco_sms_settings['mensaje_nota'];
		} else if ( $wpml_activo ) { //Versión 3.2 o superior
			$mensaje_nota		= apply_filters( 'wpml_translate_single_string', $mezco_sms_settings['mensaje_nota'], 'mezco_sms', 'mensaje_nota' );
		}
		
		//Cargamos los proveedores SMS
		include_once( 'includes/admin/proveedores.php' );		
		//Envía el SMS
		if ( !$internacional || ( isset( $mezco_sms_settings['internacional'] ) && $mezco_sms_settings['internacional'] == 1 ) ) {
			if ( !is_array( $telefono ) ) {
				mezco_sms_envia_sms( $mezco_sms_settings, $telefono, mezco_sms_procesa_variables( $mensaje_nota, $pedido, $mezco_sms_settings['variables'], wptexturize( $datos['customer_note'] ) ) ); //Mensaje para el teléfono de facturación
			} else {
				foreach( $telefono as $cliente ) {
					mezco_sms_envia_sms( $mezco_sms_settings, $cliente, mezco_sms_procesa_variables( $mensaje_nota, $pedido, $mezco_sms_settings['variables'], wptexturize( $datos['customer_note'] ) ) ); //Mensaje para los teléfonos recibidos
				}
			}
			if ( $enviar_envio ) {
				mezco_sms_envia_sms( $mezco_sms_settings, $telefono_envio, mezco_sms_procesa_variables( $mensaje_nota, $pedido, $mezco_sms_settings['variables'], wptexturize( $datos['customer_note'] ) ) ); //Mensaje para el teléfono de envío
			}
		}
	}
	add_action( 'woocommerce_new_customer_note', 'mezco_sms_procesa_notas', 10 );
} else {
	add_action( 'admin_notices', 'mezco_sms_requiere_wc' );
}

//Muestra el mensaje de activación de WooCommerce y desactiva el plugin
function mezco_sms_requiere_wc() {
	global $mezco_sms;
		
	echo '<div class="error fade" id="message"><h3>' . $mezco_sms['plugin'] . '</h3><h4>' . __( "This plugin require WooCommerce active to run!", 'woo-mezco-sms' ) . '</h4></div>';
	deactivate_plugins( DIRECCION_mezco_sms );
}
