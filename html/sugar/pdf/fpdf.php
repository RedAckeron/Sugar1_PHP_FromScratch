<?php
session_start();
require('../../../www_off/_tool_/fpdf/fpdf.php');
$pdf = unserialize($_SESSION['pdf']);
$pdf->Output('D','',1);
?>