<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */
//https://ourcodeworld.com/articles/read/275/how-to-encrypt-a-pdf-password-protection-against-copy-extraction-or-modifications-generated-with-tcpdf-in-php
// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Randy Lagdaan');
//$pdf->SetTitle('JOB ORDER');
//$pdf->SetSubject('Request Job Order');
//$pdf->SetKeywords('Job Order, request');

// set default header data
$pdf->SetHeaderData(false, false, 'Ranking by Year Level: ' . $yearLevelLabel, false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 12));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 15, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage('L', 'LEGAL');
//$pdf->Write(0, 'JOB ORDER #' . $jobOrderNumber , '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 7);


// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")

$tbl = <<<EOD
<br><br>
<table border="1" cellpadding="2" cellspacing="1" nobr="true" width="100%" >
 <tr align="center">
  <td width="2%">#</td>
  <td width="5%">Student No.</td>
  <td width="16%">Full Name</td>
  <td width="9%">Section Code</td>
  
EOD;

for($s = 1; $s < $subjCtr; $s++) {
	$subj = 'subj' . $s;
	$subject = $grades[$t]->$subj;
$tbl.=<<<EOD
      <td width="4%">$subject</td>
EOD;
}

$tbl.=<<<EOD
      <td width="4%">Wtd Ave</td>
	</tr>
EOD;

$tbl.=<<<EOD
 <tr align="center">
  <td colspan="4"> WEIGHT </td>
EOD;

for($w = 0; $w < $weightCtr; $w++) {
$tbl.=<<<EOD
      <td width="4%">$weight[$w]</td>
EOD;
}


$tbl.=<<<EOD
      <td width="4%">$totalWeight</td>
	</tr>
EOD;



foreach($grades as $index=>$key ) {
 if ($index >= $t ) continue;	
 $studentNumber = $grades[$index]->studentNumber;
 $fullName = $grades[$index]->lastName . ", " . $grades[$index]->firstName. " " . $grades[$index]->middleName;
 $sectionCode = $grades[$index]->sectionCode;
 
 $ctr = $index + 1;
$tbl.=<<<EOD
 <tr >
  <td align="right">$ctr</td>
  <td align="left">$studentNumber</td>
  <td align="left">$fullName</td>
  <td align="left">$sectionCode</td>
  
EOD;


for($s = 1; $s < $subjCtr; $s++) {
	$subj = 'subj' . $s;
	$subject = $grades[$index]->$subj;
$tbl.=<<<EOD
      <td align="right" width="4%">$subject</td>
EOD;
}

$weightedAverage = number_format($grades[$index]->weightedAverage, 2);
$tbl.=<<<EOD
      <td align="right" width="4%">$weightedAverage</td>
EOD;

$tbl.=<<<EOD
</tr>
EOD;



}
 

 
$tbl.=<<<EOD
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------



$filename= "rankingByYearLevel". $yearLevel . ".pdf"; 
$filelocation = "C:\\xampp\\htdocs\\trinity\\assets\\pdf";//windows
               //$filelocation = "/var/www/html/trinity/assets/pdf"; //Linux

$fileNL = $filelocation."\\".$filename;//Windows
           //$fileNL = $filelocation."/".$filename; //Linux 

$pdf->Output($fileNL,'F');	
	
// -----------------------------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
