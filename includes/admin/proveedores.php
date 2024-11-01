<?php
//Envía el mensaje SMS
function mezco_sms_envia_sms( $mezco_sms_settings, $telefono, $mensaje ) {
	switch ( $mezco_sms_settings['servicio'] ) {
		case "bulksms":
			$argumentos['body'] = array( 
				'username' 					=> $mezco_sms_settings['usuario_bulksms'],
				'password' 					=> $mezco_sms_settings['contrasena_bulksms'],
				'message' 					=> $mensaje,
				'msisdn' 					=> $telefono,
				'allow_concat_text_sms'		=> '1',
                'concat_text_sms_max_parts'	=> '6',
			 );
			$respuesta = wp_remote_post( "http://" . $mezco_sms_settings['servidor_bulksms'] . "/eapi/submission/send_sms/2/2.0", $argumentos );
			break;
		case "clickatell":
			$respuesta = wp_remote_get( "https://api.clickatell.com/http/sendmsg?api_id=" . $mezco_sms_settings['identificador_clickatell'] . "&user=" . $mezco_sms_settings['usuario_clickatell'] . "&password=" . $mezco_sms_settings['contrasena_clickatell'] . "&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "clockwork":
			$respuesta = wp_remote_get( "https://api.clockworksms.com/http/send.aspx?key=" . $mezco_sms_settings['identificador_clockwork'] . "&to=" . $telefono . "&content=" . mezco_sms_normaliza_mensaje( $mensaje ) );
			break;
		case "esebun":
			$respuesta = wp_remote_get( "http://api.cloud.bz.esebun.com/api/v3/sendsms/plain?user=" . $mezco_sms_settings['usuario_esebun'] . "&password=" . $mezco_sms_settings['contrasena_esebun'] . "&sender=" . mezco_sms_codifica_el_mensaje( $mezco_sms_settings['identificador_esebun'] ) . "&SMSText=" . mezco_sms_codifica_el_mensaje( $mensaje ) . "&GSM=" . preg_replace( '/\+/', '', $telefono ) );
			break;
		case "isms":
			$respuesta = wp_remote_get( "https://www.isms.com.my/isms_send.php?un=" . $mezco_sms_settings['usuario_isms'] . "&pwd=" . $mezco_sms_settings['contrasena_isms'] . "&dstno=" . $telefono . "&msg=" . mezco_sms_codifica_el_mensaje( $mensaje ) . "&type=2" . "&sendid=" . $mezco_sms_settings['telefono_isms'] );
			break;
		case "labsmobile":
			$respuesta = wp_remote_get( "https://api.labsmobile.com/get/send.php?client=" . $mezco_sms_settings['identificador_labsmobile'] . "&username=" . $mezco_sms_settings['usuario_labsmobile'] . "&password=" . $mezco_sms_settings['contrasena_labsmobile'] . "&msisdn=" . $telefono . "&message=" . mezco_sms_codifica_el_mensaje( mezco_sms_normaliza_mensaje( $mensaje ) ) . "&sender=" . $mezco_sms_settings['sid_labsmobile'] );
			break;			
		case "mobtexting":
			$respuesta = wp_remote_get( "http://portal.mobtexting.com/api/v2/sms/send?access_token=" . $mezco_sms_settings['clave_mobtexting'] . "&to=" . $telefono . "&service=T&sender=" . $mezco_sms_settings['identificador_mobtexting'] . "&message=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "moplet":
			$respuesta = wp_remote_get( "http://sms.moplet.com/api/sendhttp.php?authkey=" . $mezco_sms_settings['clave_moplet'] . "&mobiles=" . $telefono . "&message=" . mezco_sms_codifica_el_mensaje( $mensaje ) . "&sender=" . $mezco_sms_settings['identificador_moplet'] . "&route=" . $mezco_sms_settings['ruta_moplet'] . "&country=" . $mezco_sms_settings['servidor_moplet'] );
			break;
		case "moreify":
			$respuesta = wp_remote_get( "https://members.moreify.com/api/v1/sendSms?project=" . $mezco_sms_settings['proyecto_moreify'] . "&password=" . $mezco_sms_settings['identificador_moreify'] . "&phonenumber=" . $telefono . "&message=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "msg91":
			$argumentos['body'] = array( 
				'authkey' 	=> $mezco_sms_settings['clave_msg91'],
				'mobiles' 	=> $telefono,
				'message' 	=> mezco_sms_codifica_el_mensaje( mezco_sms_normaliza_mensaje( $mensaje ) ),
				'sender' 	=> $mezco_sms_settings['identificador_msg91'],
				'route' 	=> $mezco_sms_settings['ruta_msg91']
			 );
			$respuesta = wp_remote_post( "http://control.msg91.com/sendhttp.php", $argumentos );
			break;
		case "msgwow":
			$respuesta = wp_remote_get( "http://my.msgwow.com/api/sendhttp.php?authkey=" . $mezco_sms_settings['clave_msgwow'] . "&mobiles=" . $telefono . "&message=" . mezco_sms_codifica_el_mensaje( $mensaje ) . "&sender=" . $mezco_sms_settings['identificador_msgwow'] . "&route=" . $mezco_sms_settings['ruta_msgwow'] . "&country=" . $mezco_sms_settings['servidor_msgwow'] );
			//$respuesta = wp_remote_get( "https://my.msgwow.com/api/v2/sendsms?authkey=" . $mezco_sms_settings['clave_msgwow'] . "&mobiles=" . $telefono . "&message=" . mezco_sms_codifica_el_mensaje( $mensaje ) . "&sender=" . $mezco_sms_settings['identificador_msgwow'] . "&route=" . $mezco_sms_settings['ruta_msgwow'] . "&country=" . $mezco_sms_settings['servidor_msgwow'] );
			break;
		case "mvaayoo":
			$argumentos['body'] = array( 
				'user' 			=> $mezco_sms_settings['usuario_mvaayoo'] . ":" . $mezco_sms_settings['contrasena_mvaayoo'],
				'senderID' 		=> $mezco_sms_settings['identificador_mvaayoo'],
				'receipientno' 	=> $telefono,
				'msgtxt' 		=> $mensaje,
				'dcs' 			=> "0",
				'state' 		=> "4",
			 );
			$respuesta = wp_remote_post( "http://api.mVaayoo.com/mvaayooapi/MessageCompose", $argumentos );
			break;
		case "nexmo":
			$respuesta = wp_remote_get( "https://rest.nexmo.com/sms/json?api_key=" . $mezco_sms_settings['clave_nexmo'] . "&api_secret=" . $mezco_sms_settings['identificador_nexmo'] . "&from=NEXMO&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "open_dnd":
			$respuesta = wp_remote_get( "http://txn.opendnd.in/pushsms.php?username=" . $mezco_sms_settings['usuario_open_dnd'] . "&password=" . $mezco_sms_settings['contrasena_open_dnd'] . "&message=" . mezco_sms_codifica_el_mensaje( mezco_sms_normaliza_mensaje( $mensaje ) ) . "&sender=" . $mezco_sms_settings['identificador_open_dnd'] . "&numbers=" . $telefono );
			break;
		case "plivo":
			$argumentos['headers'] = array(
				'Authorization'	=> 'Basic ' . base64_encode( $mezco_sms_settings['usuario_plivo'] . ":" . $mezco_sms_settings['clave_plivo'] ),
				'Connection'	=> 'close',
				'Content-Type'	=> 'application/json',
			);
			$argumentos['body'] = json_encode( array(
				'src'			=> ( trim( $mezco_sms_settings['identificador_plivo'] ) != '' ? $mezco_sms_settings['identificador_plivo'] : $mezco_sms_settings['telefono'] ),
				'dst'			=> $telefono,
				'text'			=> $mensaje,
				'type'			=> 'sms',
			) );
			$respuesta = wp_remote_post( "https://api.plivo.com/v1/Account/" . $mezco_sms_settings['usuario_plivo'] . "/Message/", $argumentos );
			break;
		case "routee":
			$argumentos['headers'] = array(
				'Authorization'	=> 'Basic ' . base64_encode( $mezco_sms_settings['usuario_routee'] . ":" . $mezco_sms_settings['contrasena_routee'] ),
				'Content-Type'	=> 'application/x-www-form-urlencoded',
			);
			$argumentos['body'] = array(
				'grant_type'	=> 'client_credentials',
			);
			$respuesta = wp_remote_post( "https://auth.routee.net/oauth/token", $argumentos );
			$routee = json_decode( $respuesta['body'] );
			
			$argumentos['headers'] = array(
				'Authorization'	=> 'Bearer ' . $routee->access_token,
				'Content-Type'	=> 'application/json',
			);
			$argumentos['body'] = json_encode( array(
				'body'			=> $mensaje,
				'to'			=> $telefono,
				'from'			=> $mezco_sms_settings['identificador_routee'],
			) );
			$respuesta = wp_remote_post( "https://connect.routee.net/sms", $argumentos );
			break;
		case "sipdiscount":
			$respuesta = wp_remote_get( "https://www.sipdiscount.com/myaccount/sendsms.php?username=" . $mezco_sms_settings['usuario_sipdiscount'] . "&password=" . $mezco_sms_settings['contrasena_sipdiscount'] . "&from=" . $mezco_sms_settings['telefono'] . "&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "smscountry":
			$argumentos['body'] = array( 
				'User' 			=> $mezco_sms_settings['usuario_smscountry'],
				'passwd' 		=> $mezco_sms_settings['contrasena_smscountry'],
				'mobilenumber' 	=> $telefono,
				'sid' 			=> $mezco_sms_settings['sid_smscountry'],
				'message' 		=> $mensaje,
				'mtype' 		=> "N",
				'DR' 			=> "Y",
			 );
			$respuesta = wp_remote_post( "http://api.smscountry.com/SMSCwebservice_bulk.aspx", $argumentos );
			break;
		case "smsdiscount":
			$respuesta = wp_remote_get( "https://www.smsdiscount.com/myaccount/sendsms.php?username=" . $mezco_sms_settings['usuario_smsdiscount'] . "&password=" . $mezco_sms_settings['contrasena_smsdiscount'] . "&from=" . $mezco_sms_settings['telefono'] . "&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "smslane":
			$argumentos['body'] = array( 
				'user' 		=> $mezco_sms_settings['usuario_smslane'],
				'password' 	=> $mezco_sms_settings['contrasena_smslane'],
				'msisdn' 	=> $telefono,
				'sid' 		=> $mezco_sms_settings['sid_smslane'],
				'msg' 		=> $mensaje,
				'fl' 		=> "0",
				'gwid' 		=> "2",
			 );
			$respuesta = wp_remote_post( "http://smslane.com/vendorsms/pushsms.aspx", $argumentos );
			break;
		case "solutions_infini":
			$respuesta = wp_remote_get( "http://alerts.sinfini.com/api/web2sms.php?workingkey=" . $mezco_sms_settings['clave_solutions_infini'] . "&to=" . $telefono . "&sender=" . $mezco_sms_settings['identificador_solutions_infini'] . "&message=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "mezcosms":
		$respuesta = wp_remote_get( "http://sms.adensoft.net/sms/index.php/sms/api?action=send-sms&api_key=" . $mezco_sms_settings['clave_mezcosms'] . "&from=" . $mezco_sms_settings['identificador_mezcosms'] . "&to=" . $telefono . "&sms=" . mezco_sms_codifica_el_mensaje( $mensaje ) . "&unicode=1" );
		break;			
		case "twilio":
			$argumentos['header'] = "Accept-Charset: utf-8\r\n";
			$argumentos['body'] = array( 
				'To' 	=> $telefono,
				'From' 	=> $mezco_sms_settings['telefono_twilio'],
				'Body' 	=> $mensaje
			 );
			$respuesta = wp_remote_post( "https://" . $mezco_sms_settings['clave_twilio'] . ":" . $mezco_sms_settings['identificador_twilio'] . "@api.twilio.com/2010-04-01/Accounts/" . $mezco_sms_settings['clave_twilio'] . "/Messages", $argumentos );
			break;
		case "twizo":
			$contenido = json_encode( array(
				'recipients'	=> array( $telefono ),
				'body'			=> $mensaje,
				'sender'		=> $mezco_sms_settings['identificador_twizo'],
				'tag'			=> 'Mezco SMS Notifications',
			) );
			$argumentos['headers'] = array(
				'Authorization'	=> "Basic " . base64_encode( "twizo:" . $mezco_sms_settings['clave_twizo'] ),
				'Accept'		=> 'application/json',
				'Content-Type'	=> 'application/json; charset=utf8',
				'Content-Length'=> strlen($contenido),
				'method'		=> 'POST',
			);
			$argumentos['body'] = $contenido;
			$respuesta = wp_remote_post( "https://" . $mezco_sms_settings['servidor_twizo'] . "/v1/sms/submitsimple", $argumentos );
			break;
		case "voipbuster":
			$respuesta = wp_remote_get( "https://www.voipbuster.com/myaccount/sendsms.php?username=" . $mezco_sms_settings['usuario_voipbuster'] . "&password=" . $mezco_sms_settings['contrasena_voipbuster'] . "&from=" . $mezco_sms_settings['telefono'] . "&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "voipbusterpro":
			$respuesta = wp_remote_get( "https://www.voipbusterpro.com/myaccount/sendsms.php?username=" . $mezco_sms_settings['usuario_voipbusterpro'] . "&password=" . $mezco_sms_settings['contrasena_voipbusterpro'] . "&from=" . $mezco_sms_settings['telefono'] . "&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
		case "voipstunt":
			$respuesta = wp_remote_get( "https://www.voipstunt.com/myaccount/sendsms.php?username=" . $mezco_sms_settings['usuario_voipstunt'] . "&password=" . $mezco_sms_settings['contrasena_voipstunt'] . "&from=" . $mezco_sms_settings['telefono'] . "&to=" . $telefono . "&text=" . mezco_sms_codifica_el_mensaje( $mensaje ) );
			break;
	}

	if ( isset( $mezco_sms_settings['debug'] ) && $mezco_sms_settings['debug'] == "1" && isset( $mezco_sms_settings['campo_debug'] ) ) {
		$correo	= __( 'Mobile number:', 'woo-mezco-sms' ) . "\r\n" . $telefono . "\r\n\r\n";
		$correo	.= __( 'Message: ', 'woo-mezco-sms' ) . "\r\n" . $mensaje . "\r\n\r\n"; 
		$correo	.= __( 'Gateway answer: ', 'woo-mezco-sms' ) . "\r\n" . print_r( $respuesta, true );
		wp_mail( $mezco_sms_settings['campo_debug'], 'Wocommerce - Mezco SMS', $correo, 'charset=UTF-8' . "\r\n" ); 
	}
}