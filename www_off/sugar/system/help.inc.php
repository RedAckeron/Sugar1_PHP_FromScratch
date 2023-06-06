<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_help==0)$js->alert_redirect("No acces","index.php",0);
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$sugar->label="hel";
		if(!isset($_GET['print']))
			{
			$box->angle('','','590','25',"",'','','',100,"","",'');
			echo "<a href='index.php?system=help&no_interface&print' target=_blank>";
			$box->angle('','','150','25',"lightgreen",'black','','',100,"Print","",'');
			echo "</a>";
			if($sugar->security_help>1)$box->angle('','','150','25',"#CC5BF4",'black','','',100,"Edit","index.php?system=help&sub_system=edit",'');
			$box->angle('','','500','25',"",'','','',100,"","",'');
			}
			//main page
			$main=db_single_read("select * from var_server where nom='help_text_main';");
			$box->angle_in('','','740','1050','white','black','','',100,"","",'');
				$box->angle('150','200','450','300',"",'black','img/logo_sugar.gif','',100,"","",'');
				$box->angle('150','600','450','100',"",'black','','',100,"<br><font size=6>$main->var</font>","",'');
			$box->angle_out('');
			echo "<p style='page-break-before:always'>";
			//Slidshow
			$slideshow=db_single_read("select * from var_server where nom='help_text_slideshow';");
			$box->angle_in('','','740','1050','white','black','','',100,"","",'');
				$box->angle('20','20','32','32',"",'black','img/32px/slideshow_blue.gif','',100,"","",'');
				$box->angle('72','20','600','32',"",'black','','',100,"<font size =5>Slideshow</font>","",'');
				$box->angle('20','72','690','850',"",'black','','',100,"</b>".nl2br($slideshow->var),"",'');
			$box->angle_out('');
			echo "<p style='page-break-before:always'>";
			//customer
			$cust=db_single_read("select * from var_server where nom='help_text_customer';");
			$box->angle_in('','','740','1050','white','black','','',100,"","",'');
				$box->angle('20','20','32','32',"",'black','img/32px/customer_blue.gif','',100,"","",'');
				$box->angle('72','20','600','32',"",'black','','',100,"<font size =5>Client</font>","",'');
				$box->angle('20','72','690','850',"",'black','','',100,"$cust->var","",'');
			$box->angle_out('');
			echo "<p style='page-break-before:always'>";
			//call
			$box->angle_in('','','740','1050','white','black','','',100,"","",'');
				$box->angle('20','20','32','32',"",'black','img/32px/call_blue.gif','',100,"","",'');
				$box->angle('72','20','600','32',"",'black','','',100,"<font size =5>Call</font>","",'');
				$box->angle('20','72','690','850',"",'black','','',100,"","",'');
			$box->angle_out('');
			echo "<p style='page-break-before:always'>";
			//repair
			$box->angle_in('','','740','1050','white','black','','',100,"","",'');
				$box->angle('20','20','32','32',"",'black','img/32px/repair_blue.gif','',100,"","",'');
				$box->angle('72','20','600','32',"",'black','','',100,"<font size =5>Repair</font>","",'');
				$box->angle('20','72','690','850',"",'black','','',100,"","",'');
			$box->angle_out('');
			echo "<p style='page-break-before:always'>";
			//promo
			$promo=db_single_read("select * from var_server where nom='help_text_promo';");
			$box->angle_in('','','740','1050','white','black','','',100,"","",'');
				$box->angle('20','20','32','32',"",'black','img/32px/sale_blue.gif','',100,"","",'');
				$box->angle('72','20','600','32',"",'black','','',100,"<font size =5>Promo</font>","",'');
				$box->angle('20','72','690','850',"",'black','','',100,"</b>".nl2br($promo->var),"",'');
			$box->angle_out('');
			echo "<p style='page-break-before:always'>";

			
		};break;
######################################################################################################################
	case 'edit':
		{
		if($sugar->security_help<2)$js->alert_redirect("No acces","index.php?system=help",0);

		$form->open('index.php?system=help&sub_system=update','POST');
		
		$cust=db_single_read("select * from var_server where nom='help_text_customer';");
		echo "<br>Customer<br>";
		$form->textarea('customer',10,120,$cust->var);
		
		$call=db_single_read("select * from var_server where nom='help_text_call';");
		echo "<br>Call<br>";
		$form->textarea('call',10,120,$call->var);
		
		$repair=db_single_read("select * from var_server where nom='help_text_repair';");
		echo "<br>Repair<br>";
		$form->textarea('Repair',10,120,$repair->var);
		
		$slideshow=db_single_read("select * from var_server where nom='help_text_slideshow';");
		echo "<br>Slideshow<br>";
		$form->textarea('slideshow',10,120,$slideshow->var);

		$form->send('Update');
		$form->close();
		};break;
######################################################################################################################
	case 'update':
		{
		if($sugar->security_help<2)$js->alert_redirect("No acces","index.php?system=help",0);

		$slideshow=$_POST['slideshow'];
		$rqt="update var_server set var='$slideshow' where nom='help_text_slideshow';";
		db_write($rqt);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=help'/>";
		};break;
	}
	if(isset($_GET['print']))echo "<body onload='window.print();window.close()'>";
?>