<?php   

/* CAT:Line chart */

/* pChart library inclusions */

include("../class/pData.class.php");
include("../class/pDraw.class.php");
include("../class/pImage.class.php");
include('../../../../www_off/sugar/dll/dll_db.php');

/* Create and populate the pData object */
 $MyData = new pData();
 
 $m=$_GET['m'];
 $y=$_GET['y'];
 $id_shop=$_GET['id_shop'];

$day=array();
$div=array();
$rpr=array();
$odp=array();
$cmd=array();


//si le gfx est vide on met des zero partout
$in=mktime(0,0,0,$m,1,$y);
$out=mktime(0,0,0,($m+1),1,$y);
$out-=1;
$cpt_cnt=db_single_read("select count(*) as cnt from compteur where dt>$in and dt <$out and id_shop=$id_shop");
if($cpt_cnt->cnt==0)
	{
	array_push($day,0);
	array_push($div,0);
	array_push($odp,0);
	array_push($cmd,0);
	array_push($rpr,0);
	}

//on verifie si il y a bien qquechose a afficher
for($i=1;$i<=31;$i++)
	{
	$in=mktime(0,0,0,$m,$i,$y);
	$out=mktime(23,59,59,$m,$i,$y);
	
	$divers=0;$offre=0;$command=0;$repair=0;//remise a zero des variables 
	$cpt_cnt=db_single_read("select count(*) as cnt from compteur where dt>$in and dt <$out and id_shop=$id_shop");
	if($cpt_cnt->cnt!=0)
		{
		$cpt_tmp=db_read("select * from compteur where dt>$in and dt <$out and id_shop=$id_shop");
		while($cpt = $cpt_tmp->fetch())
			{
			if($cpt->type_visite=='divers')$divers++;
			if($cpt->type_visite=='odp')$offre++;
			if($cpt->type_visite=='cmd')$command++;
			if($cpt->type_visite=='repair')$repair++;
			}
		array_push($day,$i);
		array_push($div,$divers);
		array_push($odp,$offre);
		array_push($cmd,$command);
		array_push($rpr,$repair);
		}
	}


$MyData->addPoints($div,"Autres");
$MyData->addPoints($rpr,"Repair");
$MyData->addPoints($odp,"Offre de prix");
$MyData->addPoints($cmd,"Commande");


 $MyData->setSerieTicks("Probe 2",4);
 $MyData->setSerieWeight("Probe 3",2);
 $MyData->setAxisName(0,"Click");
 $MyData->addPoints($day,"Labels");
 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");

 $width=1440;
 $height=780;

/* Create the pChart object */
 $myPicture = new pImage($width,$height,$MyData);

 /* Draw the background */
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
 $myPicture->drawFilledRectangle(0,0,$width,$height,$Settings);

 /* Overlay with a gradient */
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,$width,$height,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,$width,$height,array("R"=>0,"G"=>0,"B"=>0));
 
 /* Write the chart title */ 
 $myPicture->setFontProperties(array("FontName"=>"../fonts/Forgotte.ttf","FontSize"=>15));
 $myPicture->drawText(250,55,"Compteur (Divers - Repair - Offre de prix - Commande)",array("FontSize"=>18,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

 /* Draw the scale and the 1st chart */
 $myPicture->setGraphArea(60,60,$width,($height-25));
 $myPicture->drawFilledRectangle(60,60,$width,$height,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
 $myPicture->drawScale(array("DrawSubTicks"=>TRUE));
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>12));
 $myPicture->setFontProperties(array("FontName"=>"../fonts/pf_arma_five.ttf","FontSize"=>10));
 $myPicture->drawBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Rounded"=>TRUE,"Surrounding"=>30));
 $myPicture->setShadow(TRUE);

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pictures/example.drawBarChart.png");
	
?>
