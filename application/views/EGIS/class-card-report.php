<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//============================================================+
// File name   : class-card-report.php
// Begin       : 2018-09-05
// Last Update : 2013-09-12
//
// Description : Class Card for K12
//               
//
// Author: Randy D. Lagdaan
//
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
//$pdf->SetHeaderData(false, false, '', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 5));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(5, 15, 5);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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

$pdf->SetFont('helvetica', '', 8);


// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")


$tbl = <<<EOD
<table width="100%" cellspacing="5px">
<tr>
<td width="49%"> 
EOD;







$tbl.=<<<EOD
<table  width="100%" cellpadding="5px">

<tr>
<td width="30%" colspan="4" vertical-align="top" align="center">
	<img border="0" src="c:/xampp/htdocs/trinity/assets/images/tualogo.jpg" height="500%" width="500%" alt="TUA LOGO">
</td>
<td width="40%" colspan="4" vertical-align="middle" align="center" style="font-size:14px;">
	<h2>Trinity University of Asia</h2><br>
	Level III ACSCU-AAI-FAAP Accredited<br>
	Basic Education Report Card
</td>
<td width="30%" colspan="4" valign="middle" align="center" style="font-size:14px;">
	FM-BED-029-R00 <br> Basic Education TUA Form 138
</td>
</tr>

</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;



$tbl.=<<<EOD
				
<table  width="100%" cellpadding="1px" cellspacing="0">

<tr>
	<td colspan="5" style="font-size:14px;">Student Number:<u> $studentNumber </u></td>
	<td colspan="5" style="font-size:14px;">LRN:<u> </u></td>
	
</tr>


<tr>
	<td colspan="10" style="font-size:14px;">Name:&nbsp;<u> $lastName, $firstName  $middleName </u></td>
</tr>

<tr>
	<td colspan="2" style="font-size:14px;">Age:&nbsp;<u>$age</u></td>
	<td colspan="2" style="font-size:14px;">Sex:&nbsp;<u>$gender</u></td>
	<td colspan="6" style="font-size:14px;">School Year:&nbsp; <u>$sYear</u></td>
</tr>

<tr>
	<td colspan="10" style="font-size:14px;">Year and Section:&nbsp;<u>$yearLevel $sectionCode</u></td>
</tr>


</table>
EOD;


$tbl.=<<<EOD
				
<table border="1" width="100%" cellpadding="2px">

<tr>
<td width="30%" align="center" style="font-size:14px;" >Subject</td>
<td width="50%" colspan="8" align="center" style="font-size:14px;">Periodic Ratings</td>
<td width="20%" colspan="3"  align="center" style="font-size:14px;"></td>
</tr>

<tr align="center">
<td> </td>
<td colspan="2">1st</td>
<td colspan="2">2nd</td>
<td colspan="2">3rd</td>
<td colspan="2">4th</td>
<td colspan="2">Final</td>
<td>Action Taken </td>
</tr>
EOD;

$totalGrades1 = 0;
$weightedAve1 = 0;
$totalWeight = 0;
foreach($resultsGrades as $index=>$key ) {
	 $subjectDescription = $resultsGrades[$index]->subjectDescription;
	 $grades1 = number_format($resultsGrades[$index]->grades1, 0);
	 $letterEquivalent1 = $resultsGrades[$index]->letterEquivalent1;
	 $grades2 = number_format($resultsGrades[$index]->grades2, 0);
	 $letterEquivalent2 = $resultsGrades[$index]->letterEquivalent2;

	 $totalGrades1 = $totalGrades1 + ($grades1 * $resultsGrades[$index]->weight);
	 $totalWeight = $totalWeight + $resultsGrades[$index]->weight;
	 
	 
$tbl.=<<<EOD

	<tr>
		<td>$subjectDescription </td>
		<td align="right">$grades1 </td>
		<td align="center">$letterEquivalent1</td>
		<td align="right">$grades2 </td>
		<td align="center">$letterEquivalent2</td>

		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td> </td>
		<td> </td>
		<td> </td>
		
	</tr>

EOD;
}


$weightedAve1 = number_format(($totalGrades1 / $totalWeight), 2);

$tbl.=<<<EOD

	<tr>
		<td>GRADING SYSTEM AVERAGING </td>
		<td colspan="2" align="right">$weightedAve1</td>
		<td colspan="2" align="right"></td>
		<td colspan="2" align="right"></td>
		<td colspan="2" align="right"></td>
		<td colspan="3" align="right"></td>

	</tr>

EOD;




$tbl.=<<<EOD
		
</table>		
				
EOD;


$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;


$tbl.=<<<EOD
	<table width="100%">
		<tr>
			<td width="50%"><u><b>Legends of Grade</b></u></td>
			<td width="10%"></td>
			<td width="25%"></td>
		</tr>
EOD;

foreach($lE as $index=>$key ) {
	 $descriptor = $lE[$index]->descriptor;
	 $letterEquivalent = $lE[$index]->letterEquivalent;
	 $lowerScale = $lE[$index]->lowerScale;
	 $higherScale = $lE[$index]->higherScale;

$tbl.=<<<EOD
	<tr>
		<td>$descriptor</td>
		<td>($letterEquivalent)</td>
		<td>$lowerScale% - $higherScale%</td>
	</tr>
EOD;
}
	
$tbl.=<<<EOD
	
	</table>
EOD;


$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;




$tbl.=<<<EOD
	<table border="1" width="90%" cellpadding="2px">
		<tr>
			<td width="20%"></td>
			<td align="center">JUN</td>
			<td align="center">JUL</td>
			<td align="center">AUG</td>
			<td align="center">SEP</td>
			<td align="center">OCT</td>
			<td align="center">NOV</td>
			<td align="center">DEC</td>
			<td align="center">JAN</td>
			<td align="center">FEB</td>
			<td align="center">MAR</td>
			<td align="center">APR</td>
			<td align="center">Total</td>
		</tr>
EOD;

$JUN = null;
$JUL = null;
$AUG = null;
$SEP = null;
$OCT = null;
$NOV = null;
$DEC = null;
$JAN = null;
$FEB = null;
$MAR = null;
$APR = null;
$TotalDays = null;
foreach($schoolDays as $index=>$key ) {
	 $JUN = $schoolDays[$index]->JUN;
	 $JUL = $schoolDays[$index]->JUL;
	 $AUG = $schoolDays[$index]->AUG;
	 $SEP = $schoolDays[$index]->SEP;
	 $OCT = $schoolDays[$index]->OCT;
	 $NOV = $schoolDays[$index]->NOV;
	 $DEC = $schoolDays[$index]->DEC;
	 $JAN = $schoolDays[$index]->JAN;
	 $FEB = $schoolDays[$index]->FEB;
	 $MAR = $schoolDays[$index]->MAR;
	 $APR = $schoolDays[$index]->APR;
	 $TotalDays = $JUN + $JUL + $AUG + $SEP + $OCT + $NOV + $DEC + $JAN + $FEB + $MAR + $APR;
	 
}

$tbl.=<<<EOD
	<tr>
			<td>Days of School</td>
			<td align="right">$JUN</td>
			<td align="right">$JUL</td>
			<td align="right">$AUG</td>
			<td align="right">$SEP</td>
			<td align="right">$OCT</td>
			<td align="right">$NOV</td>
			<td align="right">$DEC</td>
			<td align="right">$JAN</td>
			<td align="right">$FEB</td>
			<td align="right">$MAR</td>
			<td align="right">$APR</td>
			<td align="right">$TotalDays</td>
	</tr>
EOD;

$JUNPresent = null;
$JULPresent = null;
$AUGPresent = null;
$SEPPresent = null;
$OCTPresent = null;
$NOVPresent = null;
$DECPresent = null;
$JANPresent = null;
$FEBPresent = null;
$MARPresent = null;
$APRPresent = null;
$TotalDaysPresent = null;
foreach($presentDays as $index=>$key ) {
	 $JUNPresent = $presentDays[$index]->JUN;
	 $JULPresent = $presentDays[$index]->JUL;
	 $AUGPresent = $presentDays[$index]->AUG;
	 $SEPPresent = $presentDays[$index]->SEP;
	 $OCTPresent = $presentDays[$index]->OCT;
	 $NOVPresent = $presentDays[$index]->NOV;
	 $DECPresent = $presentDays[$index]->DEC;
	 $JANPresent = $presentDays[$index]->JAN;
	 $FEBPresent = $presentDays[$index]->FEB;
	 $MARPresent = $presentDays[$index]->MAR;
	 $APRPresent = $presentDays[$index]->APR;
	 $TotalDaysPresent = $JUNPresent + $JULPresent + $AUGPresent + $SEPPresent + $OCTPresent + $NOVPresent + $DECPresent + $JANPresent + $FEBPresent + $MARPresent + $APRPresent;
	 
}


$tbl.=<<<EOD
	<tr>
			<td>Days Present</td>
			<td align="right">$JUNPresent</td>
			<td align="right">$JULPresent</td>
			<td align="right">$AUGPresent</td>
			<td align="right">$SEPPresent</td>
			<td align="right">$OCTPresent</td>
			<td align="right">$NOVPresent</td>
			<td align="right">$DECPresent</td>
			<td align="right">$JANPresent</td>
			<td align="right">$FEBPresent</td>
			<td align="right">$MARPresent</td>
			<td align="right">$APRPresent</td>
			<td align="right">$TotalDaysPresent</td>
	</tr>
	</table>	
EOD;















$tbl.=<<<EOD
</td>
<td width="1%"> </td>
<td width="49%">	
EOD;







$tbl.=<<<EOD
<br><br>
<h3>CHARACTER BUILDING ACTIVITIES </h3>				
<table border="1" width="50%" cellpadding="2px">

<tr align="center">
<td width="60%">TRAITS </td>
<td>1</td>
<td>2</td>
<td>3</td>
<td>4</td>
</tr>
EOD;



foreach($resultsTraits as $index=>$key ) {
	 $traitsDescription = $resultsTraits[$index]->traitsDescription;
	 $traitsScore1 = $resultsTraits[$index]->traitsScore1;

$tbl.=<<<EOD
	<tr>
		<td>$traitsDescription</td>
		<td>$traitsScore1</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
EOD;
}
	

$tbl.=<<<EOD
	
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;


$tbl.=<<<EOD
	<table>
		<tr>
			<td colspan="2" width="100%"><u><b>Guidelines for Character Building Activities</b></u></td>
		</tr>
EOD;

foreach($gD as $index=>$key ) {
	 $descriptor = $gD[$index]->descriptor;
	 $letterEquivalent = $gD[$index]->letterEquivalent;

$tbl.=<<<EOD
	<tr>
		<td>$descriptor</td>
		<td>$letterEquivalent</td>
	</tr>
EOD;
}
	
$tbl.=<<<EOD
	
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td align="center">
			_____________________________<br>
				          ADVISER
			</td>
		</tr>
	</table>
EOD;


$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td align="center"><h3>Eligibility to Transfer</h3>
			</td>
		</tr>
	</table>
EOD;


$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td>
			<h4>
Eligible for transfer and _________________________________<br>
admission to ______________________________________ year.<br>
Has advance units in __________________________________<br>
Lacks units in ________________________________________<br><br>

Date: ______________<br><br>
			
			</h4>
			</td>
		</tr>
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td></td>
		</tr>
	</table>
EOD;

$tbl.=<<<EOD
	<table>
		<tr>
			<td align="center">
			<h3>
				Dr. Juliet A. Demalen<br>
				Principal
			</h3>
			</td>
		</tr>
	</table>
EOD;














	
$tbl.=<<<EOD
	

	</td></tr>
	</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

    

$filename= $studentNumber . $sectionCodeNS . ".pdf"; 
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
