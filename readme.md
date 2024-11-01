# Wocommerce - Mezco SMS
Contributors: adensoft

Donate link: https://adensoft.net/donacion

Tags: AdenSoft Developers, MEZCO, Plugins, WooCommerce, e-Commerce, Commerce, Shop, Virtual shop, SMS, SMS notifications, SMS gateway, VoipStunt, Solutions Infini, Twilio, Twizo, Clickatell, Clockwork, BulkSMS, OPEN DND, MobTexting, Moreify, MSG91, mVaayoo, Nexmo, Esebun Business (Enterprise & Developers only), iSMS Malaysia, SMS Lane (Transactional SMS only), SMS Country, LabsMobile Spain, Plivo, VoipBusterPro, VoipBuster, SMS Discount, SIP Discount, Spring Edge, MSGWOW, Routee, WooCommerce Sequential Order Numbers Pro, WPML

Requires at least: 3.8

Tested up to: 5.2

Stable tag: 1.0.1

WC requires at least: 2.1

WC tested up to: 3.6

License: GPLv3

License URI: http://www.gnu.org/licenses/gpl-3.0.html

Añade a tu tienda WooCommerce notificaciones SMS a tus clientes cuando cambie el estado del pedido.

## Description
**IMPORTANTE: *Wocommerce - Mezco SMS* requiere WooCommerce 2.1.0 o superior.**

**NOTA: WooCommerce - Mezco SMS Notifications ahora se llama *Wocommerce - Mezco SMS*.**

**Wocommerce - Mezco SMS** añade a tu tienda WooCommerce la posibilidad de enviar notificaciones SMS al cliente cada vez que cambie el estado del pedido. También notifica al propietario, si así lo desea, cuando la tienda tenga un nuevo pedido.

### Características
* Soporte de múltiples proveedores SMS:
 * [Mezco SMS](https://sms.adensoft.net/).
* Posibilidad de informar al propietario o propietarios de la tienda sobre nuevos pedidos.
* Posibilidad de enviar, o no, SMS internacionales.
* Posibilidad de notificar al número de teléfono de envío, si es distinto del número de teléfono de facturación.
* Posibilidad de notificar 
* 100% compatible con [WPML](https://wpml.org/?aid=80296&affiliate_key=m66Ss5ps0xoS).
* Soporte para los estados de pedido personalizados.
* Soporte para los números de pedido personalizados del plugin [WooCommerce Sequential Order Numbers Pro](http://www.woothemes.com/products/sequential-order-numbers-pro/).
* Inserta de forma automática el código telefónico internacional, si es necesario, al número de teléfono del cliente.
* También notifica por SMS las notas a los clientes.
* Todos los mensajes son personalizables.
* Puedes elegir qué mensajes enviar.
* Puedes temporizar cada X horas el mensaje para pedidos en espera.
* Soporta gran cantidad de variables para personalizar nuestros mensajes: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% y %note%.
* Puedes añadir tus propias variables personalizadas.
* Dispone del filtro *mezco_sms_message* para facilitar la personalización de los mensajes SMS desde plugins de terceros.
* Dispone del filtro *mezco_sms_message_return* para facilitar la personalización de los mensajes una vez codificados desde plugins de terceros.
* Dispone del filtro *mezco_sms_send_message* para impedir el envío de los mensajes SMS desde plugins de terceros.
* Dispone de los filtros *mezco_sms_phone_process* y *mezco_sms_phone_return* para facilitar el procesamiento del número de teléfono desde plugins de terceros.
* Posibilidad de notificar a múltiples números de teléfono vía filtro *mezco_sms_phone_return*.
* Una vez configurado es totalmente automático.

### Traducciones
* Español ([**AdenSoft Developers**](https://adensoft.net/)).
* English ([**AdenSoft Developers**](https://adensoft.net/)).
* French ([**Studios Jurdan**](http://www.jurdan.biz)).

### Soporte técnico
**AdenSoft Developers** te ofrece [**Soporte técnico**](https://adensoft.net/tienda/ticket-de-soporte) para configurar o instalar ***Wocommerce - Mezco SMS***.

### Origen
**Wocommerce - Mezco SMS** ha sido programado a partir de la petición de [Chirag Vora](https://profiles.wordpress.org/chirag740) para añadir a WooCommerce la posibilidad de enviar notificaciones sobre el estado de los pedidos a través de mensajes SMS.

### Más información
En nuestro sitio web oficial puede obtener más información sobre [**Wocommerce - Mezco SMS**](https://adensoft.net/plugins-para-woocommerce/wc-mezco-sms-notifications). 

### Comentarios
No olvides dejarnos tu comentario en:

* [Wocommerce - Mezco SMS](https://adensoft.net/plugins-para-woocommerce/wc-mezco-sms-notifications) en AdenSoft Developers.
* [AdenSoft Developers](https://www.facebook.com/adensoft) en Facebook.
* [@adensoft](https://twitter.com/adensoft) en Twitter.
* [+adensoftES](https://plus.google.com/+adensoftES/) en Google+.

### Más plugins
Recuerda que puedes encontrar más [plugins para WordPress](https://adensoft.net/plugins-para-wordpress) y más [plugins para WooCommerce](https://adensoft.net/plugins-para-woocommerce) en [AdenSoft Developers](https://adensoft.net) y en nuestro perfil en [WordPress](https://profiles.wordpress.org/adensoft/).

### GitHub
Puedes seguir el desarrollo de este plugin en [Github](https://github.com/adensoft/woo-mezco-sms).

## Instalación
1. Puedes:
 * Subir la carpeta `woo-mezco-sms` al directorio `/wp-content/plugins/` vía FTP. 
 * Subir el archivo ZIP completo vía *Plugins -> Añadir nuevo -> Subir* en el Panel de Administración de tu instalación de WordPress.
 * Buscar **Wocommerce - Mezco SMS** en el buscador disponible en *Plugins -> Añadir nuevo* y pulsar el botón *Instalar ahora*.
2. Activar el plugin a través del menú *Plugins* en el Panel de Administración de WordPress.
3. Configurar el plugin en *WooCommerce -> Ajustes -> Envío* o a través del botón *Ajustes*.
4. Listo, ahora ya puedes disfrutar de él, y si te gusta y te resulta útil, hacer una [*donación*](https://adensoft.net/tienda/donacion).

## Preguntas frecuentes
### ¿Cómo se configura?
Para configurar el plugin sólo hay que añadir los datos proporcionados por cada proveedor SMS, y que varían en función de este. 

Además hay que añadir el número de teléfono móvil que esté vinculado con la cuenta. 

Se debe indicar si queremos, o no, recibir notificaciones SMS por cada nuevo pedido en la tienda y si queremos, o no, enviar SMS internacionales.

Por último hay que personalizar, si se desea, los mensajes que se enviarán por SMS.

### Soporte técnico
Si necesitas ayuda para configurar o instalar **Wocommerce - Mezco SMS**, **AdenSoft Developers** te ofrece su servicio de [**Soporte técnico**](https://adensoft.net/tienda/ticket-de-soporte). 

*En ningún caso **AdenSoft Developers** proporciona ningún tipo de soporte técnico gratuito.*

## Changelog
### 1.0.1



## Traducciones
* *English*: by [**AdenSoft Developers**](https://adensoft.net/) (default language).
* *Español*: por [**AdenSoft Developers**](https://adensoft.net/).
* *French*: pour ([**Studios Jurdan**](http://www.jurdan.biz)).

## Soporte técnico
Dado que **Wocommerce - Mezco SMS** es totalmente gratuito, **AdenSoft Developers** sólo proporciona el servicio de [**Soporte técnico**](https://adensoft.net/tienda/ticket-de-soporte) previo pago. En ningún caso **AdenSoft Developers** proporciona ningún tipo de soporte técnico gratuito.

## Donación
¿Te ha gustado y te ha resultado útil **Wocommerce - Mezco SMS** en tu sitio web? Te agradeceríamos una [pequeña donación](https://adensoft.net/tienda/donacion) que nos ayudará a seguir mejorando este plugin y a crear más plugins totalmente gratuitos para toda la comunidad WordPress.

## Gracias
* A [Chirag Vora](https://profiles.wordpress.org/chirag740) por habernos inspirado para crear **Wocommerce - Mezco SMS**.
* A todos los que lo usáis.
* A todos los que ayudáis a mejorarlo.
* A todos los que realizáis donaciones.
* A todos los que nos animáis con vuestros comentarios.

¡Muchas gracias a todos!
