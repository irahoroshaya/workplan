<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');

//Параметры поиска и сортировки
$x453=$_POST['x453'];
$c051=$_POST['c051'];
$c052=$_POST['c052'];
$items = array();
$conn=Connect($db);
$v_qv="SELECT a.x822,a.x684,to_char(a.x36402,'dd.mm.yyyy') x36402,
        a.c16401,a.p003,b.cd70,b.p006,b.p008
        from ot284.oml31n11 a,ot284.ae360n01 b,ot284.mm081n02 c
        where a.p003=b.p003 and a.x453=$x453
        and a.c051=$c051 and a.c052=$c052
	    and a.x684=c.x684 and a.p016=c.p016 and a.p017=c.p017 and c.x831<2 and c.cn5901!=9
        order by a.p003,a.x822,a.x684";

$stmt=OCIParse($conn,$v_qv);
OCIExecute($stmt);
while (OCIFetch($stmt))
{
	$r_x822=OCIResult($stmt,"X822");
        $r_x684=OCIResult($stmt,"X684");
        $r_x36402=OCIResult($stmt,"X36402");
        $r_c16401=OCIResult($stmt,"C16401");
        $r_p003=OCIResult($stmt,"P003");
        $r_cd70=OCIResult($stmt,"CD70");
        $r_p006=OCIResult($stmt,"P006");
        $r_p008=OCIResult($stmt,"P008");
	
	$v_qv00="SELECT count(*) C from ot284.ot284e01 where x684=$r_x684";
	$stmt00=OCIParse($conn,$v_qv00);
	OCIExecute($stmt00);
	OCIFetch($stmt00);
	$r_c=OCIResult($stmt00,"C");
	
	if($r_c>0)
	{
		$x684_text='<span style="color:red;">'.$r_x684.' от '.$r_x36402.'</span>';
		$r_x822='<span style="color:red;">'.$r_x822.'</span>';
		$r_c16401='<span style="color:red;">'.$r_c16401.'</span>';
		$text=1;
	}
        else
	{
		$x684_text=$r_x684.' от '.$r_x36402;
		$text=0;
	}
	//----------------------------------------------------------------------
	$v_qv0="SELECT sum(a.c16401) c16401_sum,a.p003
		from ot284.oml31n11 a,ot284.mm081n02 c
	where a.x453=$x453 and a.c051=$c051 and a.c052=$c052 and a.p003=$r_p003
	and a.x684=c.x684 and a.p016=c.p016 and a.p017=c.p017 and c.x831<2 and c.cn5901!=9
        group by a.p003";

	$stmt0=OCIParse($conn,$v_qv0);
	OCIExecute($stmt0);
	OCIFetch($stmt0);
	$c16401_sum=OCIResult($stmt0,"C16401_SUM");

        
        $p006='<table width="100%" style="border-top: 2pt solid; border-color:#99bbe8;"><tr>'.
		'<td class="text" style="width:35%">'.$r_cd70.' / '.$r_p003.'</td>'.
		'<td class="text" style="width:40%">'.$r_p006.' '.$r_p008.'</td>'.
		'<td class="text" style="text-align:right;">кол-во в НЗП: '.$c16401_sum.'</td></tr></table>';
	
	   $p006_oper='<table width="100%" style="border-top: 2pt solid; border-color:#99bbe8;"><tr>'.
		'<td class="text" style="width:35%">'.$r_cd70.' / '.$r_p003.'</td>'.
		'<td class="text" style="width:40%">'.$r_p006.' '.$r_p008.'</td>'.
		'</tr></table>';
	
	   $p006_text=$r_p006.'<br>'.$r_p008;
	
	
        
        $p006=iconv('KOI8-R','UTF-8',$p006);
	    $p006_oper=iconv('KOI8-R','UTF-8',$p006_oper);
        $x684_text=iconv('KOI8-R','UTF-8',$x684_text);
	    $p006_text=iconv('KOI8-R','UTF-8',$p006_text);
	
	array_push($items, array('p006' => $p006,'p006_oper' => $p006_oper,'x822'=>$r_x822,
				 'x684_text'=>$x684_text,'x684'=>$r_x684,'kolvo'=>$r_c16401,
				 'p006_text'=>$p006_text,'text'=>$text));    
}

$arr = 	array (	'total' => 1,'dan' => $items );

$json = new Services_JSON();
$output = $json->encode($arr);

echo($output);

?>
