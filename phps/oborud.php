<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');

//Параметры поиска и сортировки
$v_p450=$_POST['p450'];
$items = array();
if(!empty($v_p450) && $v_p450!='false' && $v_p450!='')
{
    $v_qv="SELECT distinct P2501 from OT284.AK510N04 WHERE P450=$v_p450 ORDER BY P2501";
$conn=Connect($db);
$stmt=OCIParse($conn,$v_qv);
OCIExecute($stmt);
while (OCIFetch($stmt))
    {
	$r_p2501=OCIResult($stmt,"P2501");
	array_push($items, array('oborud' => $r_p2501));
    }
}
else $r_p2501='';


$arr = 	array (	'total' => 1,'dan' => $items );

$json = new Services_JSON();
$output = $json->encode($arr);

echo($output);

?>