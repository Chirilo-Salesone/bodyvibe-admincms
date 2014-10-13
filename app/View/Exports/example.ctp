<?php 

App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  


$objPHPExcel = new PHPExcel();

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Customer List');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A1:BB1');
$objPHPExcel->getActiveSheet()->setCellValue('A2','Customer List')->getStyle('A2')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'ID');
$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Email');
$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Shipping Name');
$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Shipping Company');
$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Shipping Address');
$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Shipping City');
$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Shipping State');
$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Shipping Country');
$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Shipping Postcode');
$objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Shipping Phone');
$objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Shipping Fax');

$objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Billing Name');
$objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Billing Company');
$objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Billing Address');
$objPHPExcel->getActiveSheet()->SetCellValue('O3', 'Billing City');
$objPHPExcel->getActiveSheet()->SetCellValue('P3', 'Billing State');
$objPHPExcel->getActiveSheet()->SetCellValue('Q3', 'Billing Country');
$objPHPExcel->getActiveSheet()->SetCellValue('R3', 'Billing Postcode');
$objPHPExcel->getActiveSheet()->SetCellValue('S3', 'Billing Phone');
$objPHPExcel->getActiveSheet()->SetCellValue('T3', 'Billing Fax');	


$objPHPExcel->getActiveSheet()->SetCellValue('U3', 'Business Type');					
$objPHPExcel->getActiveSheet()->SetCellValue('V3', 'Business Value');					
$objPHPExcel->getActiveSheet()->SetCellValue('W3', 'Business License');					

$objPHPExcel->getActiveSheet()->SetCellValue('X3', 'Website');					

$objPHPExcel->getActiveSheet()->SetCellValue('Y3', 'Hear Us ');					
$objPHPExcel->getActiveSheet()->SetCellValue('Z3', 'Hear Value ');					
$objPHPExcel->getActiveSheet()->SetCellValue('AA3', 'Date Registered');					

$objPHPExcel->getActiveSheet()->SetCellValue('AB3', 'Date Modified');					
$objPHPExcel->getActiveSheet()->SetCellValue('AC3', 'Received latest Catalog');		

$objPHPExcel->getActiveSheet()->getStyle('A3:AC3')->getFont()->setBold(true);



$row = 4;
	foreach($datas as $key => $val){

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row,$val['Customer']['id']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row,$val['Customer']['email']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row,$val['Customer']['ship_fname']." ".$val['Customer']['ship_lname']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row,$val['Customer']['ship_company']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row,$val['Customer']['ship_street']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row,$val['Customer']['ship_city']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row,$val['Customer']['ship_state']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row,$val['Customer']['ship_country']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$row,$val['Customer']['ship_postcode']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row,$val['Customer']['ship_phone']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$row,$val['Customer']['ship_fax']);

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$row,$val['Customer']['bill_fname']." ".$val['Customer']['bill_lname']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$row,$val['Customer']['bill_company']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$row,$val['Customer']['bill_street']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$row,$val['Customer']['bill_city']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$row,$val['Customer']['bill_state']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$row,$val['Customer']['bill_country']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$row,$val['Customer']['bill_postcode']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$row,$val['Customer']['bill_phone']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$row,$val['Customer']['bill_fax']);		


		//business
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$row,$val['Customer']['business_type']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$row,$val['Customer']['business_value']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$row,$val['Customer']['business_license']);	

		//hear us
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$row,$val['Customer']['website']);	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$row,$val['Customer']['hear']);	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$row,$val['Customer']['hear_value']);	


		// date registered and modified
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$row,$val['Customer']['added']);	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27,$row,$val['Customer']['modified']);	


		// send newsletter
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28,$row,$val['Customer']['newsletter']);	



		$row++;

	}	




// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>