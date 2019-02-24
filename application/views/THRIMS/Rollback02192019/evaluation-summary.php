<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// departmentdepartmentDescription : Example 048 for TCPDF class
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
//$pdf->SetHeaderData(false, false, 'test', false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// set margins
$pdf->SetMargins(10, 10, 10);
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
$pdf->AddPage();

//$pdf->Write(0, 'JOB ORDER #' . $jobOrderNumber , '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);


// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")


$datePrinted=date("m/d/Y");
$timePrinted=date("h:i:sa");

$tbl = <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><b>FACULTY PERFORMANCE EVALUATION ON TEACHING EFFECTIVENESS</b></td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">($sem, School Year $sy)</td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><br></td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD

			<table border="0.5" cellpadding="2" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="15%">Faculty name:</td>
					<td width="55%"><b>$LName, $FName $MName </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b>$datePrinted </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b>$departmentDescription</b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b>$timePrinted </b></td>
				</tr>
			
			</table>
EOD;



$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" width="100%">

			<br><br><br>
EOD;



for($o = 0; $o < 1; $o++) {
	
$tbl .= <<<EOD
				<tr >  
					<td width="3%" colspan="2">	</td>
					<td width="25%" colspan="4">STUDENT EVALUATION</td>
				</tr>
EOD;

	$letter = 'A';
	$total1=0;
	$q=0;

  
	foreach($studentEvalSections as $index=>$key ) {
		$studEvalSectDesc = $studentEvalSections[$index]->SectDesc;
		$studEvalSectID = $studentEvalSections[$index]->SectID;
		$studEvalSectPct = $studentEvalSections[$index]->SectPct;
		$studEvalNoOfQuestions = $studentEvalSections[$index]->NoOfQuestions;

	
		$A1 = substr(($studentEvalSections[$index]->A1), 0, 4);
		$A2 = substr(($studentEvalSections[$index]->A2), 0, 4);
		$A3 = substr(($studentEvalSections[$index]->A3), 0, 4);
		$A4 = substr(($studentEvalSections[$index]->A4), 0, 4);
		$A5 = substr(($studentEvalSections[$index]->A5), 0, 4);
		$A6 = substr(($studentEvalSections[$index]->A6), 0, 4);
		$A7 = substr(($studentEvalSections[$index]->A7), 0, 4);
		$A8 = substr(($studentEvalSections[$index]->A8), 0, 4);
		$A9 = substr(($studentEvalSections[$index]->A9), 0, 4);
		$A10 = substr(($studentEvalSections[$index]->A10), 0, 4);
		$A11 = substr(($studentEvalSections[$index]->A11), 0, 4);
		$A12 = substr(($studentEvalSections[$index]->A12), 0, 4);
		$A13 = substr(($studentEvalSections[$index]->A13), 0, 4);
		$A14 = substr(($studentEvalSections[$index]->A14), 0, 4);
		$A15 = substr(($studentEvalSections[$index]->A15), 0, 4);
		$A16 = substr(($studentEvalSections[$index]->A16), 0, 4);
		$A17 = substr(($studentEvalSections[$index]->A17), 0, 4);
		$A18 = substr(($studentEvalSections[$index]->A18), 0, 4);
		$A19 = substr(($studentEvalSections[$index]->A19), 0, 4);
		$A20 = substr(($studentEvalSections[$index]->A20), 0, 4);
		$A21 = substr(($studentEvalSections[$index]->A21), 0, 4);
		$A22 = substr(($studentEvalSections[$index]->A22), 0, 4);
		$A23 = substr(($studentEvalSections[$index]->A23), 0, 4);
		$A24 = substr(($studentEvalSections[$index]->A24), 0, 4);
		$A25 = substr(($studentEvalSections[$index]->A25), 0, 4);
		$A26 = substr(($studentEvalSections[$index]->A26), 0, 4);
		$A27 = substr(($studentEvalSections[$index]->A27), 0, 4);
		$A28 = substr(($studentEvalSections[$index]->A28), 0, 4);
		$A29 = substr(($studentEvalSections[$index]->A29), 0, 4);
		$A30 = substr(($studentEvalSections[$index]->A30), 0, 4);
		$A31 = substr(($studentEvalSections[$index]->A31), 0, 4);
		$A32 = substr(($studentEvalSections[$index]->A32), 0, 4);
		$A33 = substr(($studentEvalSections[$index]->A33), 0, 4);
		$A34 = substr(($studentEvalSections[$index]->A34), 0, 4);
		$A35 = substr(($studentEvalSections[$index]->A35), 0, 4);
		$A36 = substr(($studentEvalSections[$index]->A36), 0, 4);
		$A37 = substr(($studentEvalSections[$index]->A37), 0, 4);
		$A38 = substr(($studentEvalSections[$index]->A38), 0, 4);
		$A39 = substr(($studentEvalSections[$index]->A39), 0, 4);
		$A40 = substr(($studentEvalSections[$index]->A40), 0, 4);
		$A41 = substr(($studentEvalSections[$index]->A41), 0, 4);
		$A42 = substr(($studentEvalSections[$index]->A42), 0, 4);
		$A43 = substr(($studentEvalSections[$index]->A43), 0, 4);
		$A44 = substr(($studentEvalSections[$index]->A44), 0, 4);
		$A45 = substr(($studentEvalSections[$index]->A45), 0, 4);
		$A46 = substr(($studentEvalSections[$index]->A46), 0, 4);
		$A47 = substr(($studentEvalSections[$index]->A47), 0, 4);
		$A48 = substr(($studentEvalSections[$index]->A48), 0, 4);
		$A49 = substr(($studentEvalSections[$index]->A49), 0, 4);
		$A50 = substr(($studentEvalSections[$index]->A50), 0, 4);
		

		
		$answer = array($A1, $A2, $A3, $A4 ,$A5 ,$A6, $A7,$A8, $A9, $A10, $A11, $A12,$A13,$A14,
		$A15,$A16,$A17,$A18,$A19,$A20,$A21,$A22,$A23,$A24,$A25,$A26,$A27,$A28,$A29,$A30,$A31,$A32,$A33,
		$A34,$A35,$A36,$A37,$A38,$A39,$A40,$A41,$A42,$A43,$A44,$A45,$A46,$A47,$A48,$A49,$A50);


		$output = array_slice($answer, $q,$studEvalNoOfQuestions); 
		$total= substr(array_sum($output)/($studEvalNoOfQuestions), 0, 4);
		$average=substr(number_format((float)$total, 2, '.', ''), 0, 4);
		$percent =substr(($total*$studEvalSectPct/ 100), 0, 4);
		$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
		
		//foreach($studentEvalType as $index=>$key ) {
		//	$studEvalTypeTypePct = $studentEvalType[$index]->TypePct;
		//}
		//$q+=1;
			
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td width="25%">$letter. $studEvalSectDesc</td>
					<td width="40%"></td> 
					<td width="15%"> $average  x   $studEvalSectPct%    =    </td>
					<td width="15%">$totalAverage</td>
				</tr>


EOD;
		if($i == 3) {
	
	
		
			
$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="5"></td>
					<td>
					<table border="1" >
						<tr><td></td></tr>
					</table>	
					</td>
				</tr>

				
EOD;
		} //if($i == 3)
		$q+=$studEvalNoOfQuestions;
		$total1+=$totalAverage;
		$letter++;
	
	

	} //for($i = 0; $i < 4; $i++)
} //for($o = 0; $o < 4; $o++)
		$totalAve=substr(number_format((float)$total1 , 2, '.', ''), 0, 4);
		$percentSumary=substr(($totalAve*$studentEvalType/ 100), 0, 4); 
		$studtotalSumary=substr(number_format((float)$percentSumary , 2, '.', ''), 0, 4);
		
$tbl .= <<<EOD

		
		<tr style="line-height:5%;" > 
			<td colspan="4"></td>
			<td colspan="2">
		<hr />
		</td>
		</tr>

		<tr > 

		<td colspan="5"></td>
		<td colspan="3">
		<table border="1" >
			<tr><td><b>$totalAve x $studentEvalType% = $studtotalSumary </b></td></tr>
		</table>	
		</td>
		</tr>


	
</table>

	
			
EOD;

///-----------------------------------------------------SELF EVALUATION--------------------------------------------------------------------------

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
EOD;


for($o = 0; $o < 1; $o++) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2">	</td>
					<td width="25%" colspan="4">SELF EVALUATION</td>
				</tr>
EOD;
	$letter = 'A';
	$total1=0;
	$q=0;
  
	foreach($selfEvalSections as $index=>$key ) {
		$selfEvalSectDesc = $selfEvalSections[$index]->SectDesc;
		$selfEvalSectID = $selfEvalSections[$index]->SectID;
		$selfEvalSectPct = $selfEvalSections[$index]->SectPct;
		$selfEvalNoOfQuestions = $selfEvalSections[$index]->NoOfQuestions;
		$A1 = substr(($selfEvalSections[$index]->A1), 0, 4);
		$A2 = substr(($selfEvalSections[$index]->A2), 0, 4);
		$A3 = substr(($selfEvalSections[$index]->A3), 0, 4);
		$A4 = substr(($selfEvalSections[$index]->A4), 0, 4);
		$A5 = substr(($selfEvalSections[$index]->A5), 0, 4);
		$A6 = substr(($selfEvalSections[$index]->A6), 0, 4);
		$A7 = substr(($selfEvalSections[$index]->A7), 0, 4);
		$A8 = substr(($selfEvalSections[$index]->A8), 0, 4);
		$A9 = substr(($selfEvalSections[$index]->A9), 0, 4);
		$A10 = substr(($selfEvalSections[$index]->A10), 0, 4);
		$A11 = substr(($selfEvalSections[$index]->A11), 0, 4);
		$A12 = substr(($selfEvalSections[$index]->A12), 0, 4);
		$A13 = substr(($selfEvalSections[$index]->A13), 0, 4);
		$A14 = substr(($selfEvalSections[$index]->A14), 0, 4);
		$A15 = substr(($selfEvalSections[$index]->A15), 0, 4);
		$A16 = substr(($selfEvalSections[$index]->A16), 0, 4);
		$A17 = substr(($selfEvalSections[$index]->A17), 0, 4);
		$A18 = substr(($selfEvalSections[$index]->A18), 0, 4);
		$A19 = substr(($selfEvalSections[$index]->A19), 0, 4);
		$A20 = substr(($selfEvalSections[$index]->A20), 0, 4);
		$A21 = substr(($selfEvalSections[$index]->A21), 0, 4);
		$A22 = substr(($selfEvalSections[$index]->A22), 0, 4);
		$A23 = substr(($selfEvalSections[$index]->A23), 0, 4);
		$A24 = substr(($selfEvalSections[$index]->A24), 0, 4);
		$A25 = substr(($selfEvalSections[$index]->A25), 0, 4);
		$A26 = substr(($selfEvalSections[$index]->A26), 0, 4);
		$A27 = substr(($selfEvalSections[$index]->A27), 0, 4);
		$A28 = substr(($selfEvalSections[$index]->A28), 0, 4);
		$A29 = substr(($selfEvalSections[$index]->A29), 0, 4);
		$A30 = substr(($selfEvalSections[$index]->A30), 0, 4);
		$A31 = substr(($selfEvalSections[$index]->A31), 0, 4);
		$A32 = substr(($selfEvalSections[$index]->A32), 0, 4);
		$A33 = substr(($selfEvalSections[$index]->A33), 0, 4);
		$A34 = substr(($selfEvalSections[$index]->A34), 0, 4);
		$A35 = substr(($selfEvalSections[$index]->A35), 0, 4);
		$A36 = substr(($selfEvalSections[$index]->A36), 0, 4);
		$A37 = substr(($selfEvalSections[$index]->A37), 0, 4);
		$A38 = substr(($selfEvalSections[$index]->A38), 0, 4);
		$A39 = substr(($selfEvalSections[$index]->A39), 0, 4);
		$A40 = substr(($selfEvalSections[$index]->A40), 0, 4);
		$A41 = substr(($selfEvalSections[$index]->A41), 0, 4);
		$A42 = substr(($selfEvalSections[$index]->A42), 0, 4);
		$A43 = substr(($selfEvalSections[$index]->A43), 0, 4);
		$A44 = substr(($selfEvalSections[$index]->A44), 0, 4);
		$A45 = substr(($selfEvalSections[$index]->A45), 0, 4);
		$A46 = substr(($selfEvalSections[$index]->A46), 0, 4);
		$A47 = substr(($selfEvalSections[$index]->A47), 0, 4);
		$A48 = substr(($selfEvalSections[$index]->A48), 0, 4);
		$A49 = substr(($selfEvalSections[$index]->A49), 0, 4);
		$A50 = substr(($selfEvalSections[$index]->A50), 0, 4);
		
		
		
		$answer = array($A1, $A2, $A3, $A4 ,$A5 ,$A6, $A7,$A8, $A9, $A10, $A11, $A12,$A13,$A14,
		$A15,$A16,$A17,$A18,$A19,$A20,$A21,$A22,$A23,$A24,$A25,$A26,$A27,$A28,$A29,$A30,$A31,$A32,$A33,
		$A34,$A35,$A36,$A37,$A38,$A39,$A40,$A41,$A42,$A43,$A44,$A45,$A46,$A47,$A48,$A49,$A50);


		$output = array_slice($answer, $q,$selfEvalNoOfQuestions); 
		$total= substr(array_sum($output)/($selfEvalNoOfQuestions), 0, 4);
		$average=substr(number_format((float)$total, 2, '.', ''), 0, 4);
		$percent =substr(($total*$selfEvalSectPct/ 100), 0, 4);
		$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
		


		
	//for($i = 0; $i < 4; $i++) {

		
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td width="30%">$letter. $selfEvalSectDesc</td>
					<td width="35%"></td>
					<td width="15%">$average  x  $selfEvalSectPct%  =  </td>
					<td width="15%">$totalAverage</td>
				</tr>
EOD;
		if($i == 3) {


$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="5"></td>
					<td>
					<table border="1" >
						<tr><td></td></tr>
					</table>	
					</td>
				</tr>
EOD;
		} //if($i == 3)

		$q+=$selfEvalNoOfQuestions;
		$total1+=$totalAverage;
		$letter++;		
	} //for($i = 0; $i < 4; $i++)
} //for($o = 0; $o < 4; $o++)
$totalAve=substr(number_format((float)$total1 , 2, '.', ''), 0, 4);
$percentSumary=substr(($totalAve*$selfEvalType/ 100), 0, 4); 
$selftotalSumary=substr(number_format((float)$percentSumary , 2, '.', ''), 0, 4);
$tbl .= <<<EOD
		<tr style="line-height:5%;" > 
			<td colspan="4"></td>
			<td colspan="2">
		<hr />
		</td>
		</tr>

		<tr > 
		
		<td colspan="5"></td>
		<td>
		<table border="1" >
			<tr><td><b>$totalAve x $selfEvalType% = $selftotalSumary</b></td></tr>
		</table>	
		</td>
		</tr>

			</table>
EOD;



///-----------------------------------------------------DEPARTMENT EVALUATION--------------------------------------------------------------------------

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
EOD;


for($o = 0; $o < 1; $o++) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2">	</td>
					<td width="25%" colspan="4">DEPARTMENT EVALUATION</td>
				</tr>
EOD;
	$letter = 'A';
	$total1=0;
	$q=0;
	foreach($dhEvalSections as $index=>$key ) {
		$dhEvalSectDesc = $dhEvalSections[$index]->SectDesc;
		$dhEvalSectID = $dhEvalSections[$index]->SectID;
		$dhEvalSectPct = $dhEvalSections[$index]->SectPct;
		$dhEvalNoOfQuestions = $dhEvalSections[$index]->NoOfQuestions;
		$A1 = substr(($dhEvalSections[$index]->A1), 0, 4);
		$A2 = substr(($dhEvalSections[$index]->A2), 0, 4);
		$A3 = substr(($dhEvalSections[$index]->A3), 0, 4);
		$A4 = substr(($dhEvalSections[$index]->A4), 0, 4);
		$A5 = substr(($dhEvalSections[$index]->A5), 0, 4);
		$A6 = substr(($dhEvalSections[$index]->A6), 0, 4);
		$A7 = substr(($dhEvalSections[$index]->A7), 0, 4);
		$A8 = substr(($dhEvalSections[$index]->A8), 0, 4);
		$A9 = substr(($dhEvalSections[$index]->A9), 0, 4);
		$A10 = substr(($dhEvalSections[$index]->A10), 0, 4);
		$A11 = substr(($dhEvalSections[$index]->A11), 0, 4);
		$A12 = substr(($dhEvalSections[$index]->A12), 0, 4);
		$A13 = substr(($dhEvalSections[$index]->A13), 0, 4);
		$A14 = substr(($dhEvalSections[$index]->A14), 0, 4);
		$A15 = substr(($dhEvalSections[$index]->A15), 0, 4);
		$A16 = substr(($dhEvalSections[$index]->A16), 0, 4);
		$A17 = substr(($dhEvalSections[$index]->A17), 0, 4);
		$A18 = substr(($dhEvalSections[$index]->A18), 0, 4);
		$A19 = substr(($dhEvalSections[$index]->A19), 0, 4);
		$A20 = substr(($dhEvalSections[$index]->A20), 0, 4);
		$A21 = substr(($dhEvalSections[$index]->A21), 0, 4);
		$A22 = substr(($dhEvalSections[$index]->A22), 0, 4);
		$A23 = substr(($dhEvalSections[$index]->A23), 0, 4);
		$A24 = substr(($dhEvalSections[$index]->A24), 0, 4);
		$A25 = substr(($dhEvalSections[$index]->A25), 0, 4);
		$A26 = substr(($dhEvalSections[$index]->A26), 0, 4);
		$A27 = substr(($dhEvalSections[$index]->A27), 0, 4);
		$A28 = substr(($dhEvalSections[$index]->A28), 0, 4);
		$A29 = substr(($dhEvalSections[$index]->A29), 0, 4);
		$A30 = substr(($dhEvalSections[$index]->A30), 0, 4);
		$A31 = substr(($dhEvalSections[$index]->A31), 0, 4);
		$A32 = substr(($dhEvalSections[$index]->A32), 0, 4);
		$A33 = substr(($dhEvalSections[$index]->A33), 0, 4);
		$A34 = substr(($dhEvalSections[$index]->A34), 0, 4);
		$A35 = substr(($dhEvalSections[$index]->A35), 0, 4);
		$A36 = substr(($dhEvalSections[$index]->A36), 0, 4);
		$A37 = substr(($dhEvalSections[$index]->A37), 0, 4);
		$A38 = substr(($dhEvalSections[$index]->A38), 0, 4);
		$A39 = substr(($dhEvalSections[$index]->A39), 0, 4);
		$A40 = substr(($dhEvalSections[$index]->A40), 0, 4);
		$A41 = substr(($dhEvalSections[$index]->A41), 0, 4);
		$A42 = substr(($dhEvalSections[$index]->A42), 0, 4);
		$A43 = substr(($dhEvalSections[$index]->A43), 0, 4);
		$A44 = substr(($dhEvalSections[$index]->A44), 0, 4);
		$A45 = substr(($dhEvalSections[$index]->A45), 0, 4);
		$A46 = substr(($dhEvalSections[$index]->A46), 0, 4);
		$A47 = substr(($dhEvalSections[$index]->A47), 0, 4);
		$A48 = substr(($dhEvalSections[$index]->A48), 0, 4);
		$A49 = substr(($dhEvalSections[$index]->A49), 0, 4);
		$A50 = substr(($dhEvalSections[$index]->A50), 0, 4);
		
		

		$answer = array($A1, $A2, $A3, $A4 ,$A5 ,$A6, $A7,$A8, $A9, $A10, $A11, $A12,$A13,$A14,
		$A15,$A16,$A17,$A18,$A19,$A20,$A21,$A22,$A23,$A24,$A25,$A26,$A27,$A28,$A29,$A30,$A31,$A32,$A33,
		$A34,$A35,$A36,$A37,$A38,$A39,$A40,$A41,$A42,$A43,$A44,$A45,$A46,$A47,$A48,$A49,$A50);


		$output = array_slice($answer, $q,$dhEvalNoOfQuestions); 
		$total= substr(array_sum($output)/($dhEvalNoOfQuestions), 0, 4);
		$average=substr(number_format((float)$total, 2, '.', ''), 0, 4);
		$percent =substr(($total*$dhEvalSectPct/ 100), 0, 4);
		$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
			
	//for($i = 0; $i < 4; $i++) {

		
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td width="30%">$letter. $dhEvalSectDesc</td>
					<td width="35%"></td>
					<td width="15%">$average  x  $dhEvalSectPct%  = </td>
					<td width="15%">$totalAverage</td>
				</tr>
EOD;
		if($i == 3) {


$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="5"></td>
					<td>
					<table border="1" >
						<tr><td></td></tr>
					</table>	
					</td>
				</tr>

				
				
EOD;
		} //if($i == 3)
		$q+=$dhEvalNoOfQuestions;
		$total1+=$totalAverage;
	$letter++;		
	} //for($i = 0; $i < 4; $i++)
} //for($o = 0; $o < 4; $o++)
$totalAve=substr(number_format((float)$total1 , 2, '.', ''), 0, 4);
$percentSumary=substr(($totalAve*$dhEvalType/ 100), 0, 4); 
$dhtotalSumary=substr(number_format((float)$percentSumary , 2, '.', ''), 0, 4);
	
$tbl .= <<<EOD
		<tr style="line-height:5%;" > 
		<td colspan="4"></td>
		<td colspan="2">
		<hr />
		</td>
		</tr>

		<tr > 

		<td colspan="5"></td>
		<td>
		<table border="1" >
			<tr><td><b>$totalAve x $dhEvalType% = $dhtotalSumary</b></td></tr>
		</table>	
		</td>
		</tr>
		
	</table>
		
EOD;



///-----------------------------------------------------DEANS EVALUATION--------------------------------------------------------------------------

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
EOD;


for($o = 0; $o < 1; $o++) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2">	</td>
					<td width="25%" colspan="4">DEANS EVALUATION</td>
				</tr>
EOD;
	$letter = 'A';
	$total1=0;
	$q=0;
	
	foreach($deanEvalSections as $index=>$key ) {
		$deanEvalSectDesc = $deanEvalSections[$index]->SectDesc;
		$deanEvalSectID = $deanEvalSections[$index]->SectID;
		$deanEvalSectPct = $deanEvalSections[$index]->SectPct;
		$deanEvalNoOfQuestions = $deanEvalSections[$index]->NoOfQuestions;
		$A1 = substr(($deanEvalSections[$index]->A1), 0, 4);
		$A2 = substr(($deanEvalSections[$index]->A2), 0, 4);
		$A3 = substr(($deanEvalSections[$index]->A3), 0, 4);
		$A4 = substr(($deanEvalSections[$index]->A4), 0, 4);
		$A5 = substr(($deanEvalSections[$index]->A5), 0, 4);
		$A6 = substr(($deanEvalSections[$index]->A6), 0, 4);
		$A7 = substr(($deanEvalSections[$index]->A7), 0, 4);
		$A8 = substr(($deanEvalSections[$index]->A8), 0, 4);
		$A9 = substr(($deanEvalSections[$index]->A9), 0, 4);
		$A10 = substr(($deanEvalSections[$index]->A10), 0, 4);
		$A11 = substr(($deanEvalSections[$index]->A11), 0, 4);
		$A12 = substr(($deanEvalSections[$index]->A12), 0, 4);
		$A13 = substr(($deanEvalSections[$index]->A13), 0, 4);
		$A14 = substr(($deanEvalSections[$index]->A14), 0, 4);
		$A15 = substr(($deanEvalSections[$index]->A15), 0, 4);
		$A16 = substr(($deanEvalSections[$index]->A16), 0, 4);
		$A17 = substr(($deanEvalSections[$index]->A17), 0, 4);
		$A18 = substr(($deanEvalSections[$index]->A18), 0, 4);
		$A19 = substr(($deanEvalSections[$index]->A19), 0, 4);
		$A20 = substr(($deanEvalSections[$index]->A20), 0, 4);
		$A21 = substr(($deanEvalSections[$index]->A21), 0, 4);
		$A22 = substr(($deanEvalSections[$index]->A22), 0, 4);
		$A23 = substr(($deanEvalSections[$index]->A23), 0, 4);
		$A24 = substr(($deanEvalSections[$index]->A24), 0, 4);
		$A25 = substr(($deanEvalSections[$index]->A25), 0, 4);
		$A26 = substr(($deanEvalSections[$index]->A26), 0, 4);
		$A27 = substr(($deanEvalSections[$index]->A27), 0, 4);
		$A28 = substr(($deanEvalSections[$index]->A28), 0, 4);
		$A29 = substr(($deanEvalSections[$index]->A29), 0, 4);
		$A30 = substr(($deanEvalSections[$index]->A30), 0, 4);
		$A31 = substr(($deanEvalSections[$index]->A31), 0, 4);
		$A32 = substr(($deanEvalSections[$index]->A32), 0, 4);
		$A33 = substr(($deanEvalSections[$index]->A33), 0, 4);
		$A34 = substr(($deanEvalSections[$index]->A34), 0, 4);
		$A35 = substr(($deanEvalSections[$index]->A35), 0, 4);
		$A36 = substr(($deanEvalSections[$index]->A36), 0, 4);
		$A37 = substr(($deanEvalSections[$index]->A37), 0, 4);
		$A38 = substr(($deanEvalSections[$index]->A38), 0, 4);
		$A39 = substr(($deanEvalSections[$index]->A39), 0, 4);
		$A40 = substr(($deanEvalSections[$index]->A40), 0, 4);
		$A41 = substr(($deanEvalSections[$index]->A41), 0, 4);
		$A42 = substr(($deanEvalSections[$index]->A42), 0, 4);
		$A43 = substr(($deanEvalSections[$index]->A43), 0, 4);
		$A44 = substr(($deanEvalSections[$index]->A44), 0, 4);
		$A45 = substr(($deanEvalSections[$index]->A45), 0, 4);
		$A46 = substr(($deanEvalSections[$index]->A46), 0, 4);
		$A47 = substr(($deanEvalSections[$index]->A47), 0, 4);
		$A48 = substr(($deanEvalSections[$index]->A48), 0, 4);
		$A49 = substr(($deanEvalSections[$index]->A49), 0, 4);
		$A50 = substr(($deanEvalSections[$index]->A50), 0, 4);


	//for($i = 0; $i < 4; $i++) {
		$answer = array($A1, $A2, $A3, $A4 ,$A5 ,$A6, $A7,$A8, $A9, $A10, $A11, $A12,$A13,$A14,
		$A15,$A16,$A17,$A18,$A19,$A20,$A21,$A22,$A23,$A24,$A25,$A26,$A27,$A28,$A29,$A30,$A31,$A32,$A33,
		$A34,$A35,$A36,$A37,$A38,$A39,$A40,$A41,$A42,$A43,$A44,$A45,$A46,$A47,$A48,$A49,$A50);

		$output = array_slice($answer, $q,$deanEvalNoOfQuestions); 
		$total= substr(array_sum($output)/($deanEvalNoOfQuestions), 0, 4);
		$average=substr(number_format((float)$total, 2, '.', ''), 0, 4);
		$percent =substr(($total*$deanEvalSectPct/ 100), 0, 4);
		$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
		
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td width="30%">$letter. $deanEvalSectDesc</td>
					<td width="35%"></td>
					<td width="15%">$average  x  $deanEvalSectPct%  = </td>
					<td width="15%">$totalAverage</td>
				</tr>
EOD;
		if($i == 3) {


$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="5"></td>
					<td>
					<table border="1" >
						<tr><td></td></tr>
					</table>	
					</td>
				</tr>
				
EOD;

		} //if($i == 3)
		$q+=$deanEvalNoOfQuestions;
		$total1+=$totalAverage;
	$letter++;		
	} //for($i = 0; $i < 4; $i++)
} //for($o = 0; $o < 4; $o++)
$totalAve=substr(number_format((float)$total1 , 2, '.', ''), 0, 4);

$percentSumary=substr(($totalAve*$deanEvalType/ 100), 0, 4); 
$deantotalSumary=substr(number_format((float)$percentSumary , 2, '.', ''), 0, 4);
	
$tbl .= <<<EOD
		<tr style="line-height:5%;" > 
		<td colspan="4"></td>
		<td colspan="2">
		<hr />
		</td>
		</tr>

		<tr > 

		<td colspan="5"></td>
		<td>
		<table border="1" >
			<tr><td><b>$totalAve x $deanEvalType% = $deantotalSumary</b></td></tr>
		</table>	
		</td>
		</tr>

		</table>
EOD;

$overallRating=($studtotalSumary+$selftotalSumary+$dhtotalSumary+$deantotalSumary);


if($overallRating >= 4.50)
{
	$ratingdesc = "Excellent";
}
elseif($overallRating < 4.50 AND $overallRating >= 4.00)
{
	$ratingdesc = "Very Satisfactory";
}
elseif($overallRating < 4.00 AND $overallRating >= 3.00)
{
	$ratingdesc = "Satisfactory";
}
elseif($overallRating < 3.00 AND $overallRating >= 2.00)
{
	$ratingdesc = "Needs Improvement";
}
elseif($overallRating < 2.00 AND $overallRating >= 1.00)
{
	$ratingdesc = "Poor";
}


$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr>
					<td width="60%"> 
						<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%">
								<table border="0" cellpadding="0" cellspacing="0" nobr="true" width="100%">
									<tr>
										<td colspan="5">
											<font size="6px"> Legend</font>
										</td>
									</tr>
									
									<tr>
										<td >
										</td>
										<td colspan="2">
											<font size="6px"><b>Descriptive Rating</b></font>
										</td>
										<td colspan="2">
											<font size="6px"><b>Weight Equivalent</b></font>
										</td>
									</tr>

									<tr>
										<td >
										</td>
										<td colspan="2">
											<font size="6px">Excellent</font>
										</td>
										<td colspan="2">
											<font size="6px">4.50 - 5.00</font>
										</td>
									</tr>

									<tr>
										<td >
										</td>
										<td colspan="2">
											<font size="6px">Very Satisfactory</font>
										</td>
										<td colspan="2">
											<font size="6px">4.00 - 4.49</font>
										</td>
									</tr>

									<tr>
										<td >
										</td>
										<td colspan="2">
											<font size="6px">Satisfactory </font>
										</td>
										<td colspan="2">
											<font size="6px">3.00 - 3.99</font>
										</td>
									</tr>

									<tr>
										<td >
										</td>
										<td colspan="2">
											<font size="6px">Needs Improvement</font>
										</td>
										<td colspan="2">
											<font size="6px">2.00 - 2.99</font>
										</td>
									</tr>

									<tr>
										<td >
										</td>
										<td colspan="2">
											<font size="6px">Poor</font>
										</td>
										<td colspan="2">
											<font size="6px">1.00 - 1.99</font>
										</td>
									</tr>
								</table>
						</table>
					</td>


					<td width="23%"> </td>
					
					<td width="17%"> 
						<table border="1" >
							<tr><td><b>Overall Rating = $overallRating </b></td></tr>
						</table>	
						
						<table>
							<tr><td><br><br><br><br></td></tr>
							<tr>
								<td align="center">
									<u><b>Dr. Wilfred U. Tiu</b></u><br><i>President</i>
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
			</table>
EOD;


$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td colspan="4"><font size="10px"> <br><br><br>
						Please be advised that you have been rated <b>$ratingdesc</b> in the FACULTY PERFORMANCE EVALUATION.
						The following is the summary of your ratings. </font>
					</td>
				</tr>
			</table>
EOD;

$tbl .= <<<EOD
			<table width="100%">
			
				<tr><td colspan="3"><br><hr /><b align="center">Acknowledgement</b></td></tr>		
				<tr>
					<td colspan="3"> 
						<font size="7px">This is to acknowledge that I have received a copy of my performance evaluation, and that it was discussed with me by my Dean / Department Head.</font>
					</td>
				</tr>

				<tr>
					<td>
						<br><br><hr /><i align="center">Signature over printed name</i>
					</td>
					<td></td>
					<td>
						<br><br><hr /><i align="center">Date</i>
					</td>
				</tr>
				
				<tr>
				<td colspan="3">
				<br><font size="7px"><i>
				cc: Dean<br>HRD
				</i></font>
				</td>
				</tr>
			</table>
			
EOD;

///----------------------------------------STUDENT EVALUATION-----------------------------------------------------------------------
$tbl .= <<<EOD
<br pagebreak="true"/>
EOD;
$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px"><b>TRINITY UNIVERSITY OF ASIA</b></font></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px">Cathedral Heights, 275 E. Rodriguez, Sr. Avenue, Quezon City</font> </td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><b>STUDENT EVALUATION</b></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">FACULTY PERFORMANCE EVALUATION ON TEACHING EFFECTIVENESS</td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">($sem, School Year $sy)</td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><br></td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0.5" cellpadding="2" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="15%">Faculty name:</td>
					<td width="55%"><b>$LName, $FName $MName </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b>$datePrinted </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b>$departmentDescription </b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b>$timePrinted </b></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td><br>
					</td>
				</tr>
			</table>
EOD;


$studEvalLetterSect = 'A';

foreach($studentEvalSections as $index=>$key ) {
	$studEvalSectDesc = $studentEvalSections[$index]->SectDesc;
	$studEvalSectID = $studentEvalSections[$index]->SectID;
	$studEvalSectPct = $studentEvalSections[$index]->SectPct;
	$studEvalNoOfQuestions = $studentEvalSections[$index]->NoOfQuestions;
	
	$A1 = substr(($studentEvalSections[$index]->A1), 0, 4);
	$A2 = substr(($studentEvalSections[$index]->A2), 0, 4);
	$A3 = substr(($studentEvalSections[$index]->A3), 0, 4);
	$A4 = substr(($studentEvalSections[$index]->A4), 0, 4);
	$A5 = substr(($studentEvalSections[$index]->A5), 0, 4);
	$A6 = substr(($studentEvalSections[$index]->A6), 0, 4);
	$A7 = substr(($studentEvalSections[$index]->A7), 0, 4);
	$A8 = substr(($studentEvalSections[$index]->A8), 0, 4);
	$A9 = substr(($studentEvalSections[$index]->A9), 0, 4);
	$A10 = substr(($studentEvalSections[$index]->A10), 0, 4);
	$A11 = substr(($studentEvalSections[$index]->A11), 0, 4);
	$A12 = substr(($studentEvalSections[$index]->A12), 0, 4);
	$A13 = substr(($studentEvalSections[$index]->A13), 0, 4);
	$A14 = substr(($studentEvalSections[$index]->A14), 0, 4);
	$A15 = substr(($studentEvalSections[$index]->A15), 0, 4);
	$A16 = substr(($studentEvalSections[$index]->A16), 0, 4);
	$A17 = substr(($studentEvalSections[$index]->A17), 0, 4);
	$A18 = substr(($studentEvalSections[$index]->A18), 0, 4);
	$A19 = substr(($studentEvalSections[$index]->A19), 0, 4);
	$A20 = substr(($studentEvalSections[$index]->A20), 0, 4);
	$A21 = substr(($studentEvalSections[$index]->A21), 0, 4);
	$A22 = substr(($studentEvalSections[$index]->A22), 0, 4);
	$A23 = substr(($studentEvalSections[$index]->A23), 0, 4);
	$A24 = substr(($studentEvalSections[$index]->A24), 0, 4);
	$A25 = substr(($studentEvalSections[$index]->A25), 0, 4);
	$A26 = substr(($studentEvalSections[$index]->A26), 0, 4);
	$A27 = substr(($studentEvalSections[$index]->A27), 0, 4);
	$A28 = substr(($studentEvalSections[$index]->A28), 0, 4);
	$A29 = substr(($studentEvalSections[$index]->A29), 0, 4);
	$A30 = substr(($studentEvalSections[$index]->A30), 0, 4);
	$A31 = substr(($studentEvalSections[$index]->A31), 0, 4);
	$A32 = substr(($studentEvalSections[$index]->A32), 0, 4);
	$A33 = substr(($studentEvalSections[$index]->A33), 0, 4);
	$A34 = substr(($studentEvalSections[$index]->A34), 0, 4);
	$A35 = substr(($studentEvalSections[$index]->A35), 0, 4);
	$A36 = substr(($studentEvalSections[$index]->A36), 0, 4);
	$A37 = substr(($studentEvalSections[$index]->A37), 0, 4);
	$A38 = substr(($studentEvalSections[$index]->A38), 0, 4);
	$A39 = substr(($studentEvalSections[$index]->A39), 0, 4);
	$A40 = substr(($studentEvalSections[$index]->A40), 0, 4);
	$A41 = substr(($studentEvalSections[$index]->A41), 0, 4);
	$A42 = substr(($studentEvalSections[$index]->A42), 0, 4);
	$A43 = substr(($studentEvalSections[$index]->A43), 0, 4);
	$A44 = substr(($studentEvalSections[$index]->A44), 0, 4);
	$A45 = substr(($studentEvalSections[$index]->A45), 0, 4);
	$A46 = substr(($studentEvalSections[$index]->A46), 0, 4);
	$A47 = substr(($studentEvalSections[$index]->A47), 0, 4);
	$A48 = substr(($studentEvalSections[$index]->A48), 0, 4);
	$A49 = substr(($studentEvalSections[$index]->A49), 0, 4);
	$A50 = substr(($studentEvalSections[$index]->A50), 0, 4);		
		
	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$studEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$studEvalSectDesc </b></font></td>
				</tr>
EOD;
$noquestion=0;
$total=0;
	foreach($studentEvalItems as $index=>$key ) {
		$studEvalItemIteIndex = $studentEvalItems[$index]->iteIndex;
		$studEvalItemItePrefix = $studentEvalItems[$index]->itePrefix;
		$studEvalItemIteText = $studentEvalItems[$index]->iteText;
		$studEvalItemCriIndex = $studentEvalItems[$index]->criIndex;
		
			if($studEvalSectID == $studEvalItemCriIndex ) {
				
				if ($studEvalItemIteIndex==1) {
					//$Ans=substr((float)number_format($A1, 3, '.', ''), 0, 4);
					$Ans=substr(($A1), 0, 4);
				} elseif ($studEvalItemIteIndex==2) {
					$Ans=substr(($A2), 0, 4);
				} elseif ($studEvalItemIteIndex==3) {
					$Ans=substr(($A3), 0, 4);
				} elseif ($studEvalItemIteIndex==4) {
					$Ans=substr(($A4), 0, 4);
				} elseif ($studEvalItemIteIndex==5) {
					$Ans=substr(($A5), 0, 4);
				} elseif ($studEvalItemIteIndex==6) {
					$Ans=substr(($A6), 0, 4);
				} elseif ($studEvalItemIteIndex==7) {
					$Ans=substr(($A7), 0, 4);
				} elseif ($studEvalItemIteIndex==8) {
					$Ans=substr(($A8), 0, 4);
				} elseif ($studEvalItemIteIndex==9) {
					$Ans=substr(($A9), 0, 4);
				} elseif ($studEvalItemIteIndex==10) {
					$Ans=substr(($A10), 0, 4);
				} elseif ($studEvalItemIteIndex==11) {
					$Ans=substr(($A11), 0, 4);
				} elseif ($studEvalItemIteIndex==12) {
					$Ans=substr(($A12), 0, 4);
				} elseif ($studEvalItemIteIndex==13) {
					$Ans=substr(($A13), 0, 4);
				} elseif ($studEvalItemIteIndex==14) {
					$Ans=substr(($A14), 0, 4);
				} elseif ($studEvalItemIteIndex==15) {
					$Ans=substr(($A15), 0, 4);
				} elseif ($studEvalItemIteIndex==16) {
					$Ans=substr(($A16), 0, 4);
				} elseif ($studEvalItemIteIndex==17) {
					$Ans=substr(($A17), 0, 4);
				} elseif ($studEvalItemIteIndex==18) {
					$Ans=substr(($A18), 0, 4);
				} elseif ($studEvalItemIteIndex==19) {
					$Ans=substr(($A19), 0, 4);
				} elseif ($studEvalItemIteIndex==20) {
					$Ans=substr(($A20), 0, 4);
				} elseif ($studEvalItemIteIndex==21) {
					$Ans=substr(($A21), 0, 4);
				} elseif ($studEvalItemIteIndex==22) {
					$Ans=substr(($A22), 0, 4);
				} elseif ($studEvalItemIteIndex==23) {
					$Ans=substr(($A23), 0, 4);
				} elseif ($studEvalItemIteIndex==24) {
					$Ans=substr(($A24), 0, 4);
				} elseif ($studEvalItemIteIndex==25) {
					$Ans=substr(($A25), 0, 4);
				} elseif ($studEvalItemIteIndex==26) {
					$Ans=substr(($A26), 0, 4);
				} elseif ($studEvalItemIteIndex==27) {
					$Ans=substr(($A27), 0, 4);
				} elseif ($studEvalItemIteIndex==28) {
					$Ans=substr(($A28), 0, 4);
				} elseif ($studEvalItemIteIndex==29) {
					$Ans=substr(($A29), 0, 4);
				} elseif ($studEvalItemIteIndex==30) {
					$Ans=substr(($A30), 0, 4);
				} elseif ($studEvalItemIteIndex==31) {
					$Ans=substr(($A31), 0, 4);
				} elseif ($studEvalItemIteIndex==32) {
					$Ans=substr(($A32), 0, 4);
				} elseif ($studEvalItemIteIndex==33) {
					$Ans=substr(($A33), 0, 4);
				} elseif ($studEvalItemIteIndex==34) {
					$Ans=substr(($A34), 0, 4);
				} elseif ($studEvalItemIteIndex==35) {
					$Ans=substr(($A35), 0, 4);
				} elseif ($studEvalItemIteIndex==36) {
					$Ans=substr(($A36), 0, 4);
				} elseif ($studEvalItemIteIndex==37) {
					$Ans=substr(($A37), 0, 4);
				} elseif ($studEvalItemIteIndex==38) {
					$Ans=substr(($A38), 0, 4);
				} elseif ($studEvalItemIteIndex==39) {
					$Ans=substr(($A39), 0, 4);
				} elseif ($studEvalItemIteIndex==40) {
					$Ans=substr(($A40), 0, 4);
				} elseif ($studEvalItemIteIndex==41) {
					$Ans=substr(($A41), 0, 4);
				} elseif ($studEvalItemIteIndex==42) {
					$Ans=substr(($A42), 0, 4);
				} elseif ($studEvalItemIteIndex==43) {
					$Ans=substr(($A43), 0, 4);
				} elseif ($studEvalItemIteIndex==44) {
					$Ans=substr(($A44), 0, 4);
				} elseif ($studEvalItemIteIndex==45) {
					$Ans=substr(($A45), 0, 4);
				} elseif ($studEvalItemIteIndex==46) {
					$Ans=substr(($A46), 0, 4);
				} elseif ($studEvalItemIteIndex==47) {
					$Ans=substr(($A47), 0, 4);
				} elseif ($studEvalItemIteIndex==48) {
					$Ans=substr(($A48), 0, 4);
				} elseif ($studEvalItemIteIndex==49) {
					$Ans=substr(($A49), 0, 4);
				} elseif ($studEvalItemIteIndex==50) {
					$Ans=substr(($A50), 0, 4);
				} else {
					$Ans=0;
				}
			
				$Ans_=substr(number_format((float)$Ans, 2, '.', ''), 0, 4);
				$noquestion++;	
			
				
$tbl .= <<<EOD

				<tr > 
					<td width="3%">$EvalID</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$studEvalItemItePrefix $studEvalItemIteText</td>
					<td width="10%">$Ans_</td>
					<td width="10%"></td>
				</tr>
EOD;

			$nototal=$total+=$Ans;
			$totalquestion=substr(($nototal/$noquestion), 0, 4);
			$percent =substr(($totalquestion*$studEvalSectPct/ 100), 0, 4);
			$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
			}
			
	} //for($i = 0; $i < 4; $i++)
	
	$totalNoQuestion=substr(number_format((float)$totalquestion , 2, '.', ''), 0, 4);
	
$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				
				<tr > 
					<td colspan="4"></td>
					<td colspan="2">
					<table border="1" >
						<tr><td><b>$totalNoQuestion     x     $studEvalSectPct%   $totalAverage</b></td></tr>
		
					</table>	
					</td>
				</tr>
EOD;
	
	
	
	$studEvalLetterSect++;	
	
} //for($o = 0; $o < 4; $o++)

$tbl .= <<<EOD
				
			</table>
EOD;
///-----------------------------------------------------STUDENT EVALUATION-----------------------------------------------------------------------


///-----------------------------------------------------SELF EVALUATION--------------------------------------------------------------------------
EOD;
$tbl .= <<<EOD
<br pagebreak="true"/>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px"><b>TRINITY UNIVERSITY OF ASIA</b></font></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px">Cathedral Heights, 275 E. Rodriguez, Sr. Avenue, Quezon City</font> </td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><b>SELF EVALUATION</b></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">FACULTY PERFORMANCE EVALUATION ON TEACHING EFFECTIVENESS</td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">($sem, School Year $sy)</td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><br></td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0.5" cellpadding="2" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="15%">Faculty name:</td>
					<td width="55%"><b>$LName, $FName $MName  </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b>$datePrinted</b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b>$departmentDescription</b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b>$timePrinted </b></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td><br>
					</td>
				</tr>
			</table>
EOD;


$selfEvalLetterSect = 'A';
foreach($selfEvalSections as $index=>$key ) {
	$selfEvalSectDesc = $selfEvalSections[$index]->SectDesc;
	$selfEvalSectID = $selfEvalSections[$index]->SectID;
	$selfEvalSectPct = $selfEvalSections[$index]->SectPct;
	$selfEvalNoOfQuestions = $selfEvalSections[$index]->NoOfQuestions;

	$A1 = substr(($selfEvalSections[$index]->A1), 0, 4);
	$A2 = substr(($selfEvalSections[$index]->A2), 0, 4);
	$A3 = substr(($selfEvalSections[$index]->A3), 0, 4);
	$A4 = substr(($selfEvalSections[$index]->A4), 0, 4);
	$A5 = substr(($selfEvalSections[$index]->A5), 0, 4);
	$A6 = substr(($selfEvalSections[$index]->A6), 0, 4);
	$A7 = substr(($selfEvalSections[$index]->A7), 0, 4);
	$A8 = substr(($selfEvalSections[$index]->A8), 0, 4);
	$A9 = substr(($selfEvalSections[$index]->A9), 0, 4);
	$A10 = substr(($selfEvalSections[$index]->A10), 0, 4);
	$A11 = substr(($selfEvalSections[$index]->A11), 0, 4);
	$A12 = substr(($selfEvalSections[$index]->A12), 0, 4);
	$A13 = substr(($selfEvalSections[$index]->A13), 0, 4);
	$A14 = substr(($selfEvalSections[$index]->A14), 0, 4);
	$A15 = substr(($selfEvalSections[$index]->A15), 0, 4);
	$A16 = substr(($selfEvalSections[$index]->A16), 0, 4);
	$A17 = substr(($selfEvalSections[$index]->A17), 0, 4);
	$A18 = substr(($selfEvalSections[$index]->A18), 0, 4);
	$A19 = substr(($selfEvalSections[$index]->A19), 0, 4);
	$A20 = substr(($selfEvalSections[$index]->A20), 0, 4);
	$A21 = substr(($selfEvalSections[$index]->A21), 0, 4);
	$A22 = substr(($selfEvalSections[$index]->A22), 0, 4);
	$A23 = substr(($selfEvalSections[$index]->A23), 0, 4);
	$A24 = substr(($selfEvalSections[$index]->A24), 0, 4);
	$A25 = substr(($selfEvalSections[$index]->A25), 0, 4);
	$A26 = substr(($selfEvalSections[$index]->A26), 0, 4);
	$A27 = substr(($selfEvalSections[$index]->A27), 0, 4);
	$A28 = substr(($selfEvalSections[$index]->A28), 0, 4);
	$A29 = substr(($selfEvalSections[$index]->A29), 0, 4);
	$A30 = substr(($selfEvalSections[$index]->A30), 0, 4);
	$A31 = substr(($selfEvalSections[$index]->A31), 0, 4);
	$A32 = substr(($selfEvalSections[$index]->A32), 0, 4);
	$A33 = substr(($selfEvalSections[$index]->A33), 0, 4);
	$A34 = substr(($selfEvalSections[$index]->A34), 0, 4);
	$A35 = substr(($selfEvalSections[$index]->A35), 0, 4);
	$A36 = substr(($selfEvalSections[$index]->A36), 0, 4);
	$A37 = substr(($selfEvalSections[$index]->A37), 0, 4);
	$A38 = substr(($selfEvalSections[$index]->A38), 0, 4);
	$A39 = substr(($selfEvalSections[$index]->A39), 0, 4);
	$A40 = substr(($selfEvalSections[$index]->A40), 0, 4);
	$A41 = substr(($selfEvalSections[$index]->A41), 0, 4);
	$A42 = substr(($selfEvalSections[$index]->A42), 0, 4);
	$A43 = substr(($selfEvalSections[$index]->A43), 0, 4);
	$A44 = substr(($selfEvalSections[$index]->A44), 0, 4);
	$A45 = substr(($selfEvalSections[$index]->A45), 0, 4);
	$A46 = substr(($selfEvalSections[$index]->A46), 0, 4);
	$A47 = substr(($selfEvalSections[$index]->A47), 0, 4);
	$A48 = substr(($selfEvalSections[$index]->A48), 0, 4);
	$A49 = substr(($selfEvalSections[$index]->A49), 0, 4);
	$A50 = substr(($selfEvalSections[$index]->A50), 0, 4);


$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$selfEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$selfEvalSectDesc </b></font></td>
				</tr>
EOD;

$noquestion=0;
$total=0;
	foreach($selfEvalItems as $index=>$key ) {
		$selfEvalItemIteIndex = $selfEvalItems[$index]->iteIndex;
		$selfEvalItemItePrefix = $selfEvalItems[$index]->itePrefix;
		$selfEvalItemIteText = $selfEvalItems[$index]->iteText;
		$selfEvalItemCriIndex = $selfEvalItems[$index]->criIndex;
		
			if($selfEvalSectID == $selfEvalItemCriIndex) {
				if ($selfEvalItemIteIndex==1) {
					//$Ans=substr((float)number_format($A1, 3, '.', ''), 0, 4);
					$Ans=substr(($A1), 0, 4);
				} elseif ($selfEvalItemIteIndex==2) {
					$Ans=substr(($A2), 0, 4);
				} elseif ($selfEvalItemIteIndex==3) {
					$Ans=substr(($A3), 0, 4);
				} elseif ($selfEvalItemIteIndex==4) {
					$Ans=substr(($A4), 0, 4);
				} elseif ($selfEvalItemIteIndex==5) {
					$Ans=substr(($A5), 0, 4);
				} elseif ($selfEvalItemIteIndex==6) {
					$Ans=substr(($A6), 0, 4);
				} elseif ($selfEvalItemIteIndex==7) {
					$Ans=substr(($A7), 0, 4);
				} elseif ($selfEvalItemIteIndex==8) {
					$Ans=substr(($A8), 0, 4);
				} elseif ($selfEvalItemIteIndex==9) {
					$Ans=substr(($A9), 0, 4);
				} elseif ($selfEvalItemIteIndex==10) {
					$Ans=substr(($A10), 0, 4);
				} elseif ($selfEvalItemIteIndex==11) {
					$Ans=substr(($A11), 0, 4);
				} elseif ($selfEvalItemIteIndex==12) {
					$Ans=substr(($A12), 0, 4);
				} elseif ($selfEvalItemIteIndex==13) {
					$Ans=substr(($A13), 0, 4);
				} elseif ($selfEvalItemIteIndex==14) {
					$Ans=substr(($A14), 0, 4);
				} elseif ($selfEvalItemIteIndex==15) {
					$Ans=substr(($A15), 0, 4);
				} elseif ($selfEvalItemIteIndex==16) {
					$Ans=substr(($A16), 0, 4);
				} elseif ($selfEvalItemIteIndex==17) {
					$Ans=substr(($A17), 0, 4);
				} elseif ($selfEvalItemIteIndex==18) {
					$Ans=substr(($A18), 0, 4);
				} elseif ($selfEvalItemIteIndex==19) {
					$Ans=substr(($A19), 0, 4);
				} elseif ($selfEvalItemIteIndex==20) {
					$Ans=substr(($A20), 0, 4);
				} elseif ($selfEvalItemIteIndex==21) {
					$Ans=substr(($A21), 0, 4);
				} elseif ($selfEvalItemIteIndex==22) {
					$Ans=substr(($A22), 0, 4);
				} elseif ($selfEvalItemIteIndex==23) {
					$Ans=substr(($A23), 0, 4);
				} elseif ($selfEvalItemIteIndex==24) {
					$Ans=substr(($A24), 0, 4);
				} elseif ($selfEvalItemIteIndex==25) {
					$Ans=substr(($A25), 0, 4);
				} elseif ($selfEvalItemIteIndex==26) {
					$Ans=substr(($A26), 0, 4);
				} elseif ($selfEvalItemIteIndex==27) {
					$Ans=substr(($A27), 0, 4);
				} elseif ($selfEvalItemIteIndex==28) {
					$Ans=substr(($A28), 0, 4);
				} elseif ($selfEvalItemIteIndex==29) {
					$Ans=substr(($A29), 0, 4);
				} elseif ($selfEvalItemIteIndex==30) {
					$Ans=substr(($A30), 0, 4);
				} elseif ($selfEvalItemIteIndex==31) {
					$Ans=substr(($A31), 0, 4);
				} elseif ($selfEvalItemIteIndex==32) {
					$Ans=substr(($A32), 0, 4);
				} elseif ($selfEvalItemIteIndex==33) {
					$Ans=substr(($A33), 0, 4);
				} elseif ($selfEvalItemIteIndex==34) {
					$Ans=substr(($A34), 0, 4);
				} elseif ($selfEvalItemIteIndex==35) {
					$Ans=substr(($A35), 0, 4);
				} elseif ($selfEvalItemIteIndex==36) {
					$Ans=substr(($A36), 0, 4);
				} elseif ($selfEvalItemIteIndex==37) {
					$Ans=substr(($A37), 0, 4);
				} elseif ($selfEvalItemIteIndex==38) {
					$Ans=substr(($A38), 0, 4);
				} elseif ($selfEvalItemIteIndex==39) {
					$Ans=substr(($A39), 0, 4);
				} elseif ($selfEvalItemIteIndex==40) {
					$Ans=substr(($A40), 0, 4);
				} elseif ($selfEvalItemIteIndex==41) {
					$Ans=substr(($A41), 0, 4);
				} elseif ($selfEvalItemIteIndex==42) {
					$Ans=substr(($A42), 0, 4);
				} elseif ($selfEvalItemIteIndex==43) {
					$Ans=substr(($A43), 0, 4);
				} elseif ($selfEvalItemIteIndex==44) {
					$Ans=substr(($A44), 0, 4);
				} elseif ($selfEvalItemIteIndex==45) {
					$Ans=substr(($A45), 0, 4);
				} elseif ($selfEvalItemIteIndex==46) {
					$Ans=substr(($A46), 0, 4);
				} elseif ($selfEvalItemIteIndex==47) {
					$Ans=substr(($A47), 0, 4);
				} elseif ($selfEvalItemIteIndex==48) {
					$Ans=substr(($A48), 0, 4);
				} elseif ($selfEvalItemIteIndex==49) {
					$Ans=substr(($A49), 0, 4);
				} elseif ($selfEvalItemIteIndex==50) {
					$Ans=substr(($A50), 0, 4);
				} else {
					$Ans=0;
				}
			$Ans_=substr(number_format((float)$Ans, 2, '.', ''), 0, 4);
				$noquestion++;

$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$selfEvalItemItePrefix $selfEvalItemIteText</td>
					<td width="10%">$Ans_</td>
					<td width="10%"></td>
				</tr>
EOD;

			$nototal=$total+=$Ans;
			$totalquestion=substr(($nototal/$noquestion), 0, 4);
			$percent =substr(($totalquestion*$selfEvalSectPct/ 100), 0, 4);
			$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
			}
	} //for($i = 0; $i < 4; $i++)
		
	$totalNoQuestion=substr(number_format((float)$totalquestion , 2, '.', ''), 0, 4);
$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="4"></td>
					<td colspan="2">
					<table border="1" >
					<tr><td><b>$totalNoQuestion x $selfEvalSectPct%   $totalAverage</b></td></tr>
					</table>	
					</td>
				</tr>
EOD;
	
	$selfEvalLetterSect++;	
} //for($o = 0; $o < 4; $o++)

$tbl .= <<<EOD
				
			</table>
EOD;





///-----------------------------------------------------SELF EVALUATION--------------------------------------------------------------------------


///-----------------------------------------------------DEPARTMENT HEAD---------------------------------------------------------------------------
EOD;
$tbl .= <<<EOD
<br pagebreak="true"/>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px"><b>TRINITY UNIVERSITY OF ASIA</b></font></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px">Cathedral Heights, 275 E. Rodriguez, Sr. Avenue, Quezon City</font> </td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><b>DEPARTMENT HEAD EVALUATION</b></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">FACULTY PERFORMANCE EVALUATION ON TEACHING EFFECTIVENESS</td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">($sem, School Year $sy)</td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><br></td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0.5" cellpadding="2" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="15%">Faculty name:</td>
					<td width="55%"><b>$LName, $FName $MName  </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b>$datePrinted </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b>$departmentDescription</b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b>$timePrinted </b></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td><br>
					</td>
				</tr>
			</table>
EOD;


$dhEvalLetterSect = 'A';
foreach($dhEvalSections as $index=>$key ) {
	$dhEvalSectDesc = $dhEvalSections[$index]->SectDesc;
	$dhEvalSectID = $dhEvalSections[$index]->SectID;
	$dhEvalSectPct = $dhEvalSections[$index]->SectPct;
	$dhEvalNoOfQuestions = $dhEvalSections[$index]->NoOfQuestions;
	$A1 = substr(($dhEvalSections[$index]->A1), 0, 4);
	$A2 = substr(($dhEvalSections[$index]->A2), 0, 4);
	$A3 = substr(($dhEvalSections[$index]->A3), 0, 4);
	$A4 = substr(($dhEvalSections[$index]->A4), 0, 4);
	$A5 = substr(($dhEvalSections[$index]->A5), 0, 4);
	$A6 = substr(($dhEvalSections[$index]->A6), 0, 4);
	$A7 = substr(($dhEvalSections[$index]->A7), 0, 4);
	$A8 = substr(($dhEvalSections[$index]->A8), 0, 4);
	$A9 = substr(($dhEvalSections[$index]->A9), 0, 4);
	$A10 = substr(($dhEvalSections[$index]->A10), 0, 4);
	$A11 = substr(($dhEvalSections[$index]->A11), 0, 4);
	$A12 = substr(($dhEvalSections[$index]->A12), 0, 4);
	$A13 = substr(($dhEvalSections[$index]->A13), 0, 4);
	$A14 = substr(($dhEvalSections[$index]->A14), 0, 4);
	$A15 = substr(($dhEvalSections[$index]->A15), 0, 4);
	$A16 = substr(($dhEvalSections[$index]->A16), 0, 4);
	$A17 = substr(($dhEvalSections[$index]->A17), 0, 4);
	$A18 = substr(($dhEvalSections[$index]->A18), 0, 4);
	$A19 = substr(($dhEvalSections[$index]->A19), 0, 4);
	$A20 = substr(($dhEvalSections[$index]->A20), 0, 4);
	$A21 = substr(($dhEvalSections[$index]->A21), 0, 4);
	$A22 = substr(($dhEvalSections[$index]->A22), 0, 4);
	$A23 = substr(($dhEvalSections[$index]->A23), 0, 4);
	$A24 = substr(($dhEvalSections[$index]->A24), 0, 4);
	$A25 = substr(($dhEvalSections[$index]->A25), 0, 4);
	$A26 = substr(($dhEvalSections[$index]->A26), 0, 4);
	$A27 = substr(($dhEvalSections[$index]->A27), 0, 4);
	$A28 = substr(($dhEvalSections[$index]->A28), 0, 4);
	$A29 = substr(($dhEvalSections[$index]->A29), 0, 4);
	$A30 = substr(($dhEvalSections[$index]->A30), 0, 4);
	$A31 = substr(($dhEvalSections[$index]->A31), 0, 4);
	$A32 = substr(($dhEvalSections[$index]->A32), 0, 4);
	$A33 = substr(($dhEvalSections[$index]->A33), 0, 4);
	$A34 = substr(($dhEvalSections[$index]->A34), 0, 4);
	$A35 = substr(($dhEvalSections[$index]->A35), 0, 4);
	$A36 = substr(($dhEvalSections[$index]->A36), 0, 4);
	$A37 = substr(($dhEvalSections[$index]->A37), 0, 4);
	$A38 = substr(($dhEvalSections[$index]->A38), 0, 4);
	$A39 = substr(($dhEvalSections[$index]->A39), 0, 4);
	$A40 = substr(($dhEvalSections[$index]->A40), 0, 4);
	$A41 = substr(($dhEvalSections[$index]->A41), 0, 4);
	$A42 = substr(($dhEvalSections[$index]->A42), 0, 4);
	$A43 = substr(($dhEvalSections[$index]->A43), 0, 4);
	$A44 = substr(($dhEvalSections[$index]->A44), 0, 4);
	$A45 = substr(($dhEvalSections[$index]->A45), 0, 4);
	$A46 = substr(($dhEvalSections[$index]->A46), 0, 4);
	$A47 = substr(($dhEvalSections[$index]->A47), 0, 4);
	$A48 = substr(($dhEvalSections[$index]->A48), 0, 4);
	$A49 = substr(($dhEvalSections[$index]->A49), 0, 4);
	$A50 = substr(($dhEvalSections[$index]->A50), 0, 4);


	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$dhEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$dhEvalSectDesc </b></font></td>
				</tr>
EOD;
$noquestion=0;
$total=0;
	foreach($dhEvalItems as $index=>$key ) {
		$dhEvalItemIteIndex = $dhEvalItems[$index]->iteIndex;
		$dhEvalItemItePrefix = $dhEvalItems[$index]->itePrefix;
		$dhEvalItemIteText = $dhEvalItems[$index]->iteText;
		$dhEvalItemCriIndex = $dhEvalItems[$index]->criIndex;
		
		if($dhEvalSectID == $dhEvalItemCriIndex) {
			if ($dhEvalItemIteIndex==1) {
				//$Ans=substr((float)number_format($A1, 3, '.', ''), 0, 4);
				$Ans=substr(($A1), 0, 4);
			} elseif ($dhEvalItemIteIndex==2) {
				$Ans=substr(($A2), 0, 4);
			} elseif ($dhEvalItemIteIndex==3) {
				$Ans=substr(($A3), 0, 4);
			} elseif ($dhEvalItemIteIndex==4) {
				$Ans=substr(($A4), 0, 4);
			} elseif ($dhEvalItemIteIndex==5) {
				$Ans=substr(($A5), 0, 4);
			} elseif ($dhEvalItemIteIndex==6) {
				$Ans=substr(($A6), 0, 4);
			} elseif ($dhEvalItemIteIndex==7) {
				$Ans=substr(($A7), 0, 4);
			} elseif ($dhEvalItemIteIndex==8) {
				$Ans=substr(($A8), 0, 4);
			} elseif ($dhEvalItemIteIndex==9) {
				$Ans=substr(($A9), 0, 4);
			} elseif ($dhEvalItemIteIndex==10) {
				$Ans=substr(($A10), 0, 4);
			} elseif ($dhEvalItemIteIndex==11) {
				$Ans=substr(($A11), 0, 4);
			} elseif ($dhEvalItemIteIndex==12) {
				$Ans=substr(($A12), 0, 4);
			} elseif ($dhEvalItemIteIndex==13) {
				$Ans=substr(($A13), 0, 4);
			} elseif ($dhEvalItemIteIndex==14) {
				$Ans=substr(($A14), 0, 4);
			} elseif ($dhEvalItemIteIndex==15) {
				$Ans=substr(($A15), 0, 4);
			} elseif ($dhEvalItemIteIndex==16) {
				$Ans=substr(($A16), 0, 4);
			} elseif ($dhEvalItemIteIndex==17) {
				$Ans=substr(($A17), 0, 4);
			} elseif ($dhEvalItemIteIndex==18) {
				$Ans=substr(($A18), 0, 4);
			} elseif ($dhEvalItemIteIndex==19) {
				$Ans=substr(($A19), 0, 4);
			} elseif ($dhEvalItemIteIndex==20) {
				$Ans=substr(($A20), 0, 4);
			} elseif ($dhEvalItemIteIndex==21) {
				$Ans=substr(($A21), 0, 4);
			} elseif ($dhEvalItemIteIndex==22) {
				$Ans=substr(($A22), 0, 4);
			} elseif ($dhEvalItemIteIndex==23) {
				$Ans=substr(($A23), 0, 4);
			} elseif ($dhEvalItemIteIndex==24) {
				$Ans=substr(($A24), 0, 4);
			} elseif ($dhEvalItemIteIndex==25) {
				$Ans=substr(($A25), 0, 4);
			} elseif ($dhEvalItemIteIndex==26) {
				$Ans=substr(($A26), 0, 4);
			} elseif ($dhEvalItemIteIndex==27) {
				$Ans=substr(($A27), 0, 4);
			} elseif ($dhEvalItemIteIndex==28) {
				$Ans=substr(($A28), 0, 4);
			} elseif ($dhEvalItemIteIndex==29) {
				$Ans=substr(($A29), 0, 4);
			} elseif ($dhEvalItemIteIndex==30) {
				$Ans=substr(($A30), 0, 4);
			} elseif ($dhEvalItemIteIndex==31) {
				$Ans=substr(($A31), 0, 4);
			} elseif ($dhEvalItemIteIndex==32) {
				$Ans=substr(($A32), 0, 4);
			} elseif ($dhEvalItemIteIndex==33) {
				$Ans=substr(($A33), 0, 4);
			} elseif ($dhEvalItemIteIndex==34) {
				$Ans=substr(($A34), 0, 4);
			} elseif ($dhEvalItemIteIndex==35) {
				$Ans=substr(($A35), 0, 4);
			} elseif ($dhEvalItemIteIndex==36) {
				$Ans=substr(($A36), 0, 4);
			} elseif ($dhEvalItemIteIndex==37) {
				$Ans=substr(($A37), 0, 4);
			} elseif ($dhEvalItemIteIndex==38) {
				$Ans=substr(($A38), 0, 4);
			} elseif ($dhEvalItemIteIndex==39) {
				$Ans=substr(($A39), 0, 4);
			} elseif ($dhEvalItemIteIndex==40) {
				$Ans=substr(($A40), 0, 4);
			} elseif ($dhEvalItemIteIndex==41) {
				$Ans=substr(($A41), 0, 4);
			} elseif ($dhEvalItemIteIndex==42) {
				$Ans=substr(($A42), 0, 4);
			} elseif ($dhEvalItemIteIndex==43) {
				$Ans=substr(($A43), 0, 4);
			} elseif ($dhEvalItemIteIndex==44) {
				$Ans=substr(($A44), 0, 4);
			} elseif ($dhEvalItemIteIndex==45) {
				$Ans=substr(($A45), 0, 4);
			} elseif ($dhEvalItemIteIndex==46) {
				$Ans=substr(($A46), 0, 4);
			} elseif ($dhEvalItemIteIndex==47) {
				$Ans=substr(($A47), 0, 4);
			} elseif ($dhEvalItemIteIndex==48) {
				$Ans=substr(($A48), 0, 4);
			} elseif ($dhEvalItemIteIndex==49) {
				$Ans=substr(($A49), 0, 4);
			} elseif ($dhEvalItemIteIndex==50) {
				$Ans=substr(($A50), 0, 4);
			} else {
				$Ans=0;
			}
			$Ans_=substr(number_format((float)$Ans, 2, '.', ''), 0, 4);
			$noquestion++;
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$dhEvalItemItePrefix $dhEvalItemIteText</td>
					<td width="10%">$Ans_</td>
					<td width="10%"></td>
				</tr>
EOD;
			$nototal=$total+=$Ans;
			$totalquestion=substr(($nototal/$noquestion), 0, 4);
			$percent =substr(($totalquestion*$dhEvalSectPct/ 100), 0, 4);
			$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
			}
	} //for($i = 0; $i < 4; $i++)
		
	$totalNoQuestion=substr(number_format((float)$totalquestion , 2, '.', ''), 0, 4);
$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="4"></td>
					<td colspan="2">
					<table border="1" >
							<tr><td><b>$totalNoQuestion x $dhEvalSectPct%   $totalAverage</b></td></tr>
					</table>	
					</td>
				</tr>
EOD;
	
	$dhEvalLetterSect++;	
} //for($o = 0; $o < 4; $o++)

$tbl .= <<<EOD
				
			</table>
EOD;
///----------------------------------------------------DEPARTMENT HEAD------------------------------------------------------------------------------




///----------------------------------------------------DEAN------------------------------------------------------------------------------
EOD;
$tbl .= <<<EOD
<br pagebreak="true"/>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px"><b>TRINITY UNIVERSITY OF ASIA</b></font></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px">Cathedral Heights, 275 E. Rodriguez, Sr. Avenue, Quezon City</font> </td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><b>DEAN EVALUATION</b></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">FACULTY PERFORMANCE EVALUATION ON TEACHING EFFECTIVENESS</td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">($sem, School Year $sy)</td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><br></td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0.5" cellpadding="2" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="15%">Faculty name:</td>
					<td width="55%"><b>$LName, $FName $MName  </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b>$datePrinted </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b>$departmentDescription </b></td>
					<td width="15%">Time printed: </td>
					<td width="15%"><b>$timePrinted </b></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td><br>
					</td>
				</tr>
			</table>
EOD;


$deanEvalLetterSect = 'A';
foreach($deanEvalSections as $index=>$key ) {
	$deanEvalSectDesc = $deanEvalSections[$index]->SectDesc;
	$deanEvalSectID = $deanEvalSections[$index]->SectID;
	$deanEvalSectPct = $deanEvalSections[$index]->SectPct;
	$deanEvalNoOfQuestions = $deanEvalSections[$index]->NoOfQuestions;

	$A1 = substr(($deanEvalSections[$index]->A1), 0, 4);
	$A2 = substr(($deanEvalSections[$index]->A2), 0, 4);
	$A3 = substr(($deanEvalSections[$index]->A3), 0, 4);
	$A4 = substr(($deanEvalSections[$index]->A4), 0, 4);
	$A5 = substr(($deanEvalSections[$index]->A5), 0, 4);
	$A6 = substr(($deanEvalSections[$index]->A6), 0, 4);
	$A7 = substr(($deanEvalSections[$index]->A7), 0, 4);
	$A8 = substr(($deanEvalSections[$index]->A8), 0, 4);
	$A9 = substr(($deanEvalSections[$index]->A9), 0, 4);
	$A10 = substr(($deanEvalSections[$index]->A10), 0, 4);
	$A11 = substr(($deanEvalSections[$index]->A11), 0, 4);
	$A12 = substr(($deanEvalSections[$index]->A12), 0, 4);
	$A13 = substr(($deanEvalSections[$index]->A13), 0, 4);
	$A14 = substr(($deanEvalSections[$index]->A14), 0, 4);
	$A15 = substr(($deanEvalSections[$index]->A15), 0, 4);
	$A16 = substr(($deanEvalSections[$index]->A16), 0, 4);
	$A17 = substr(($deanEvalSections[$index]->A17), 0, 4);
	$A18 = substr(($deanEvalSections[$index]->A18), 0, 4);
	$A19 = substr(($deanEvalSections[$index]->A19), 0, 4);
	$A20 = substr(($deanEvalSections[$index]->A20), 0, 4);
	$A21 = substr(($deanEvalSections[$index]->A21), 0, 4);
	$A22 = substr(($deanEvalSections[$index]->A22), 0, 4);
	$A23 = substr(($deanEvalSections[$index]->A23), 0, 4);
	$A24 = substr(($deanEvalSections[$index]->A24), 0, 4);
	$A25 = substr(($deanEvalSections[$index]->A25), 0, 4);
	$A26 = substr(($deanEvalSections[$index]->A26), 0, 4);
	$A27 = substr(($deanEvalSections[$index]->A27), 0, 4);
	$A28 = substr(($deanEvalSections[$index]->A28), 0, 4);
	$A29 = substr(($deanEvalSections[$index]->A29), 0, 4);
	$A30 = substr(($deanEvalSections[$index]->A30), 0, 4);
	$A31 = substr(($deanEvalSections[$index]->A31), 0, 4);
	$A32 = substr(($deanEvalSections[$index]->A32), 0, 4);
	$A33 = substr(($deanEvalSections[$index]->A33), 0, 4);
	$A34 = substr(($deanEvalSections[$index]->A34), 0, 4);
	$A35 = substr(($deanEvalSections[$index]->A35), 0, 4);
	$A36 = substr(($deanEvalSections[$index]->A36), 0, 4);
	$A37 = substr(($deanEvalSections[$index]->A37), 0, 4);
	$A38 = substr(($deanEvalSections[$index]->A38), 0, 4);
	$A39 = substr(($deanEvalSections[$index]->A39), 0, 4);
	$A40 = substr(($deanEvalSections[$index]->A40), 0, 4);
	$A41 = substr(($deanEvalSections[$index]->A41), 0, 4);
	$A42 = substr(($deanEvalSections[$index]->A42), 0, 4);
	$A43 = substr(($deanEvalSections[$index]->A43), 0, 4);
	$A44 = substr(($deanEvalSections[$index]->A44), 0, 4);
	$A45 = substr(($deanEvalSections[$index]->A45), 0, 4);
	$A46 = substr(($deanEvalSections[$index]->A46), 0, 4);
	$A47 = substr(($deanEvalSections[$index]->A47), 0, 4);
	$A48 = substr(($deanEvalSections[$index]->A48), 0, 4);
	$A49 = substr(($deanEvalSections[$index]->A49), 0, 4);
	$A50 = substr(($deanEvalSections[$index]->A50), 0, 4);
	


$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$deanEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$deanEvalSectDesc </b></font></td>
				</tr>
EOD;


$noquestion=0;
$total=0;

	foreach($deanEvalItems as $index=>$key ) {
		$deanEvalItemIteIndex = $deanEvalItems[$index]->iteIndex;
		$deanEvalItemItePrefix = $deanEvalItems[$index]->itePrefix;
		$deanEvalItemIteText = $deanEvalItems[$index]->iteText;
		$deanEvalItemCriIndex = $deanEvalItems[$index]->criIndex;
		
			if($deanEvalSectID == $deanEvalItemCriIndex) {
					if ($deanEvalItemIteIndex==1) {
						//$Ans=substr((float)number_format($A1, 3, '.', ''), 0, 4);
						$Ans=substr(($A1), 0, 4);
					} elseif ($deanEvalItemIteIndex==2) {
						$Ans=substr(($A2), 0, 4);
					} elseif ($deanEvalItemIteIndex==3) {
						$Ans=substr(($A3), 0, 4);
					} elseif ($deanEvalItemIteIndex==4) {
						$Ans=substr(($A4), 0, 4);
					} elseif ($deanEvalItemIteIndex==5) {
						$Ans=substr(($A5), 0, 4);
					} elseif ($deanEvalItemIteIndex==6) {
						$Ans=substr(($A6), 0, 4);
					} elseif ($deanEvalItemIteIndex==7) {
						$Ans=substr(($A7), 0, 4);
					} elseif ($deanEvalItemIteIndex==8) {
						$Ans=substr(($A8), 0, 4);
					} elseif ($deanEvalItemIteIndex==9) {
						$Ans=substr(($A9), 0, 4);
					} elseif ($deanEvalItemIteIndex==10) {
						$Ans=substr(($A10), 0, 4);
					} elseif ($deanEvalItemIteIndex==11) {
						$Ans=substr(($A11), 0, 4);
					} elseif ($deanEvalItemIteIndex==12) {
						$Ans=substr(($A12), 0, 4);
					} elseif ($deanEvalItemIteIndex==13) {
						$Ans=substr(($A13), 0, 4);
					} elseif ($deanEvalItemIteIndex==14) {
						$Ans=substr(($A14), 0, 4);
					} elseif ($deanEvalItemIteIndex==15) {
						$Ans=substr(($A15), 0, 4);
					} elseif ($deanEvalItemIteIndex==16) {
						$Ans=substr(($A16), 0, 4);
					} elseif ($deanEvalItemIteIndex==17) {
						$Ans=substr(($A17), 0, 4);
					} elseif ($deanEvalItemIteIndex==18) {
						$Ans=substr(($A18), 0, 4);
					} elseif ($deanEvalItemIteIndex==19) {
						$Ans=substr(($A19), 0, 4);
					} elseif ($deanEvalItemIteIndex==20) {
						$Ans=substr(($A20), 0, 4);
					} elseif ($deanEvalItemIteIndex==21) {
						$Ans=substr(($A21), 0, 4);
					} elseif ($deanEvalItemIteIndex==22) {
						$Ans=substr(($A22), 0, 4);
					} elseif ($deanEvalItemIteIndex==23) {
						$Ans=substr(($A23), 0, 4);
					} elseif ($deanEvalItemIteIndex==24) {
						$Ans=substr(($A24), 0, 4);
					} elseif ($deanEvalItemIteIndex==25) {
						$Ans=substr(($A25), 0, 4);
					} elseif ($deanEvalItemIteIndex==26) {
						$Ans=substr(($A26), 0, 4);
					} elseif ($deanEvalItemIteIndex==27) {
						$Ans=substr(($A27), 0, 4);
					} elseif ($deanEvalItemIteIndex==28) {
						$Ans=substr(($A28), 0, 4);
					} elseif ($deanEvalItemIteIndex==29) {
						$Ans=substr(($A29), 0, 4);
					} elseif ($deanEvalItemIteIndex==30) {
						$Ans=substr(($A30), 0, 4);
					} elseif ($deanEvalItemIteIndex==31) {
						$Ans=substr(($A31), 0, 4);
					} elseif ($deanEvalItemIteIndex==32) {
						$Ans=substr(($A32), 0, 4);
					} elseif ($deanEvalItemIteIndex==33) {
						$Ans=substr(($A33), 0, 4);
					} elseif ($deanEvalItemIteIndex==34) {
						$Ans=substr(($A34), 0, 4);
					} elseif ($deanEvalItemIteIndex==35) {
						$Ans=substr(($A35), 0, 4);
					} elseif ($deanEvalItemIteIndex==36) {
						$Ans=substr(($A36), 0, 4);
					} elseif ($deanEvalItemIteIndex==37) {
						$Ans=substr(($A37), 0, 4);
					} elseif ($deanEvalItemIteIndex==38) {
						$Ans=substr(($A38), 0, 4);
					} elseif ($deanEvalItemIteIndex==39) {
						$Ans=substr(($A39), 0, 4);
					} elseif ($deanEvalItemIteIndex==40) {
						$Ans=substr(($A40), 0, 4);
					} elseif ($deanEvalItemIteIndex==41) {
						$Ans=substr(($A41), 0, 4);
					} elseif ($deanEvalItemIteIndex==42) {
						$Ans=substr(($A42), 0, 4);
					} elseif ($deanEvalItemIteIndex==43) {
						$Ans=substr(($A43), 0, 4);
					} elseif ($deanEvalItemIteIndex==44) {
						$Ans=substr(($A44), 0, 4);
					} elseif ($deanEvalItemIteIndex==45) {
						$Ans=substr(($A45), 0, 4);
					} elseif ($deanEvalItemIteIndex==46) {
						$Ans=substr(($A46), 0, 4);
					} elseif ($deanEvalItemIteIndex==47) {
						$Ans=substr(($A47), 0, 4);
					} elseif ($deanEvalItemIteIndex==48) {
						$Ans=substr(($A48), 0, 4);
					} elseif ($deanEvalItemIteIndex==49) {
						$Ans=substr(($A49), 0, 4);
					} elseif ($deanEvalItemIteIndex==50) {
						$Ans=substr(($A50), 0, 4);
					} else {
						$Ans=0;
					}
						
					$Ans_=substr(number_format((float)$Ans, 2, '.', ''), 0, 4);
					$noquestion++;
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$deanEvalItemItePrefix $deanEvalItemIteText</td>
					<td width="10%">$Ans_</td>
					<td width="10%"></td>
				</tr>
EOD;
			$nototal=$total+=$Ans;
			$totalquestion=substr(($nototal/$noquestion), 0, 4);
			$percent =substr(($totalquestion*$deanEvalSectPct/ 100), 0, 4);
			$totalAverage =substr(number_format((float)$percent , 2, '.', ''), 0, 4);
			}
	} //for($i = 0; $i < 4; $i++)

	$totalNoQuestion=substr(number_format((float)$totalquestion , 2, '.', ''), 0, 4);

$tbl .= <<<EOD
				<tr style="line-height:5%;" > 
					<td colspan="4"></td>
					<td colspan="2">
					<hr />
					</td>
				</tr>
				<tr > 
					<td colspan="4"></td>
					<td colspan="2">
					<table border="1" >
							<tr><td><b>$totalNoQuestion x $deanEvalSectPct%   $totalAverage</b></td></tr>
					</table>	
					</td>
				</tr>
EOD;
	
	$deanEvalLetterSect++;	
} //for($o = 0; $o < 4; $o++)

$tbl .= <<<EOD
				
			</table>
EOD;


///----------------------------------------------------DEAN------------------------------------------------------------------------------
///--------------------------------------------------COMMENTS--------------------------------------------------------------------------

EOD;
$tbl .= <<<EOD
<br pagebreak="true"/>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px"><b>TRINITY UNIVERSITY OF ASIA</b></font></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><font size="10px">Cathedral Heights, 275 E. Rodriguez, Sr. Avenue, Quezon City</font> </td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><b>FACULTY EVALUATION COMMENTS</b></td>
					<td width="10%"></td>
				</tr>

				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">FACULTY PERFORMANCE EVALUATION ON TEACHING EFFECTIVENESS</td>
					<td width="10%"></td>
				</tr>
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center">($sem, School Year $sy)</td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;
$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="10%"></td>
					<td width="80%" align="center"><br></td>
					<td width="10%"></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0.5" cellpadding="2" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td width="15%">Faculty name:</td>
					<td width="55%"><b>$LName, $FName $MName  </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b>$datePrinted </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b>$departmentDescription</b></td>
					<td width="15%">Time printed: </td>
					<td width="15%"><b>$timePrinted </b></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td><br>
					</td>
				</tr>
			</table>
EOD;


$commentNumbers = '1';
foreach($evaluationComments as $index=>$key ) {
	$evalComments = $evaluationComments[$index]->comments;
	if(!empty($evalComments)) {
	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b> </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b></b></font></td>
				</tr>
EOD;


$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="1" width="90%">$commentNumbers. $evalComments</td>
					<td width="10%"></td>
					<td width="10%"></td>
				</tr>
EOD;
			
	//} //for($i = 0; $i < 4; $i++)


$tbl .= <<<EOD
				
EOD;
	
	$commentNumbers++;	
	}
} //for($o = 0; $o < 4; $o++)
$tbl .= <<<EOD
				
			</table>
EOD;


///--------------------------------------------------COMMENTS--------------------------------------------------------------------------

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

    

$filename= "evaluation-summary.pdf"; 
//$filelocation = "C:\\xampp\\htdocs\\trinity\\assets\\pdf";//windows
               $filelocation = "/var/www/html/trinity/assets/pdf"; //Linux

//$fileNL = $filelocation."\\".$filename;//Windows
            $fileNL = $filelocation."/".$filename; //Linux

$pdf->Output($fileNL,'F');	
	
// -----------------------------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
