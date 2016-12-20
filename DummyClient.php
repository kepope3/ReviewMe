<?php

/*make signature for call to server
 * http://web.archive.org/web/20150906064244/http://www.thebuzzmedia.com/designing-a-secure-rest-api-without-oauth-authentication/
 * STEP 1: CLIENT->Combine all params together and HASH, including your private API KEY
 * STEP 2: CLIENT->Send API public key, send the HASH and send the params
 * STEP 3: SERVER->Use public key to get private key and check if in db
 * STEP 4: SERVER->Generate signature how client did (using private key)
 * STEP 5: SERVER->Compare signatures and allow access if they match
 * https://newsapi.org/account API: b8ccf652e66b4852bef9cb966d921e1f
 */

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/ReviewMe/index.php//?item1=value&item2=value2',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
$content = curl_exec($curl);
curl_close($curl);

echo $content;



?>