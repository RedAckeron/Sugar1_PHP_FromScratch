<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_param==0)$js->alert_die("No acces");

if($sub_system=='')$sub_system='lobby';

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$sugar->label="par";
		$box->angle_in('10','10','300','140',$sugar->background_color,'black','','',100,"","",'');
			echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=param&sub_system=edit_password&no_interface></iframe>";
        $box->angle_out('');
        $box->angle_in('320','10','300','260',$sugar->background_color,'black','','',100,"","",'');
			echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=param&sub_system=select_song_call&no_interface></iframe>";
        $box->angle_out('');
        $box->angle_in('10','160','300','380',$sugar->background_color,'black','','',100,"","",'');
            echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=param&sub_system=select_background_color&no_interface></iframe>";
        $box->angle_out('');
		};break;
######################################################################################################################
	case 'edit_password':
		{
        echo "<h3><center>Change pasword</center></h3>";
		$form->open("index.php?system=param&sub_system=update_password&no_interface","POST");
		$box->empty('0','30','128','25','','','','',100,"Old password : ","",'');
		$box->empty_in('128','30','150','25','','','','',100,"","",'');
		echo $form->password('old_pwd',20,"");
		$box->empty_out('');

		$box->empty('0','55','128','25','','','','',100,"New password : ","",'');
		$box->empty_in('128','55','150','25','','','','',100,"","",'');
		echo $form->password('new_pwd1',20,"");
		$box->empty_out('');

		$box->empty('0','80','128','25','','','','',100,"New password : ","",'');
		$box->empty_in('128','80','150','25','','','','',100,"","",'');
		echo $form->password('new_pwd2',20,"");
		$box->empty_out('');

		$box->empty_in('110','107','100','25','','','','',100,"","",'');
		$form->send("Changer");
		$box->empty_out('');
		
		$form->close();
        };break;
######################################################################################################################
	case 'update_password':
		{
		$msg='';
		$uzr=db_single_read("select * from user where id = $sugar->id");
		
		$old_pwd=crypt($_POST['old_pwd'],'md5');
		if ($uzr->password!=$old_pwd)$msg.="Votre ancien mot de passe n est pas bon ";
		
		$new_pwd1=crypt($_POST['new_pwd1'],'md5');
		$new_pwd2=crypt($_POST['new_pwd2'],'md5');

		if ($new_pwd1!=$new_pwd2)$msg.="Les deux nouveau mot de passe ne sont pas identique";

		if($msg=="")
			{
			db_write("update user set password='$new_pwd1' where id = $sugar->id");
			$js->alert_redirect("Mot de passe changer avec succes","index.php?system=param&sub_system=edit_password&no_interface",0);
			}
		else $js->alert_redirect("$msg","index.php?system=param&sub_system=edit_password&no_interface",0);
        };break;    
######################################################################################################################
    case 'select_song_call':
        {
        echo "<h3><center>Select Call Song</center></h3>";
        $iterator = new DirectoryIterator("mp3/call/");
        foreach($iterator as $document)
            {
            if(($document->getFilename()!='.')and($document->getFilename()!='..'))
                {
                if($sugar->call_song==$document->getFilename())$color='red';
                else $color='grey';
                $box->empty_in('','','232','32',$color,'black','','',100,"","index.php?system=param&sub_system=update_song_call&song=".$document->getFilename()."&no_interface",'');
                $box->angle('','','32','32','','black','img/32px/song.gif','',100,"","",'');
                $box->angle('','','200','32','','black','','',100,$document->getFilename(),"",'');
                $box->empty_out('.');
                }
            }
        };break;
######################################################################################################################
    case 'update_song_call':
        {
        $song=$_GET['song'];
        echo "<center>PLAYING : $song</center><audio autoplay><source src='mp3/call/$song' type='audio/mpeg'></audio>";
        $sugar->update_var_user('call_song',$song);
        $sugar->call_song=$song;
        echo "<meta http-equiv='refresh' content='1; url=index.php?system=param&sub_system=select_song_call&no_interface'/>";
        };break;
######################################################################################################################
    case 'select_background_color':
        {
        echo "<h3><center>Select Background color</center></h3>";
        $box->angle('','','232','32','grey','black','','',100,"Grey","index.php?system=param&sub_system=update_background_color&color=grey&&no_interface",'');
        $box->angle('','','232','32','black','black','','',100,"Black","index.php?system=param&sub_system=update_background_color&color=black&&no_interface",'');
        $box->angle('','','232','32','pink','black','','',100,"Pink","index.php?system=param&sub_system=update_background_color&color=pink&&no_interface",'');
        $box->angle('','','232','32','purple','black','','',100,"Purple","index.php?system=param&sub_system=update_background_color&color=purple&&no_interface",'');
        $box->angle('','','232','32','white','black','','',100,"White","index.php?system=param&sub_system=update_background_color&color=white&&no_interface",'');
        $box->angle('','','232','32','lightgrey','black','','',100,"Lightgrey","index.php?system=param&sub_system=update_background_color&color=lightgrey&&no_interface",'');
        $box->angle('','','232','32','orange','black','','',100,"Orange","index.php?system=param&sub_system=update_background_color&color=orange&&no_interface",'');
        $box->angle('','','232','32','blue','black','','',100,"Blue","index.php?system=param&sub_system=update_background_color&color=blue&&no_interface",'');
        $box->angle('','','232','32','green','black','','',100,"Green","index.php?system=param&sub_system=update_background_color&color=green&&no_interface",'');
        $box->angle('','','232','32','brown','black','','',100,"Brown","index.php?system=param&sub_system=update_background_color&color=brown&&no_interface",'');
       
        };break;
######################################################################################################################
    case 'update_background_color':
        {
        $color=$_GET['color'];
        $sugar->update_var_user('background_color',$color);
        $sugar->background_color=$color;
        echo "<meta http-equiv='refresh' content='0; url=index.php?system=param&sub_system=select_background_color&no_interface'/>";
        };break;
	}
?>