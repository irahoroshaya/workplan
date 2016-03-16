<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');
$date=$_POST['date'];
$p704=$_POST['p704'];
$conn=Connect($db);
//Параметры поиска и сортировки
$items = array();
$v_qv="select * from (select a.p016,a.p017,ot284.mm091_kod_obozn_dse(a.x684,2) p006,
                ot284.mm091_kod_obozn_dse(a.x684,4) p008,a.c164,
                to_char(x36302,'hh24:mi') x36302, to_char(x36303,'hh24:mi') x36303,a.p25001
                from ot284.ot284e01 a where a.p704=$p704
                AND (TRUNC(a.X36302)=to_date('$date','dd.mm.yyyy') OR TRUNC(a.X36303)=to_date('$date','dd.mm.yyyy')))
                group by p016,p017,c164,x36302,x36303,p25001,p006,p008
                order by x36302,x36303,p006,p008";      
$stmt=OCIParse($conn,$v_qv);

//echo"$v_qv";
OCIExecute($stmt); 
while(OCIFetch($stmt))
{
	$r_p006=OCIResult($stmt,"P006");
	$r_p008=OCIResult($stmt,"P008");
	$r_p016=OCIResult($stmt,"P016");
	$r_p017=OCIResult($stmt,"P017");
	//$r_x745=OCIResult($stmt,"X745");
	$r_x36302=OCIResult($stmt,"X36302");
	$r_x36303=OCIResult($stmt,"X36303");
	$r_p25001=OCIResult($stmt,"P25001");
	if($r_p25001==''){$r_p25001='';}

	$v_qv0="select b.x684,b.x831,a.c164
		from ot284.ot284e01 a,ot284.mm081n02 b where a.p704=$p704 and a.x684=b.x684
		AND (TRUNC(a.X36302)=to_date('$date','dd.mm.yyyy') OR TRUNC(a.X36303)=to_date('$date','dd.mm.yyyy'))
		and a.p016=$r_p016 and a.p017=$r_p017 --and a.p25001=$r_p25001
		and a.p016=b.p016 and b.p017=a.p017
		order by b.x684";      
	$stmt0=OCIParse($conn,$v_qv0);
	OCIExecute($stmt0);
	$t=0;$vyp='';$c164=0;
	while(OCIFetch($stmt0))
	{
		$r_x684=OCIResult($stmt0,"X684");
		$r_x831=OCIResult($stmt0,"X831");
		$r_c164=OCIResult($stmt0,"C164");
		
		$c164=$c164+$r_c164;
		if($t==0){$x684=$r_x684;}
		else{$x684=$x684.'<br>'.$r_x684;}
		
		if($r_x831==2)
		{
		   if($t==0)
		    {$vyp='<img src="images/saved.png"/>';}
		    else
		    {$vyp=$vyp.'<br><img src="images/saved.png"/>';}
		    
		}
		else {
			if($t==0)
			{$vyp='';}
			else
			{$vyp=$vyp.'<br><br>';}
			}
		$t++;
	}
	

	if($r_p25001!='')
	{
	    $v_qv1 ="select d.cg61,d.p253,d.p450 from ot284.ak510n01 d
		          where d.p450 in (select p450 from ot284.ak510n04 where p2501=$r_p25001)";
	    $conn=Connect($db);
	    $stmt1=OCIParse($conn,$v_qv1);
	    OCIExecute($stmt1);
	    OCIFetch($stmt1);
	    $r_cg61=OCIResult($stmt1,"CG61");
	    $r_p253=OCIResult($stmt1,"P253");
	    $r_p450=OCIResult($stmt1,"P450");
	    $oborud=$r_cg61.' '.$r_p253;
	}
	else
	{
		$v_qv3 ="select b.p450,b.cg61 || ' ' || b.p253 P451 from ot284.ae600n01 a,ot284.ak510n01 b
                        where a.p003=ot284.MM091_KOD_OBOZN_DSE($r_x684,3) and a.p016=$r_p016 and a.p017=$r_p017
                        and a.p450=b.p450";
                        $stmt3=OCIParse($conn,$v_qv3);
                        $p3=OCIExecute($stmt3,OCI_DEFAULT);
                        OCIFetch($stmt3);
                        $r_p450=OCIResult($stmt3,"P450");
                        $r_p451=OCIResult($stmt3,"P451");
                        $oborud=$r_p451; 
	}
        
	$p006=$r_p006.'<br>'.$r_p008;
	$p006=iconv('KOI8-R','UTF-8',$p006);
	$oborud=iconv('KOI8-R','UTF-8',$oborud);
    
array_push($items, array('num' => $i,'p006'=>$p006,'oborud'=>$oborud,'vyp'=>$vyp,'kolvo'=>$c164,
			 'x36302'=>$r_x36302,'x36303'=>$r_x36303,'x684'=>$x684,'inv'=>$r_p25001,
			 'p450'=>$r_p450,'p016'=>$r_p016,'p017'=>$r_p017));
$x684='';
}

$arr = 	array (	'total' => $i,'dan'=>$items);
echo(json_encode($arr));
?>
