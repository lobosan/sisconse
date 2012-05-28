<?php

/*
 *   PROXY de servicios Yahoo! Maps
 *   NewVi Integral Solutions Cia. Ltda.
 *
 */

// El Appid, se obtiene de forma gratuita en Yahoo Apps.
//$appid = "&appid=aJ.LMezV34FEZjE9H3WgnAirIykgBIc8ic94T.aiANUZ5L1Otesfrvpru1AAdGYy9WNTiVJJjLXEXDhZGojAuQesYJVzctU-";

// Almacenar la URL que llega como parámetro
$url=$_REQUEST['url'];

// Crear un nuevo cURL con la URL almacenada
$ch = curl_init($url);

// Colocar opciones para que sólo llegue la imagen
//curl_setopt($session, CURLOPT_HEADER, false);
//curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_PROXY, '192.168.0.60:8088');
curl_setopt($ch, CURLOPT_PROXYPORT, 8088);

// Ejecutar la URL
$picture = curl_exec($ch);

// Cerrar el objeto cURL
curl_close($ch);

echo $picture;
?>
