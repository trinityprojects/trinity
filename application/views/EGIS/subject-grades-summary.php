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
$pdf->AddPage('L', 'LEGAL');
//$pdf->Write(0, 'JOB ORDER #' . $jobOrderNumber , '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 7);


// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")

$tbl = <<<EOD
<br><br>
<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%" >
 <tr align="center">
  <td width="6%"></td>
  <td width="16%"></td>
  <td width="35%" colspan="$wwColumnCount" >Written Work $wwPct%</td>
  <td width="30%" colspan="$ptColumnCount">Performance Task $ptPct%</td>
  <td width="7%" colspan="$qaColumnCount">Quarterly Assessment $qaPct%</td>
  <td width="3%"> Initial Grade</td>
  <td width="3%"> Quarterly Grade</td>
 </tr>
 <tr align="center">
  <td>Student Number</td>
  <td>Full Name</td>
EOD;

for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
$indexWW = "titleWW".$ww;
$tbl.=<<<EOD
      <td>$titles[$indexWW]</td>
EOD;
}	

$tbl.=<<<EOD
 <td>Total</td>
 <td>PS</td>
 <td>WS</td>
 
EOD;

for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
$indexPT = "titlePT".$pt;
$tbl.=<<<EOD
      <td>$titles[$indexPT]</td>
EOD;
}	

$tbl.=<<<EOD
 <td>Total</td>
 <td>PS</td>
 <td>WS</td>
EOD;

for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
$indexQA = "titleQA".$qa;
$tbl.=<<<EOD
      <td>$titles[$indexQA]</td>
EOD;
}	

$tbl.=<<<EOD
 <td>PS</td>
 <td>WS</td>
 <td></td>
 <td></td>
</tr> 
EOD;

$tbl.=<<<EOD
	<tr>
		<td colspan="2" align="center">Highest Possible Score</td>
EOD;
	  
$maxScoreTotalWW = 0;
for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
$iWW = "WW".$ww;
$maxScoreTotalWW = $maxScoreTotalWW + $maxScoreRow[$iWW];
$tbl.=<<<EOD
 	    <td align="right">$maxScoreRow[$iWW]</td>
EOD;
}

$tbl.=<<<EOD
	<td align="right">$maxScoreTotalWW</td>
	<td align="right">100</td>	
	<td align="right">$wwPct%</td>	
EOD;


$maxScoreTotalPT = 0;
for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
$iPT = "PT".$pt;
$maxScoreTotalPT = $maxScoreTotalPT + $maxScoreRow[$iPT];
$tbl.=<<<EOD
 	    <td align="right">$maxScoreRow[$iPT]</td>
EOD;
}

$tbl.=<<<EOD
	<td align="right">$maxScoreTotalPT</td>
	<td align="right">100</td>	
	<td align="right">$ptPct%</td>	
EOD;


$maxScoreTotalQA = 0;
for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
$iQA = "QA".$qa;
$maxScoreTotalQA = $maxScoreTotalQA + $maxScoreRow[$iQA];
$tbl.=<<<EOD
 	    <td align="right">$maxScoreRow[$iQA]</td>
EOD;
}

$tbl.=<<<EOD
	<td align="right">100</td>	
	<td align="right">$qaPct%</td>	
EOD;


$tbl.=<<<EOD
	<td align="right">100</td>	
	<td align="right">100</td>	
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
 $scoreArr = (array) $scoreList[$index];
//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------
$totalScoreWW = array();
$psScoreWW = array();
$wsScoreWW = array();
for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
 $iWW = "WW".$ww;
 $totalScoreWW[$index] = $totalScoreWW[$index] + $scoreArr[$iWW];	           
$tbl.=<<<EOD
		<td align="right">$scoreArr[$iWW]</td>
EOD;
}		
	$psScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) , 2);
	$wsScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) * ($wwPct / 100), 2);	
$tbl.=<<<EOD
		<td align="right">$totalScoreWW[$index]</td>
		<td align="right">$psScoreWW[$index]</td>
		<td align="right">$wsScoreWW[$index]</td>
EOD;
//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------


//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------
$totalScorePT = array();
$psScorePT = array();
$wsScorePT = array();
for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
 $iPT = "PT".$pt;
 $totalScorePT[$index] = $totalScorePT[$index] + $scoreArr[$iPT];	           
$tbl.=<<<EOD
		<td align="right">$scoreArr[$iPT]</td>
EOD;
}		
	$psScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) , 2);
	$wsScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) * ($ptPct / 100), 2);	
$tbl.=<<<EOD
		<td align="right">$totalScorePT[$index]</td>
		<td align="right">$psScorePT[$index]</td>
		<td align="right">$wsScorePT[$index]</td>
EOD;
//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------


//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------
$totalScoreQA = array();
$psScoreQA = array();
$wsScoreQA = array();
for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
 $iQA = "QA".$qa;
 $totalScoreQA[$index] = $totalScoreQA[$index] + $scoreArr[$iQA];	           
$tbl.=<<<EOD
		<td align="right">$scoreArr[$iQA]</td>
EOD;
}		
	$psScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) , 2);
	$wsScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) * ($qaPct / 100), 2);	
$tbl.=<<<EOD
		<td align="right">$psScoreQA[$index]</td>
		<td align="right">$wsScoreQA[$index]</td>
EOD;
//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------

$initialGrade = array();
$transmutedGrade = array();
$initialGrade[$index] = number_format(($wsScoreWW[$index] + $wsScorePT[$index] + $wsScoreQA[$index]) ,2);
	
foreach($transmutationTable as $transmute) {
	if($transmute->lowScore <= $initialGrade[$index] && $transmute->highScore >= $initialGrade[$index]) {
		$transmutedGrade[$index] = $transmute->transmutedScore;
	}

}	
	
$tbl.=<<<EOD
		<td align="right">$initialGrade[$index]</td>
		<td align="right">$transmutedGrade[$index]</td>

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
