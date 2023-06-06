<?php
///echo "<body style='background-color:$sugar->background_color'>";
///if(($sugar->id==0)and($sub_system!="chk_login"))$sub_system="input_login";
switch ($sub_system)
	{
######################################################################################################################
case 'lobby':
    {
    echo "LOBBY";
    };break;
######################################################################################################################
case 'close_page':
	{
	echo "<script type='text/javascript'>window.close();</script>";
	};break;
	}
?>