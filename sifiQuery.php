<?php

$username = $_POST['username'];
$password = $_POST['password'];

$url = 'https://sifi-report.imtbs-tsp.eu/ReportServer/?%2fSIFI_PROD%2fRapports_ecole%2fcommun%2fBDNcursus&rs:Command=Render&rc:Toolbar=false&rs:Format=XML&rs:ClearSession=true&intidchoix=2&griser=0&Impression_coeff=OUI&Impression_heure=OUI&Impression_note_US=OUI&Impression_Grade_ECTS=OUI&social=NON&intIdUser=0';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
$data = curl_exec($ch);
curl_close($ch);

//$data = file_get_contents("BDNcursus.xml");

$xml = @new SimpleXMLElement($data);

$json_string = json_encode($xml);
   
$result_array = json_decode($json_string, TRUE);

print_r(json_encode($result_array));

?>