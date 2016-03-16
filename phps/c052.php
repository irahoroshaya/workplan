<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');
$c051=$_POST['c051'];
$x453=$_POST['x453'];
$conn=Connect($db);
//Параметры поиска и сортировки
$items = array();
$v_qv ="select distinct a.c052 from ot284.oml31n11 a,ot284.mm081n02 b
		where a.x453=$x453 and a.x684=b.x684 and a.p016=b.p016
		and a.c051=$c051 and a.p017=b.p017 and b.x831<2
		and b.cn5901!=9
		order by a.c052";        
$stmt=OCIParse($conn,$v_qv);
 
OCIExecute($stmt);
$net_v=iconv('KOI8-R', 'UTF-8', "нет выбора");
array_push($items, array('c052'=>$net_v));
    
while(OCIFetch($stmt))
{
	$c052=OCIResult($stmt,"C052");
	array_push($items, array('c052'=>$c052));
}

$arr = 	array (	'total' => $i,'dan'=>$items);

echo(json_encode($arr));
?>