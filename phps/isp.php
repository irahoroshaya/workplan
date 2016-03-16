<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');
$x453=$_POST['x453'];
$x459=$_POST['x459'];

$p_kl="0=0";
if(!empty($x459)){$p_kl="OT284.KU($x453,p704,sysdate)=$x459";}
$conn=Connect($db);
//Параметры поиска и сортировки
$items = array();
$v_qv="SELECT p704,p710 from OT284.AB110H02 WHERE X453=$x453 AND $p_kl AND KK!=3 ORDER BY p710";      
$stmt=OCIParse($conn,$v_qv);
 
OCIExecute($stmt); 
while(OCIFetch($stmt))
{
	$r_p704=OCIResult($stmt,"P704");
    $r_p710=OCIResult($stmt,"P710");
    $r_p710=iconv('KOI8-R', 'UTF-8', $r_p710);
	array_push($items, array('p704'=>$r_p704,'p710'=>$r_p710));
}

$arr = 	array (	'total' => $i,'dan'=>$items);

echo(json_encode($arr));
?>
