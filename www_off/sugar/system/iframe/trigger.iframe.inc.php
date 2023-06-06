<?php
################################################################################################################################## 
//VERIFICATION CALL
if (!isset($_SESSION['trigger']))$_SESSION['trigger']=time();
//call
$box->box_rond_in('0','0','35','35','','','','',100,"",'','');//iframe trigger
echo "<img src='img/32px/loading.gif' width=100%></img>";
$box->empty('11','9','20','20','','','','',100,"</b><font size=1>".($_SESSION['trigger']-time())."</font>",'','');//iframe trigger
$box->box_rond_out('.');
if($_SESSION['trigger']<=time())
    {  
    $chk_call=db_single_read("select count(*) as cnt from call_log where id_tech = $sugar->id and status='open';");
    if($chk_call->cnt>0)
        {
        echo "<audio autoplay><source src='mp3/call/$sugar->call_song' type='audio/mpeg'></audio>"; 
        }
    $_SESSION['trigger']=(time()+60);
    }
//VERIFICATION CALL
##################################################################################################################################
echo"<meta http-equiv='refresh' content='1; url='/>";

?>