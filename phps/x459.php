<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');

//Параметры поиска и сортировки
$v_x453=$_POST['x453'];
$items = array();
$v_qv="SELECT distinct X455 from OT284.AB110H02 WHERE X455>0 AND X453=$v_x453 ORDER BY X455";
$conn=Connect($db);
$stmt=OCIParse($conn,$v_qv);
OCIExecute($stmt);
while (OCIFetch($stmt))
{
	$r_x459=OCIResult($stmt,"X455");
	array_push($items, array('x459' => $r_x459));
}

$arr = 	array (	'total' => 1,'dan' => $items );

$json = new Services_JSON();
$output = $json->encode($arr);

echo($output);

?>
