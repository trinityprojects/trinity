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
$pdf->SetHeaderData(false, false, 'JOB ORDER', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 20));
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
<table height="100%">

<tr height="45%"><td>
<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%" >
 <tr>
  <td colspan="2" >
	<span style="font-size: 8px;"><b><u>TO: (Name of Worker) </u></b></span><br>  
	<b style="padding: 0 10px 0 10px"> $workerName </b>  
  </td>
  <td> 
	<span style="font-size: 8px;"><b><u>JOB ORDER NO.: </u></b></span><br> 
	<b style="padding: 0 10px 0 10px"> #$jobOrderNumber </b>  

  </td>
 </tr>
 <tr>
  <td width="50%">
	<span style="font-size: 8px;"><b><u>REQUEST NO.: </u></b></span><br>  
	<b style="padding: 0 10px 0 10px"> #$requestNumber </b>  
  </td>
  <td colspan="2" width="50%"> 
	 <span style="font-size: 8px;"><b><u>DATE PREPARED.: </u></b></span><br> 
	<b style="padding: 0 10px 0 10px"> $timeStamp </b>  
  </td>
 </tr>
 <tr>
  <td colspan="3" style="text-align:center; font-size: 15px; font-weght: bold; color: white; background-color: black">JOB DETAILS</td>
 </tr>
 <tr>
  <td colspan="3" >
      <span style="font-size: 8px;"><b><u>JOB DESCRIPTION</u></b></span><br>
EOD;

$jd = explode(",",$jobDescription);
$jdCount = count($jd);
for($i = 0; $i < $jdCount; $i++) {
$tbl.=<<<EOD
      $jd[$i] <br>
EOD;
}		

$tbl.=<<<EOD
	</td>
 </tr>
 <tr>
	<td colspan="3">
      <span style="font-size: 8px;"><b><u>SCOPE OF WORKS</u></b></span><br>
	 ($userName -> N) $scopeOfWorks   <br>	
EOD;

foreach($scopeDetails as $row) {
$tbl.=<<<EOD
      ($row->updatedBy -> $row->requestStatus) $row->scopeDetails   <br>
EOD;
}		


		
$tbl.=<<<EOD
  </td>
 </tr>
 
 <tr>
  <td colspan="3" >
      <span style="font-size: 8px;"><b><u>LOCATION OF WORK</u></b></span><br>
	  $locationCode - $floor - $roomNumber
  </td>
 </tr>
 <tr>
  <td width="40%" >
	<span style="font-size: 8px;"><b>PLANNED START-UP DATE </b></span><br>  
	<b style="padding: 0 10px 0 10px"> $startDatePlanned </b>  
  </td>
  <td width="20%" > 
	<span style="font-size: 8px;"><b>DURATION: </b></span><br> 
	<b style="padding: 0 10px 0 10px"> $days </b> days 

  </td>
  <td width="40%" > 
	<span style="font-size: 8px;"><b>TARGET COMPLETION DATE: </b></span><br> 
	<b style="padding: 0 10px 0 10px"> $completionDateTarget </b>  

  </td>

  
  
 </tr>
 
 
</table>
EOD;


$tbl.=<<<EOD
</td></tr>
<tr height="10%"><td><br><br></td>
<tr height="45%"><td>
EOD;


$tbl.=<<<EOD
<br><br>
<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%" >
 <tr>
  <td colspan="2" >
	<span style="font-size: 8px;"><b><u>TO: (Name of Worker) </u></b></span><br>  
	<b style="padding: 0 10px 0 10px"> $workerName </b>  
  </td>
  <td> 
	<span style="font-size: 8px;"><b><u>JOB ORDER NO.: </u></b></span><br> 
	<b style="padding: 0 10px 0 10px"> #$jobOrderNumber </b>  

  </td>
 </tr>
 <tr>
  <td width="50%">
	<span style="font-size: 8px;"><b><u>REQUEST NO.: </u></b></span><br>  
	<b style="padding: 0 10px 0 10px"> #$requestNumber </b>  
  </td>
  <td colspan="2" width="50%"> 
	 <span style="font-size: 8px;"><b><u>DATE PREPARED.: </u></b></span><br> 
	<b style="padding: 0 10px 0 10px"> $timeStamp </b>  
  </td>
 </tr>
 <tr>
  <td colspan="3" style="text-align:center; font-size: 15px; font-weght: bold; color: white; background-color: black">JOB DETAILS</td>
 </tr>
 <tr>
  <td colspan="3" >
      <span style="font-size: 8px;"><b><u>JOB DESCRIPTION</u></b></span><br>
EOD;

$jd = explode(",",$jobDescription);
$jdCount = count($jd);
for($i = 0; $i < $jdCount; $i++) {
$tbl.=<<<EOD
      $jd[$i] <br>
EOD;
}		

$tbl.=<<<EOD
	</td>
 </tr>
 <tr>
	<td colspan="3">
      <span style="font-size: 8px;"><b><u>SCOPE OF WORKS</u></b></span><br>
	 ($userName -> N) $scopeOfWorks   <br>	
EOD;

foreach($scopeDetails as $row) {
$tbl.=<<<EOD
      ($row->updatedBy -> $row->requestStatus) $row->scopeDetails   <br>
EOD;
}		


		
$tbl.=<<<EOD
  </td>
 </tr>
 
 <tr>
  <td colspan="3" >
      <span style="font-size: 8px;"><b><u>LOCATION OF WORK</u></b></span><br>
	  $locationCode - $floor - $roomNumber
  </td>
 </tr>
 <tr>
  <td width="40%" >
	<span style="font-size: 8px;"><b>PLANNED START-UP DATE </b></span><br>  
	<b style="padding: 0 10px 0 10px"> $startDatePlanned </b>  
  </td>
  <td width="20%" > 
	<span style="font-size: 8px;"><b>DURATION: </b></span><br> 
	<b style="padding: 0 10px 0 10px"> $days </b> days 

  </td>
  <td width="40%" > 
	<span style="font-size: 8px;"><b>TARGET COMPLETION DATE: </b></span><br> 
	<b style="padding: 0 10px 0 10px"> $completionDateTarget </b>  

  </td>

  
  
 </tr>
 
 
</table>
</td></tr></table>
EOD;







$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

    

$filename= "jobOrder".$requestNumber.".pdf"; 
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
