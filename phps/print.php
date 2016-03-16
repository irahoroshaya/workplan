<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');
require("pdf_gen.php");
$date=$_GET['date'];
$p704=$_GET['p704'];
$x453=$_GET['x453'];
$conn=Connect($db);
//------------------------------------------------------------------------------
$v_qv0="select  p7051 || ' ' || p7052 || ' ' || p7053 p704f,
        OT284.KU($x453,$p704,sysdate) x459
        from OT284.AB110H02 where p704=$p704";      
$stmt0=OCIParse($conn,$v_qv0);
OCIExecute($stmt0);
OCIFetch($stmt0);
$p704f=OCIResult($stmt0,"P704F");
$x459=OCIResult($stmt0,"X459");

$p_data=date("d.m.Y",time());
$p_time=date("H:i:s",time());
$p_d="Дата:$p_data Время:$p_time";	
//------------------------------------------------------------------------------
$str="<?xml version='1.0' encoding='koi8-r'?>".
"<!DOCTYPE print SYSTEM 'ot284c03.dtd'>".
"<?xml-stylesheet type='text/xml' href='ot284c03.xsl'?>".
"<ot284c03><fio>$p704f</fio><p704>$p704</p704><date>$date</date><x453>$x453</x453><x459>$x459</x459><p_d>$p_d</p_d>";

$v_qv="select p016,p017,p006,p008,x745,p25001,sum(c164),x36302,x36303 
from (select a.p016,a.p017,ot284.mm091_kod_obozn_dse(a.x684,2) p006,b.x745,
                ot284.mm091_kod_obozn_dse(a.x684,4) p008, a.c164,
                to_char(x36302,'hh24:mi') x36302, to_char(x36303,'hh24:mi') x36303,a.p25001
		from ot284.ot284e01 a,ot284.ak300n01 b,ot284.mm081n02 c where a.p704=$p704
		AND (TRUNC(a.X36302)=to_date('$date','dd.mm.yyyy') OR TRUNC(a.X36303)=to_date('$date','dd.mm.yyyy'))
                and c.c034=b.x747 and b.x744='P018'
                and a.x684=c.x684 and a.x453=c.x453 and a.x684=c.x684
                and a.p016=c.p016 and a.p017=c.p017)
		group by p016,p017,x36302,x745,x36303,p25001,p006,p008,p25001
		order by x36302,x36303,p006,p008";      
$stmt=OCIParse($conn,$v_qv);
OCIExecute($stmt);
$i=0;
while(OCIFetch($stmt))
{
	$r_p006=OCIResult($stmt,"P006");
	$r_p008=OCIResult($stmt,"P008");
	$r_p016=OCIResult($stmt,"P016");
	$r_p017=OCIResult($stmt,"P017");
	$r_x745=OCIResult($stmt,"X745");
	$r_x36302=OCIResult($stmt,"X36302");
	$r_x36303=OCIResult($stmt,"X36303");
	$r_p25001=OCIResult($stmt,"P25001");
	if($r_p25001==''){$r_p25001='';}

//------------------------------------------------------------------------------
       



	$v_qv0="select b.x684,b.x831,a.c164
		from ot284.ot284e01 a,ot284.mm081n02 b where a.p704=$p704 and a.x684=b.x684
		AND (TRUNC(a.X36302)=to_date('$date','dd.mm.yyyy') OR TRUNC(a.X36303)=to_date('$date','dd.mm.yyyy'))
		and a.p016=$r_p016 and a.p017=$r_p017
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
		else{$x684=$x684.' '.$r_x684;}
                $t++;
        }
                $v_qv00="select a.x745 PROF from ot284.ak300n01 a,ot284.ae600n01 b
                 where b.p700=a.x747 and a.x744='P700'
                 and b.p016=$r_p016 and b.p017=$r_p017 and b.x453=$x453
		 and b.p003=ot284.MM091_KOD_OBOZN_DSE($r_x684,3)";      
                
                $stmt00=OCIParse($conn,$v_qv00);
                OCIExecute($stmt00);
                OCIFetch($stmt00);
                $prof=OCIResult($stmt00,"PROF");
	

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
	   $oborud=''; 
	}

    $i++;

$str=$str."<str><num>$i</num><x36302>$r_x36302</x36302>".
               "<x36303>$r_x36303</x36303>".
               "<p006>$r_p006</p006>".
               "<p008>$r_p008</p008>".
               "<x684>$x684</x684>".
               "<c164>$c164</c164>".
               "<x745>$r_x745</x745>".
               "<p016>$r_p016</p016>".
               "<p017>$r_p017</p017>".
               "<prof>$prof</prof>".
               "<oborud>$oborud</oborud>".
               "<inv>$r_p25001</inv></str>";              
$x684='';
}

$str=$str."</ot284c03>";

//echo"$str"; 
pdf_gen($str);

?>