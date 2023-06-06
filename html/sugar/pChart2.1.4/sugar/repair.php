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
$mov=array();
$wrk=array();


//si le gfx est vide on met des zero partout
$in=mktime(0,0,0,$m,1,$y);
$out=(mktime(0,0,0,($m+1),1,$y))-1;
$cpt_cnt=db_single_read("select count(*) as cnt from repair where dt_out>$in and dt_out <$out and id_shop=$id_shop");
if($cpt_cnt->cnt==0)
	{
	die("Aucun resultat");
	}

//pour chaque jours de la semaine
for($i=1;$i<=31;$i++)
	{//on calcule le debut et la fin de journée 
	$in=mktime(0,0,0,$m,$i,$y);
	$out=(mktime(0,0,0,$m,($i+1),$y))-1;

	//$out=mktime(23,59,59,$m,$i,$y);
	
	$divers=0;$move=0;$work=0;//remise a zero des variables 
	//on compte si il y a eu des repair pour se jours 
	$rpr_cnt=db_single_read("select count(*) as cnt from repair where dt_out>$in and dt_out <$out and id_shop=$id_shop");
	if($rpr_cnt->cnt!=0)
		{//on recupere les tickets du jours 
		$rpr_tmp=db_read("select * from repair where dt_out>$in and dt_out <$out and id_shop=$id_shop");
		while($rpr = $rpr_tmp->fetch())
			{//on recupere les item des tickets
			$rpr_tmp=db_read("select * from repair_item where id_repair =$rpr->id");
			while($rpr = $rpr_tmp->fetch())
				{
				if($rpr->type=='work')$work+=$rpr->prix;
				if($rpr->type=='divers')$divers+=$rpr->prix;
				if($rpr->type=='move')$move+=$rpr->prix;
				}
			}
		if(($work!=0)or($divers!=0)or($move!=0))
			{
			array_push($day,$i);
			array_push($div,$divers);
			array_push($mov,$move);
			array_push($wrk,$work);
			}
		}
	}

 $width=1440;
 $height=780;

$MyData->addPoints($div,"Materiel");
//$MyData->addPoints($mov,"Déplacement");
$MyData->addPoints($wrk,"Main d oeuvre");


// $MyData->setSerieTicks("Probe 2",4);
// $MyData->setSerieWeight("Probe 3",2);
 $MyData->setAxisName(0,"Click");
 $MyData->addPoints($day,"Labels");
 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");

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
 $myPicture->drawRectangle(0,0,($width-1),($height-1),array("R"=>0,"G"=>0,"B"=>0));
 
 /* Write the chart title */ 
 $myPicture->setFontProperties(array("FontName"=>"../fonts/Forgotte.ttf","FontSize"=>18));
 $myPicture->drawText(250,55,"Repair (Vert : Vente, Orange : Main d oeuvre)",array("FontSize"=>18,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

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
