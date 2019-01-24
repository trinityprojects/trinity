<?php

echo "hello";
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Randy D. Lagdaan")
							 ->setLastModifiedBy("Randy D. Lagdaan")
							 ->setTitle("Quedan Listing")
							 ->setSubject("Office XLS Document")
							 ->setDescription("Quedan Listing")
							 ->setKeywords("Excel PHP")
							 ->setCategory("Quedan Listing");


// Add some data
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Shipper: SUCDEN PHILIPPINES, INC.');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				//make the font become bold
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

				$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Buyer: SUCDEN AMERICAS CORP.');
				$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                //make the font become bold
				$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->getStartColor()->setARGB('#333');


				$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Quedan Listings (CY' . $cropYear . ')');
				$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                //make the font become bold
				$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getFill()->getStartColor()->setARGB('#333');
				

				$objPHPExcel->getActiveSheet()->setCellValue('A4', $currentDate);
				$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                //make the font become bold
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->getStartColor()->setARGB('#333');


				$objPHPExcel->getActiveSheet()->setCellValue('A5', 'RR No.:' . $receiptNo);
				$objPHPExcel->getActiveSheet()->mergeCells('A5:H5');
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                //make the font become bold
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle('A5')->getFill()->getStartColor()->setARGB('#333');

				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);


				$objPHPExcel->getActiveSheet()->setCellValue('A7', "MillMark");
				$objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);


				$objPHPExcel->getActiveSheet()->setCellValue('B7', "Quedan No.");
				$objPHPExcel->getActiveSheet()->getStyle('B7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);


				$objPHPExcel->getActiveSheet()->setCellValue('C7', "Quantity");
				$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);

							
				$objPHPExcel->getActiveSheet()->setCellValue('D7', "Leins");
				$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);
							

				$objPHPExcel->getActiveSheet()->setCellValue('E7', "Week Ending");
				$objPHPExcel->getActiveSheet()->getStyle('E7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);


				$objPHPExcel->getActiveSheet()->setCellValue('F7', "Date Issued");
				$objPHPExcel->getActiveSheet()->getStyle('F7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);


				$objPHPExcel->getActiveSheet()->setCellValue('G7', "TIN");
				$objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);

				$objPHPExcel->getActiveSheet()->setCellValue('H7', "Planter");
				$objPHPExcel->getActiveSheet()->getStyle('H7')->getFont()->setSize(12);
				$objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);

				$objPHPExcel->getActiveSheet()->freezePane('A8');
				$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);				

				$i = 7;
				$grandTotalQuantity = 0;
				$grandTotalLiens = 0;
				$ctr = 0;
				$pcs = 0;
				$totalPcs = 0;
				$totalQuantity = 0;
				$totalLiens = 0;
				
				
				if(!empty($receiptList) ){
				$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('000000');		
					set_time_limit(0);
					foreach($receiptList as $rl) {
					    $quedanNo = $rl->quedanNo;
					    $quantity = number_format($rl->quantity, 0);
					    $liens = number_format($rl->liens, 0);
					    $weekEnding = $rl->weekEnding;
					    $dateIssued = $rl->dateIssued;
					    $planterTIN = $rl->planterTIN;
					    $planterName = $rl->planterName;

					    $totalQuantity = $totalQuantity + ($quantity);
					    $totalLiens = $totalLiens + $liens;
					    $ctr++;
					    $totalPcs++;
					    $pcs = $ctr;

					    $grandTotalQuantity = $grandTotalQuantity + ($quantity);
					    $grandTotalLiens = $grandTotalLiens + $liens;
						$i++;
						
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $millMark);
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $quedanNo);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $quantity);
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $liens);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $weekEnding);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $dateIssued);
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $planterTIN);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
							->setWrapText(true);
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $planterName);
						
						if( ($ctr % 50) == 0 ) {
							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "PAGE TOTAL:");
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $pcs . " PCS.");
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);


							$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $totalQuantity);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $totalLiens);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, '');
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':H'.$i);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							//make the font become bold
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('#333');
							
							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'Shipper: SUCDEN PHILIPPINES, INC.');
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':H'.$i);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							//make the font become bold
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('#333');
						

							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'Buyer: SUCDEN AMERICAS CORP.');
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':H'.$i);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							//make the font become bold
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('#333');

							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'Quedan Listings (CY' . $cropYear . ')');
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':H'.$i);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							//make the font become bold
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('#333');
				
							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $currentDate);
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':H'.$i);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							//make the font become bold
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('#333');

							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'RR No.:' . $receiptNo);
							$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':H'.$i);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							//make the font become bold
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()->getStartColor()->setARGB('#333');

							$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
							$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

							$i++;
							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "MillMark");
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, "Quedan No.");
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);


							$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, "Quantity");
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, "Leins");
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);
							

							$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, "Week Ending");
							$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);


							$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, "Date Issued");
							$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);


							$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, "TIN");
							$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, "Planter");
							$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);
							$i++;
							$objPHPExcel->getActiveSheet()->freezePane('A'.$i);
				
							$i--;
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);				
						

							$totalQuantity = 0;
							$totalLiens = 0;
							$ctr = 0;


						
						}
						
					}
				}

							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "PAGE TOTAL:");
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $pcs . " PCS.");
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);


							$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $totalQuantity);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $totalLiens);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

										
							$i++;
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "GRAND TOTAL:");
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $totalPcs . " PCS.");
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);


							$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $grandTotalQuantity);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);

							
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $grandTotalLiens);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
										->setWrapText(true);
										

				
				// Redirect output to a client’s web browser (Excel2007)
				//clean the output buffer
				ob_end_clean();

				//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//so, we use this header instead.
				header('Content-type: application/vnd.ms-excel');
				//header('Content-Disposition: attachment;filename="quedanListingExcel.xls"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				//$objWriter->save('php://output');
				//$filename = '/xampp/htdocs/sucden/pdf/quedanListingExcel.xls';
				$objWriter->save(str_replace(__FILE__,'/sucden/excel/quedanListingExcel.xls',__FILE__));

?>
