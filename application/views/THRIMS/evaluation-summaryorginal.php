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


$ratingDesc = "Excellent";



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
					<td width="55%"><b> </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b> </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b> </b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b> </b></td>
				</tr>
				
			</table>
EOD;

$tbl .= <<<EOD
			<table border="0" cellpadding="4" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td colspan="4"><font size="7px">
						Please be advised that you have been rated <b>$ratingDesc</b> in the FACULTY PERFORMANCE EVALUATION.
						The following is the summary of your ratings. </font>
					</td>
				</tr>
			</table>
EOD;


$tbl .= <<<EOD
			<table border="0" cellpadding="1" cellspacing="1" nobr="true" width="100%">
EOD;


for($o = 0; $o < 4; $o++) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2">	</td>
					<td width="25%" colspan="4">STUDENT EVALUATION</td>
				</tr>
EOD;
	$letter = 'A';
	for($i = 0; $i < 4; $i++) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td width="25%">$letter. Mastery of the Subject Matter</td>
					<td width="40%"></td>
					<td width="15%">4.46 x 30% =</td>
					<td width="15%">1.33</td>
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
	$letter++;		
	} //for($i = 0; $i < 4; $i++)
} //for($o = 0; $o < 4; $o++)
$tbl .= <<<EOD
				
			</table>
EOD;


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


					<td width="24%"> </td>
					
					<td width="16%"> 
						<table border="1" >
							<tr><td></td></tr>
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
					<td width="55%"><b> </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b> </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b> </b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b> </b></td>
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
	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$studEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$studEvalSectDesc </b></font></td>
				</tr>
EOD;

	foreach($studentEvalItems as $index=>$key ) {
		$studEvalItemIteIndex = $studentEvalItems[$index]->iteIndex;
		$studEvalItemItePrefix = $studentEvalItems[$index]->itePrefix;
		$studEvalItemIteText = $studentEvalItems[$index]->iteText;
		$studEvalItemCriIndex = $studentEvalItems[$index]->criIndex;
		
			if($studEvalSectID == $studEvalItemCriIndex) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$studEvalItemItePrefix $studEvalItemIteText</td>
					<td width="10%">4.46</td>
					<td width="10%"></td>
				</tr>
EOD;
			}
	} //for($i = 0; $i < 4; $i++)
		

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
						<tr><td></td></tr>
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
					<td width="55%"><b> </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b> </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b> </b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b> </b></td>
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
	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$selfEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$selfEvalSectDesc </b></font></td>
				</tr>
EOD;

	foreach($selfEvalItems as $index=>$key ) {
		$selfEvalItemIteIndex = $selfEvalItems[$index]->iteIndex;
		$selfEvalItemItePrefix = $selfEvalItems[$index]->itePrefix;
		$selfEvalItemIteText = $selfEvalItems[$index]->iteText;
		$selfEvalItemCriIndex = $selfEvalItems[$index]->criIndex;
		
			if($selfEvalSectID == $selfEvalItemCriIndex) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$selfEvalItemItePrefix $selfEvalItemIteText</td>
					<td width="10%">4.46</td>
					<td width="10%"></td>
				</tr>
EOD;
			}
	} //for($i = 0; $i < 4; $i++)
		

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
						<tr><td></td></tr>
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
					<td width="55%"><b> </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b> </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b> </b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b> </b></td>
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
	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$selfEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$selfEvalSectDesc </b></font></td>
				</tr>
EOD;

	foreach($dhEvalItems as $index=>$key ) {
		$dhEvalItemIteIndex = $dhEvalItems[$index]->iteIndex;
		$dhEvalItemItePrefix = $dhEvalItems[$index]->itePrefix;
		$dhEvalItemIteText = $dhEvalItems[$index]->iteText;
		$dhEvalItemCriIndex = $dhEvalItems[$index]->criIndex;
		
			if($dhEvalSectID == $dhEvalItemCriIndex) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$dhEvalItemItePrefix $dhEvalItemIteText</td>
					<td width="10%">4.46</td>
					<td width="10%"></td>
				</tr>
EOD;
			}
	} //for($i = 0; $i < 4; $i++)
		

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
						<tr><td></td></tr>
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
					<td width="55%"><b> </b></td>
					<td width="15%">Date printed:</td>
					<td width="15%"><b> </b></td>
				</tr>
				<tr > 
					<td width="15%">College/Unit:</td>
					<td width="55%" ><b> </b></td>
					<td width="15%">Time printed:</td>
					<td width="15%"><b> </b></td>
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
	
$tbl .= <<<EOD
				<tr > 
					<td width="3%" colspan="2"><font size="10px"><b>$deanEvalLetterSect . </b></font>	</td>
					<td width="97%" colspan="4"><font size="10px"><b>$deanEvalSectDesc </b></font></td>
				</tr>
EOD;

	foreach($deanEvalItems as $index=>$key ) {
		$deanEvalItemIteIndex = $deanEvalItems[$index]->iteIndex;
		$deanEvalItemItePrefix = $deanEvalItems[$index]->itePrefix;
		$deanEvalItemIteText = $deanEvalItems[$index]->iteText;
		$deanEvalItemCriIndex = $deanEvalItems[$index]->criIndex;
		
			if($deanEvalSectID == $deanEvalItemCriIndex) {
$tbl .= <<<EOD
				<tr > 
					<td width="3%">	</td>
					<td width="2%">	</td>
					<td colspan="2" width="75%">$deanEvalItemItePrefix $deanEvalItemIteText</td>
					<td width="10%">4.46</td>
					<td width="10%"></td>
				</tr>
EOD;
			}
	} //for($i = 0; $i < 4; $i++)
		

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
						<tr><td></td></tr>
					</table>	
					</td>
				</tr>
EOD;
	
	$dhEvalLetterSect++;	
} //for($o = 0; $o < 4; $o++)

$tbl .= <<<EOD
				
			</table>
EOD;

///----------------------------------------------------DEAN------------------------------------------------------------------------------


$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

    

$filename= "evaluation-summary.pdf"; 
$filelocation = "C:\\xampp\\htdocs\\trinity\\assets\\pdf";//windows
              //$filelocation = "/var/www/project/custom"; //Linux

$fileNL = $filelocation."\\".$filename;//Windows
           // $fileNL = $filelocation."/".$filename; //Linux

$pdf->Output($fileNL,'F');	
	
// -----------------------------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
