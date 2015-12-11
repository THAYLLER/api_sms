<?php
  $usuario = 'montnet';
  $senha  = 'Qym56fMu';

  $celulares = explode(";",$_POST['celular']);

  $url = "http://api.infobip.com/api/v3/sendsms/xml";

   $xmlString = "
   <SMS> 
     <authentification> 
    <username>".$usuario."</username> 
    <password>".$senha."</password> 
     </authentification> 
     <message> 
    <sender>".$_POST['titulo']."</sender> 
    <text>".$_POST['texto']."</text> 
    <flash></flash>
    <type></type> 
    <wapurl></wapurl> 
    <binary></binary> 
    <datacoding></datacoding> 
    <esmclass></esmclass> 
    <srcton></srcton> 
    <srcnpi></srcnpi> 
    <destton></destton> 
    <destnpi></destnpi> 
    <ValidityPeriod></ValidityPeriod> 
     </message> 
     <recipients>"; 
     for($i = 0; $i < sizeof($celulares);$i++){
        $xmlString .= "<gsm>".$celulares[$i]."</gsm>";  
     }
     $xmlString .= "</recipients> 
   </SMS>  ";
$fields  = "XML=" . urlencode($xmlString); 
    
   //  in this example, POST request was made using PHP's CURL 
   $ch  = curl_init(); 
   curl_setopt($ch,  CURLOPT_URL, $url); 
   curl_setopt($ch, CURLOPT_POST, 1); 
   curl_setopt($ch, CURLOPT_POSTFIELDS,  $fields); 
    
   //  response of the POST request 
   $response  = curl_exec($ch);
   curl_close($ch); 