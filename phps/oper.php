<?php
require_once('..//json/JSON.php');
require('elah2.php');
require('..//ot284_common.php');

//Параметры поиска и сортировки
$x453=$_POST['x453'];
$x684=$_POST['x684'];
$p006=$_POST['p006'];
$p006_text=$_POST['p006_text'];
$kolvo=$_POST['kolvo'];

$m_p006=array();
$m_p006=explode("***", $p006);
$m_p006_text=explode("***", $p006_text);
$m_x684=array();
$m_x684=explode("***", $x684);
$m_kolvo=array();
$m_kolvo=explode("***", $kolvo);

$v_sum=0;
$items = array();
$v_qv="select * from (SELECT a.p016,a.p017,a.c034,c.x745,ot284.mm091_kod_obozn_dse(:x684,3) p003
        from ot284.mm081n02 a,ot284.oml31n11 b,ot284.ak300n01 c
        where a.x453=$x453 and a.x684=:x684 and a.x831<2 and a.cn5901!=9
        and a.x684=b.x684 and a.x453=b.x453
        and (a.p016*1000+a.p017)>=(b.p016*1000+b.p017)
        and a.c034=c.x747 and c.x744='P018')
        order by p003,p016,p017";
$conn=Connect($db);
$stmt=OCIParse($conn,$v_qv);
OCIBindByName($stmt,":x684",$v_x684,20);

for($i=0;$i<sizeof($m_x684);$i++)
{
        $v_x684=$m_x684[$i];
        $v_kolvo=$m_kolvo[$i];
        if($v_x684!='')
        {
                  $v_sum=$v_sum+$m_kolvo[$i];
                  $v_p006=stripcslashes($m_p006[$i]);
                  $v_p006_text=stripcslashes($m_p006_text[$i]);
                  
                  $res ="begin
                  OT284.DL_DSE(ot284.mm091_kod_obozn_dse($v_x684,3),sysdate);
                  end;";
                                
                  $st=OCIParse($conn,$res);
                  $p=OCIExecute($st,OCI_DEFAULT);
                  if (empty($p))
                  {
                          OCICommit($conn);
                          Disconnect($conn);
                  }
                  
                  
                  $p=OCIExecute($stmt,OCI_DEFAULT);
                  while (OCIFetch($stmt))
                  {
                          $r_p016=OCIResult($stmt,"P016");
                          $r_p017=OCIResult($stmt,"P017");
                          $r_c034=OCIResult($stmt,"C034");
                          $r_x745=OCIResult($stmt,"X745");
                          $r_p003=OCIResult($stmt,"P003");
                          
                          
                          $v_qv00="SELECT count(*) C from ot284.ot284e01
                                   where x684=$v_x684 and p016=$r_p016 and p017=$r_p017";
                          $stmt00=OCIParse($conn,$v_qv00);
                          OCIExecute($stmt00);
                          OCIFetch($stmt00);
                          $r_c=OCIResult($stmt00,"C");
                          
                          
                          $v_qv3 ="select a.p450,b.cg61 || ' ' || b.p253 P451 from ot284.ae600n01 a,ot284.ak510n01 b
                                          where a.p003=$r_p003 and a.p016=$r_p016 and a.p017=$r_p017 and a.x453=$x453
                                          and a.p450=b.p450";
                          $stmt3=OCIParse($conn,$v_qv3);
                          $p3=OCIExecute($stmt3,OCI_DEFAULT);
                          OCIFetch($stmt3);
                          $r_p450=OCIResult($stmt3,"P450");
                          $r_p451=OCIResult($stmt3,"P451");
                          
                          
                          $v_qv2 ="select c07306,OT284.OT284_TIME_TEXT(c07306) c07306_text from ot284.am286t03
                                  where p003=$r_p003 and p016=$r_p016 and p017=$r_p017";
                          $stmt2=OCIParse($conn,$v_qv2);
                          $p2=OCIExecute($stmt2,OCI_DEFAULT);
                          OCIFetch($stmt2);
                          $r_c07306_text=0+OCIResult($stmt2,"C07306");
                          $r_c07306_text=OCIResult($stmt2,"C07306_TEXT");
                          
                          $p016_text=$r_p016.' - '.$r_p017;
                          
                          $r_x745=iconv('KOI8-R','UTF-8',$r_x745);
                          $r_p451=iconv('KOI8-R','UTF-8',$r_p451);
                          $r_c07306_text=iconv('KOI8-R','UTF-8',$r_c07306_text);
                          $pr=0;
                          for ($u=0;$u<sizeof($items);$u++)
                          {
                              if($v_p006==$items[$u]['p006'] && $r_p016==$items[$u]['p016'] && $r_p017==$items[$u]['p017'])
                             {
                               $pr=1;
                               $items[$u]['x684']=$items[$u]['x684'].'<br>'.$v_x684;
                               $items[$u]['kolvo']=$items[$u]['kolvo']+$v_kolvo;
                              }
                          }
                          if($pr!=1)
                          {
                                
                               if($r_c>0)
                                {
                                        $v_qv00 ="select ot284.fio(p704) p704f,to_char(x36302,'dd.mm.yyyy') x36302,x684
                                                  from ot284.ot284e01 where x684=$v_x684 and p016=$r_p016 and p017=$r_p017";
                                        $stmt00=OCIParse($conn,$v_qv00);
                                        $p00=OCIExecute($stmt00,OCI_DEFAULT);
                                        OCIFetch($stmt00);
                                        $p704f_text=OCIResult($stmt00,"P704F");
                                        $x36302_text=OCIResult($stmt00,"X36302");
                                        $x684_text=OCIResult($stmt00,"X684");
                                        $p704f_text=iconv('KOI8-R','UTF-8',$p704f_text);
                          
                                        
                                        $p016_text='<span style="color:red;">'.$p016_text.'</span>';
                                        $r_x745='<span style="color:red;">'.$r_x745.'</span>';
                                        $r_p451='<span style="color:red;">'.$r_p451.'</span>';
                                        $r_c07306_text='<span style="color:red;">'.$r_c07306_text.'</span>';
                                }
                                else
                                {
                                        $p704f_text='';
                                        $x36302_text='';
                                        $x684_text=''; 
                                }
                               
                              array_push($items, array('p006' => $v_p006,'x684'=>$v_x684,'p016_text'=>$p016_text,
                                                   'p016'=>$r_p016,'p017'=>$r_p017,'c034'=>$r_x745,'time'=>$r_c07306_text,
                                                   'oborud'=>$r_p451,'p450'=>$r_p450,'p006_text'=>$v_p006_text,
                                                   'kolvo'=>$v_kolvo,'p704f_text'=>$p704f_text,'x36302_text'=>$x36302_text,
                                                   'x684_text'=>$x684_text));
                              
                          }
                          
                           
                  }  
        }
        
        
}
OCICommit($conn);
Disconnect($conn);
$arr = 	array (	'total' => 1,'dan' => $items,'v_sum'=>$v_sum );

$json = new Services_JSON();
$output = $json->encode($arr);

echo($output);

?>