<?php
App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  

/* data for Customer Details = $all_datas['customer_details'] */
/* data for Customer Products = $all_datas['customer_products'] */



$objPHPExcel = new PHPExcel();

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle('Cart Information');

/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);
/*$objPHPExcel->getActiveSheet()->setCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setSize(16)->setBold(true);*/
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

$row = 7;

$activeSheet = $objPHPExcel->getActiveSheet();


/* default format from bodyvibe.com */
$objPHPExcel->getActiveSheet()->setCellValue('A1','BODYVIBE');
$objPHPExcel->getActiveSheet()->setCellValue('B1','O');
$objPHPExcel->getActiveSheet()->setCellValue('C1','N');
$objPHPExcel->getActiveSheet()->setCellValue('J1','0');
$objPHPExcel->getActiveSheet()->setCellValue('K1','0');
$objPHPExcel->getActiveSheet()->setCellValue('L1','N');

$objPHPExcel->getActiveSheet()->setCellValue('B2','5');
$objPHPExcel->getActiveSheet()->setCellValue('C2','B');
$objPHPExcel->getActiveSheet()->setCellValue('H2','D');
$objPHPExcel->getActiveSheet()->setCellValue('I2', ucfirst($all_datas['customer_details']['Customer']['ship_company']) );

$objPHPExcel->getActiveSheet()->setCellValue('B3','5');
$objPHPExcel->getActiveSheet()->setCellValue('C3','B');
$objPHPExcel->getActiveSheet()->setCellValue('H3','D');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Web Shop # '.$all_datas['customer_details']['Cart']['id'] );

$objPHPExcel->getActiveSheet()->setCellValue('B4','5');
$objPHPExcel->getActiveSheet()->setCellValue('C4','B');
$objPHPExcel->getActiveSheet()->setCellValue('H4','D');
$objPHPExcel->getActiveSheet()->setCellValue('I4', 'Sales Representative: '.ucfirst($all_datas['customer_details']['sales_representative']) );

$objPHPExcel->getActiveSheet()->setCellValue('B5','5');
$objPHPExcel->getActiveSheet()->setCellValue('C5','B');
$objPHPExcel->getActiveSheet()->setCellValue('H5','D');

$objPHPExcel->getActiveSheet()->setCellValue('B6','5');
$objPHPExcel->getActiveSheet()->setCellValue('C6','B');
$objPHPExcel->getActiveSheet()->setCellValue('H6','D');

/**/

	
	/*foreach( $all_datas as $product ){*/
	foreach( $all_datas['customer_products'] as $product ){

		$activeSheet->setCellValueByColumnAndRow(1,$row,'3');
		$activeSheet->setCellValueByColumnAndRow(2,$row,'B');

		$activeSheet->setCellValueByColumnAndRow(7,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(8,$row,$product['Product']['description']);
		$activeSheet->setCellValueByColumnAndRow(9,$row,$product['CartsProducts']['qty']);
		$activeSheet->setCellValueByColumnAndRow(10,$row,$product['Product']['price']);
		$activeSheet->setCellValueByColumnAndRow(11,$row,$product['Product']['discount_value']);

	
		$row++;

	}


/* Redirect output to a client’s web browser (Excel5) */
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
/* If you're serving to IE 9, then the following may be needed */
header('Cache-Control: max-age=1');

/* If you're serving to IE over SSL, then the following may be needed */
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); /* Date in the past */
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); /* always modified */
header ('Cache-Control: cache, must-revalidate'); /* HTTP/1.1 */
header ('Pragma: public'); /* HTTP/1.0 */

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>
