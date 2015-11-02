<?php

function fakeip()
{
return long2ip( mt_rand(0, 65537) * mt_rand(0, 65535) );
}
function getdata($url,$args=true)
{
global $session;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: ".fakeip(),"X-Client-IP: ".fakeip(),"Client-IP: ".fakeip(),"HTTP_X_FORWARDED_FOR: ".fakeip(),"X-Forwarded-For: ".fakeip()));
if($args)
{
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($ch);
curl_close ($ch);
return $result;
}
$result=getdata("http://zen.coderdojo.com/api/2.0/dojos","fields=name");

$name="";
  $data = json_decode($result,true);
  $dest1 = fopen('output.geojson', 'w');

  foreach($data as $key => $value) {
      $features[] = array(
              'type' => 'Feature',
              'geometry' => array('type' => 'Point', 'coordinates' => array((float)$value['geoPoint']['lon'],(float)$value['geoPoint']['lat'])),
              'properties' => array('name' => $value['name'], 'id' => $value['id']),
              );
      };

  $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
  $geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);
  fputs($dest1, $geostring);

  // da decommentare per download automatico del geojson. tipico utilizzo con Umap
        //   header('Content-Type: application/geojson');
        //   header('Content-Disposition: attachment; filename=output.geojson');
        //   header('Pragma: no-cache');
        //   readfile("output.geojson");

?>
