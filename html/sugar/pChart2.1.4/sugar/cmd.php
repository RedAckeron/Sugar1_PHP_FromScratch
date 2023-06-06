<?php   
 /* CAT:Line chart */

 /* pChart library inclusions */
 include("../class/pData.class.php");
 include("../class/pDraw.class.php");
 include("../class/pImage.class.php");
 include('../../../../www_off/sugar/dll/dll_db.php');

 /* Create and populate the pData object */
 $MyData = new pData();  
 $pa=array();
 $pv=array();
 $dt=array();
 $bb=array();

 //insertion d un champ a 0 pour que les graph demarrent de zero

array_push($pa,0);
array_push($pv,0);
array_push($dt,0);
array_push($bb,0);


 $m=$_GET['m'];
 $y=$_GET['y'];
 $id_shop=$_GET['id_shop'];

//on verifie si il y a bien qquechose a afficher

$in=mktime(0,0,0,$m,1,$y);
$out=(mktime(0,0,0,($m+1),1,$y))-1;

//$out=mktime(23,59,59,$m,31,$y);

$pa_tmp=0;
$pv_tmp=0;
//$benef_brute_tmp=0;
 
 $cmd_tmp=db_read("select * from cmd where type = 'cmd' and status!='hidden' and dt_in > $in and dt_in < $out order by dt_in");
	while($cmd = $cmd_tmp->fetch())
		{
		$dt_tmp=$cmd->id;
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd=$cmd->id and qt != 0");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$pa_tmp+=($cmd_item->prix_achat*$cmd_item->qt);
			$pv_tmp+=($cmd_item->prix_vente*$cmd_item->qt);
			}
		$bb_tmp=($pv_tmp-$pa_tmp);
		array_push($pa,$pa_tmp);
		array_push($pv,$pv_tmp);
		array_push($dt,$dt_tmp);
		array_push($bb,$bb_tmp);
		}
 
 $MyData->addPoints($pv,"pv");
 $MyData->addPoints($pa,"pa");
 $MyData->addPoints($bb,"Benefice brute");

 //$MyData->setSerieTicks("Probe 2",4);
 //$MyData->setSerieWeight("Probe 3",2);
 $MyData->setAxisName(0,"Euro");
 $MyData->addPoints($dt,"Labels");
 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");


 /* Create the pChart object */
 $myPicture = new pImage(1430,770,$MyData);

 /* Turn of Antialiasing */
 $myPicture->Antialias = TRUE;

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,1420,750,array("R"=>0,"G"=>0,"B"=>0));
 
 /* Write the chart title */ 
 $myPicture->setFontProperties(array("FontName"=>"../fonts/Forgotte.ttf","FontSize"=>10));
 $myPicture->drawText(150,35,"Courbe financiere",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

 /* Set the default font */
 $myPicture->setFontProperties(array("FontName"=>"../fonts/pf_arma_five.ttf","FontSize"=>9));

 /* Define the chart area */
 $myPicture->setGraphArea(60,40,1400,750);

 /* Draw the scale */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);

 /* Turn on Antialiasing */
 $myPicture->Antialias = TRUE;

 /* Draw the line chart */
 $myPicture->drawLineChart();

 /* Write the chart legend */
 $myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pictures/example.drawLineChart.simple.png");
?>
