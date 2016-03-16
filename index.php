<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
    <title>Сменное задание</title>

		<!-- BEGINLIBS -->
		<link rel="stylesheet" type="text/css" href="/ext3/resources/css/ext-all.css" />
	<script type="text/javascript" src="/ext3/adapter/ext/ext-base-debug.js"></script>
	<!--script type="text/javascript" src="/ext3/adapter/ext-base-debug-w-comments.js"></script-->
	
	<script type="text/javascript" src="/ext3/ext-all.js"></script>
	<script type="text/javascript" src="/ext3/src/locale/ext-lang-ru.js"></script>
		<!-- ENDLIBS -->
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/GroupHeaderPlugin.css" />
		
		<script type="text/javascript" src="js/init.js"></script>
		<script type="text/javascript" src="js/viewport_master.js"></script>
		<script type="text/javascript" src="js/GroupHeaderPlugin.js"></script>
    
		
</head>
<BODY>
<?php
require("ot284_common.php");
require("elah2.php");
if (isset($v_start) && $v_start==1)
  {
    return;
  }
 
$v_start=1;           
$v_paroly=0;          
$v_parolt=0;          
$v_parolf='';         
$v_parol_x453=0;     
$v_x453_global=0;     
$vm_parol=array('MASTER_CEX','VNEDR_VC','UCRUC_09','GZI_ENG');
$r_user=$PHP_AUTH_USER;

///if (empty($db)){exit();}
$conn=Connect($db);
enable_roles($conn,$vm_parol);
	
	$st0="SELECT Granted_Role FROM User_Role_Privs
      WHERE RTRIM(Granted_Role) in ('MASTER_CEX','VNEDR_VC','UCRUC_09','GZI_ENG')";
	$Roles=array();
$RoleRows = query($conn,$st0,$Roles);

if ($RoleRows[ROWS]>0)
{
    $v_paroly=1;
    $vm_parol=array();
    reset($Roles);

    while(list($key,$val)=each($Roles)){
    	     if($key==0){continue;}
          $p=$Roles[$key][1];
          $p=rtrim($p);
          $vm_parol[]=$p;
    }
    
    $str="SELECT p710,p704 from OT284.AB050H19";
    $stmtr=OCIParse($conn,$str);
    
    OCIExecute($stmtr);
    OCIFetch($stmtr);
    $v_parolf=OCIResult($stmtr,"P710");
    $v_parolt=OCIResult($stmtr,"P704");
    OCIFreeStatement($stmtr);
    
    $str_rab="SELECT X453,X455 from OT284.AB110H02 WHERE P704=$v_parolt";
    $stm_rab=OCIParse($conn,$str_rab);
    OCIExecute($stm_rab);
    OCIFetch($stm_rab);
    $v_parol_x453=OCIResult($stm_rab,"X453");   
    $v_x453_global=$v_parol_x453;
    $v_x459_global=OCIResult($stm_rab,"X455");  
    OCIFreeStatement($stm_rab);
    
    if (in_array('MASTER_CEX',$vm_parol) || in_array('UCRUC_09',$vm_parol)) {$v_paroly=0;}//мастер цеха
    //$v_x453_global=7;
//------------------------------------------------------------------------------
    echo"<script language='JavaScript' type='text/JavaScript'>
   		<!--
   		var v_x453=$v_x453_global;
		var v_x459='$v_x459_global';
   		-->
  		</script>";
}
else
	{
		session_unset();
		echo"
   		<!DOCTYPE HTML>
   		<HTML>
   		<HEAD>
   		<script language='JavaScript' type='text/JavaScript'>
   		<!--
   		var p_t=\"Извините, у Вас нет доступа к работе с формой.\";
   		alert(p_t);
   		window.location.href='https://ksu.p33.st/aa240/ksu_single.php?CurrentNode=5577';
  		-->
  		</script>
  		</HEAD>
  		</HTML>";
  		exit;
		
	}
//------------------------------------------------------------------------------
    

?>
	<div id="toolbar" ></div>
	<div id="main"></div>

</body>
</html>
