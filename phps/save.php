<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');

//Параметры поиска и сортировки
$inv_str=$_POST['inv'];
$x684_str=$_POST['x684'];
$p016_str=$_POST['p016'];
$p017_str=$_POST['p017'];
$x36302_str=$_POST['x36302'];
$x36303_str=$_POST['x36303'];

$p704=$_POST['p704'];
$x453=$_POST['x453'];
$x459=$_POST['x459'];
$v_kk=$_POST['v_kk'];

$m_inv=array();
$m_p016=array();
$m_p017=array();
$m_x684=array();
$m_x36302=array();
$m_x36303=array();

$m_inv=explode("***", $inv_str);
$m_p016=explode("***", $p016_str);
$m_p017=explode("***", $p017_str);
$m_x684=explode("***", $x684_str);
$m_x36302=explode("***", $x36302_str);
$m_x36303=explode("***", $x36303_str);
//------------------------------------------------------------------------------
if($v_kk==3)
{
	$sql="declare
        r_count NUMBER(5):=0;
        r_c164 NUMBER:=0;
	r_x468 NUMBER:=0;
        begin
        select count(*) into r_count from ot284.ot284e01
        where x684=:x684 and p704=:p704 and p016=:p016 and p017=:p017;
        
        if r_count>0 then
        update ot284.ot284e01 set p25001=:inv,
                                  x36302=to_date(:x36302,'dd.mm.yyyy hh24:mi'),
                                  x36303=to_date(:x36303,'dd.mm.yyyy hh24:mi')
        where p704=:p704 and x684=:x684 and p016=:p016 and p017=:p017;
        else
        select c16401 into r_c164 from ot284.oml31n11 where x684=:x684 and x453=:x453;
                
	BEGIN
	select X468 into r_x468 from ot284.mm089e01 where p704=:p704 and x453=:x453;
	EXCEPTION
	WHEN NO_DATA_FOUND THEN r_x468:=0;
	END;
        
        insert into ot284.ot284e01 (CP91,X453,X459,P704,X468,X36302,X36303,X684,P016,P017,C017,P25001,C164,C01501,C013,P70402,X364)
        values (ot284.ot284e01_cp91.nextval,:x453,:x459,:p704,r_x468,to_date(:x36302,'dd.mm.yyyy hh24:mi'),
                to_date(:x36303,'dd.mm.yyyy hh24:mi'),:x684,:p016,:p017,1,:inv,r_c164,null,null,null,sysdate);
        end if;
        
      end;";
$conn=Connect($db);
$res = ociparse($conn, $sql);
OCIBindByName($res,":x684",$x684,15);
OCIBindByName($res,":inv",$inv,15);
OCIBindByName($res,":p016",$p016,5);
OCIBindByName($res,":p017",$p017,5);
OCIBindByName($res,":x453",$x453,5);
OCIBindByName($res,":x459",$x459,5);
OCIBindByName($res,":x36302",$x36302,50);
OCIBindByName($res,":x36303",$x36303,50);
OCIBindByName($res,":p704",$p704,10);
//------------------------------------------------------------------------------
for ($i=0;$i<sizeof($m_x36302);$i++)
{
	$m_x684_1=array();
        $m_x684_1=explode('<br>', $m_x684[$i]);
        
	$inv=$m_inv[$i];
	if($inv==0){$inv=null;}
	
        $p016=$m_p016[$i];
        $p017=$m_p017[$i];
        $x36302=$m_x36302[$i];
        $x36303=$m_x36303[$i];
       
	for($ii=0;$ii<sizeof($m_x684_1);$ii++)
        {
            $x684=$m_x684_1[$ii];
            if(ociexecute($res))$otv=1;
	   
        }
}

}
//------------------------------------------------------------------------------
if($v_kk==1)
{
	$sql="declare
	      r_count NUMBER(5):=0;
	      begin
		  select count(*) into r_count from ot284.ot284e01
		  where x684=:x684 and p704=:p704 and p016=:p016 and p017=:p017;
		
		  if r_count>0 then
		      delete from ot284.ot284e01 where x684=:x684 and p704=:p704 and p016=:p016 and p017=:p017;
		  end if;
		
	      end;";
$conn=Connect($db);
$res = ociparse($conn, $sql);
OCIBindByName($res,":x684",$x684,15);
OCIBindByName($res,":p016",$p016,5);
OCIBindByName($res,":p017",$p017,5);
OCIBindByName($res,":p704",$p704,10);
for ($i=0;$i<sizeof($m_x36302);$i++)
{
        $m_x684_1=array();
        $m_x684_1=explode('<br>', $m_x684[$i]);
	
        $p016=$m_p016[$i];
        $p017=$m_p017[$i];
        
	for($ii=0;$ii<sizeof($m_x684_1);$ii++)
        {
            $x684=$m_x684_1[$ii];
            if( ociexecute($res))$otv=1;
        }
}


}
echo(json_encode($otv));
?>
