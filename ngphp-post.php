<?php
header('Acccess-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
$content_length= (int) $_SERVER['CONTENT_LENGTH'];
$postdata=file_get_contents("php://input");
$request= json_decode($postdata);
$data=[];
$dta[0]['length']=$content_length;
foreach($request as $k=>$v){
    $data[0]['post_'.$k]=$v;
}
$input=$data[0]['post_'.$k];
$input=trim(strtolower($input));
$result = [];
$warray= explode(" ", $input);
$repeatstr="";
$output="";
foreach($warray as $word){
   if(in_array($word, array_keys($result))==true){
       $result[$word]=$result[$word]+1;
   } else{
       $result[$word]=0;
   }
}
foreach(array_keys($result) as $word){
    if($result[$word]!=0){
        $repeatstr.=$word." repeats ".strval($result[$word])." times, ";
    }
}
if($repeatstr==""){
   $output="No repeats found";
} else{
   $output=$repeatstr;
}
echo json_encode([$output]);

?>
