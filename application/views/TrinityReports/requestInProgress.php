<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Randy Lagdaan');
//$pdf->SetTitle('JOB ORDER');
//$pdf->SetSubject('Request Job Order');
//$pdf->SetKeywords('Job Order, request');

// set default header data
//$pdf->SetHeaderData(false, false, 'Receipt List ' . $receiptNo . " " . $pBNNo , false);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 12));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetPrintHeader(false);
//$pdf->SetPrintFooter(false);
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
$pdf->AddPage('P', 'LETTER');
$pdf->SetFont('helvetica', '', 10);

// -----------------------------------------------------------------------------
// NON-BREAKING TABLE (nobr="true")

$requestPurpose = $jobRequest[0]->requestPurpose;
$requestedBy = $requestor[0]->fullName . '(' . $requestor[0]->currentDepartment . ')';
$dateNeeded = $jobRequest[0]->dateNeeded;
$dateCreated = $jobRequest[0]->dateCreated;
$requestRemarks = $jobRequest[0]->requestRemarks;
$departmentUnit = $jobRequest[0]->departmentUnit;
$requestStatus = $jobRequest[0]->requestStatus;

$tbl = <<<EOD
<br><br>


<table border="1" cellpadding="1" cellspacing="2" nobr="true" width="100%" >


<tr>
	<td><b><u>Request ID:</u></b>  #$ID</td>
	<td><b><u>Project Title:</u></b> $requestPurpose </td>
</tr>


<tr>
	<td><b><u>Requestor:</u></b> $requestedBy </td>
	<td><b><u>Department:</u></b>  $departmentUnit</td>
</tr>

<tr>
	<td><b><u>Date Created:</u></b> $dateCreated </td>
	<td><b><u>Date Needed:</u></b>  $dateCreated</td>
</tr>
<tr>
	<td colspan="2"><b><u>Remarks:</u></b> $requestRemarks </td>
</tr>

<tr>
	<td colspan="2"><b><u>Status:</u></b> $requestStatus </td>
</tr>


EOD;

$tbl.=<<<EOD
	<tr>
		<td colspan="2"><b><u>Instructions: </u></b><br>
EOD;
foreach($instructions as $index=>$key ) {
	 $instruction = $instructions[$index]->specialInstructions;
	 $updatedBy = $instructions[$index]->updatedBy;
$tbl.=<<<EOD
		($updatedBy) $instruction <br>
EOD;
} //foreach($instructions as $index=>$key )
$tbl.=<<<EOD
</td>
	</tr>
EOD;

$tbl.=<<<EOD
	<tr>
		<td colspan="2"><b><u>Status Remarks: </u></b><br>
EOD;
foreach($statusRemarks as $index=>$key ) {
	 $statusRem = $statusRemarks[$index]->statusDescription;
	 $updatedBy = $statusRemarks[$index]->updatedBy;
$tbl.=<<<EOD
		($updatedBy) $statusRem <br>
EOD;
} //foreach($instructions as $index=>$key )
$tbl.=<<<EOD
</td>
	</tr>
EOD;



$tbl.=<<<EOD
	<tr>
		<td colspan="2"><b><u>ITEMS: (estimates) </u></b><br>
		<table border="1" cellpadding="2px" cellspacing="2px">
		
		<tr>
			<td width="10%">Quantity </td>
			<td width="10%">Unit</td>
			<td width="60%">Items</td>
			<td width="10%">Unit Cost</td>
			<td width="10%">Amount</td>
		
		</tr>
EOD;
$amountTotal = 0;
$totalAmount = 0;
$amountTotalDisp = 0;
$totalAmountDisp = 0;

foreach($items as $index=>$key ) {
	 $quantity = $items[$index]->quantity;
	 $units = $items[$index]->unitCode;
	 $itemName = $items[$index]->itemName;
	 $itemAmount = number_format($items[$index]->itemAmount, 2);
	 $amountTotal = (intval($quantity) * intval($items[$index]->itemAmount));
	 $totalAmount = $totalAmount + $amountTotal;
	 $amountTotalDisp = number_format($amountTotal, 2);
	 $totalAmountDisp = number_format($totalAmount, 2);
$tbl.=<<<EOD
	<tr>
		<td align="right">$quantity </td>
		<td align="right">$units</td>
		<td>$itemName</td>
		<td align="right">$itemAmount</td>
		<td align="right">$amountTotalDisp</td>
	</tr>
		
EOD;
} //foreach($instructions as $index=>$key )
$tbl.=<<<EOD

		<tr>
			<td colspan="4">Total Amount</td>
			<td >$totalAmountDisp</td>
		
		</tr>


</table>
</td>
	</tr>
EOD;




$tbl.=<<<EOD
</table>
EOD;




$pdf->writeHTML($tbl, true, false, false, false, '');


// add a page

// -----------------------------------------------------------------------------



$filename= "requestInProgress.pdf";
$filelocation = "C:\\xampp\\htdocs\\trinity\\assets\\pdf";//windows
              //$filelocation = "/var/www/html/trinity/assets/pdf"; //Linux

$fileNL = $filelocation."\\".$filename;//Windows
           // $fileNL = $filelocation."/".$filename; //Linux

$pdf->Output($fileNL,'F');

// -----------------------------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE