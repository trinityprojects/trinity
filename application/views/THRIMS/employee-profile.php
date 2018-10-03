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
$pdf->SetHeaderData(false, false, 'EMPLOYEE PROFILE - ' . $rows[0]->lastName . ', ' . $rows[0]->firstName . ' ' . $rows[0]->middleName, false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
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
$pdf->AddPage();

//$pdf->Write(0, 'JOB ORDER #' . $jobOrderNumber , '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);


// -----------------------------------------------------------------------------

// NON-BREAKING TABLE (nobr="true")

$tbl = <<<EOD
<br><br>
			<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%">
				<tr > 
					<td rowspan="8"> 
						<img src="" alt="" style="width:150px;height:150px;"> 
					</td> 
					<td colspan="4" class="sheet-large"> $jobTitleDescription</td> 
				</tr>

				<tr > 
					<td width="15%"> Active? </td> 
					<td width="25%"> 
					</td> 
					<td width="15%"> Gender </td> 
					<td width="25%"> $gender </td> 
				</tr>
				
				
				<tr > 
					<td> Record ID: </td> 
					<td> $ID </td> 
					<td> Status: </td> 
					<td> $jobStatusDescription </td> 
				</tr>
				
				<tr> 
					<td> Employee Number: </td> 
					<td> $employeeNumber </td> 
					<td> Station: </td> 
					<td >$departmentDescription </td> 
				</tr>

				<tr> 
					<td> Full Name: </td> 
					<td> $lastName,  $firstName  $middleName </td> 
					<td> Classification:  </td> 
					<td> $positionClass</td> 
				</tr>

				<tr> 
					<td> Corporate Email: </td> 
					<td> $tuaEmailAddress </td> 
					<td> Civil Status: </td> 
					<td> $civilStatus </td> 
				</tr>

				<tr> 
					<td> Personal Email: </td> 
					<td> $emailAddress </td> 
					<td>  Date Hired: </td> 
					<td> $dateHired </td> 
				</tr>


				<tr> 
					<td> Mobile Number: </td> 
					<td> $mobileNumber </td> 
					<td> Telephone Number: </td> 
					<td> $telephoneNumber</td> 
				</tr>
					
					
				
			</table>
EOD;


$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

    

$filename= "employee-profile.pdf"; 
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
