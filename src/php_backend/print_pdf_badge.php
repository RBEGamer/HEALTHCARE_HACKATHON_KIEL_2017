<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once('tcpdf/tcpdf_import.php');
include('phpqrcode/qrlib.php');
include 'db.php';
$qrTempDir = "./tmp"; //CHANGE IT




$result = "";
$id = -1;
$fetchinfo_dev = mysqli_query($mysqli,"SELECT * FROM `patient_info` WHERE `badge_printed`='0' LIMIT 1");
while($row_dev = mysqli_fetch_array($fetchinfo_dev)) {
ob_start();

$qr_code_url = "http://" .$_SERVER[HTTP_HOST] ."/change_patient.php?pid=" .$row_dev['barcodedata'];
if(basename(__DIR__) != ""){
$qr_code_url = "http://" .$_SERVER[HTTP_HOST] ."/".basename(__DIR__)."/"."change_patient.php?pid=" .$row_dev['barcodedata'];
}

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PatientenNotiz');
$pdf->SetTitle('PatientenNotiz QR Code ' .$row_dev['barcodedata']);
$pdf->SetSubject($row_dev['first_name'] . " " . $row_dev['last_name']);
$pdf->SetKeywords('PatientenNotiz');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 14, '', true);
$pdf->AddPage();
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$pdf->setJPEGQuality(100);



//ADD SOME TEXT
$html = "<h2>BadgePage - ".$row_dev['barcodedata']. "<br><h3>".$row_dev['first_name'] . " " . $row_dev['last_name']."</h3>";

$pdf->writeHTML($html, true, false, true, false, '');
//ADD BARCODE IMAGE
$filePath = $qrTempDir.'/'.uniqid() .".png";
QRcode::png($qr_code_url, $filePath);
$qrImage = file_get_contents($filePath);
$pdf->Image($filePath, 60, 60, 40, 40, 'PNG', $qr_code_url, '', true, 150, '', false, false, 1, false, false, false);

ob_end_clean();

$pdf->Output($row_dev['barcodedata'].'.pdf', 'D');

$id = $row_dev['id'];
$fetchinfo_dev_1 = mysqli_query($mysqli,"UPDATE `patient_info` SET `badge_printed`='1' WHERE `id`='".$id."'");
echo "please reload this page again";
exit();
}

echo "all badges are printed - please register a new patient via alexa" ;
?>
