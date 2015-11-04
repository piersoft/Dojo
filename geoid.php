<?php
$id=$_GET["id"];
//$id="a4e557ca-8653-41c0-b177-81c66baafdc0";
$json_string = file_get_contents("http://zen.coderdojo.com/api/2.0/dojos/".$id);
$parsed_json = json_decode($json_string);
$count = 0;

foreach($parsed_json as $data=>$csv1){
   $count = $count+1;
}
$temp_c1="";

//  echo $count;
//  var_dump($parsed_json->{'name'});


$temp_c1 .="<strong>".$parsed_json->{'name'}."</strong>";

if ($parsed_json->{'website'} !=NULL)$temp_c1 .="</br>Address: ".$parsed_json->{'address1'};
if ($parsed_json->{'email'} !=NULL)$temp_c1 .="</br>Email: ".$parsed_json->{'email'};
if ($parsed_json->{'website'} !=NULL) $temp_c1 .="</br><a href='".$parsed_json->{'website'}."' target='_blank'/>Website Dojo</a>";
if ($parsed_json->{'twitter'} !=NULL)$temp_c1 .="</br>Twitter: @".$parsed_json->{'twitter'};
$temp_c1 .="</br><a href='http://zen.coderdojo.com/dojo/".$parsed_json->{'urlSlug'}."' target='_blank' />Dojo on Zen's website</a>";
if ($parsed_json->{'verified'} =="1" ){
  $verified=$parsed_json->{'verifiedAt'};
  $verified=str_replace("T"," ",$verified);
  $verified=str_replace("Z"," ",$verified);
  $verified=str_replace(".000"," ",$verified);
  $temp_c1 .="</br>Verified at ".$verified;
}else $temp_c1 .="</br>Not Verified";

echo $temp_c1;


?>
