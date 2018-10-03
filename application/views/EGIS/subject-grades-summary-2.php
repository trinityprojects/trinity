<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//============================================================+
// File name   : subject-grades-summary-2.php
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


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Randy Lagdaan');
//$pdf->SetTitle('JOB ORDER');
//$pdf->SetSubject('Request Job Order');
//$pdf->SetKeywords('Job Order, request');

// set default header data
$pdf->SetHeaderData(false, false, 'Grades Summary for ' . $sectionCode . " - " . $subjectDescription , false);

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
$pdf->AddPage('P', 'LETTER');
//$pdf->Write(0, 'JOB ORDER #' . $jobOrderNumber , '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 7);


// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")

$tbl = <<<EOD
<br><br>
<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%" >
 <tr align="center">
  <td width="10%"></td>
  <td width="30%"></td>
  <td width="5%"> Final Grade</td>
 </tr>
 <tr align="center">
  <td>Student Number</td>
  <td>Full Name</td>
EOD;

	  


$maxScoreTotal = 0;
$maxScore = $maxScoreRow['WW1'];
$tbl.=<<<EOD
 	    <td align="right">$maxScore</td>
	</tr>
EOD;



foreach($scoreList as $index=>$key ) {
 if ($index < 1) continue;	
 $studentNumber = $scoreList[$index]->studentNumber;
 $fullName = $scoreList[$index]->fullName;
 
$tbl.=<<<EOD
	<tr>
		<td>$studentNumber</td>
		<td>$fullName</td>
EOD;
 $score =  $scoreList[$index]->WW1;
//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------
$tbl.=<<<EOD
		<td align="right">$score</td>
		</tr>
EOD;
}		


$tbl.=<<<EOD
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------



$filename= "subjectGradesSummary". $subjectCodeNS . $sectionCodeNS . ".pdf"; 
$filelocation = "C:\\xampp\\htdocs\\trinity\\assets\\pdf";//windows
              //$$filelocation = "/var/www/html/trinity/assets/pdf"; //Linux

$fileNL = $filelocation."\\".$filename;//Windows
           // $fileNL = $filelocation."/".$filename; //Linux    

$pdf->Output($fileNL,'F');	
	
// -----------------------------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
