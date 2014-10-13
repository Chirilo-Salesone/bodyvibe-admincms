<?php
App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  


$objPHPExcel = new PHPExcel();

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle('Product Dimensions Export List');

/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setSize(16)->setBold(true);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->mergeCells('A1:AI1');

/* NEW */
$objPHPExcel->getActiveSheet()->SetCellValue('A2',  'PRODNO');
$objPHPExcel->getActiveSheet()->SetCellValue('B2',  'IDENTIFICATION');
$objPHPExcel->getActiveSheet()->SetCellValue('C2',  'COLOR');
$objPHPExcel->getActiveSheet()->SetCellValue('D2',  'GAUGEINCH');
$objPHPExcel->getActiveSheet()->SetCellValue('E2',  'LENGTHINCH');
$objPHPExcel->getActiveSheet()->SetCellValue('F2',  'WIDTHINCH');
$objPHPExcel->getActiveSheet()->SetCellValue('G2',  'GAUGEMM');
$objPHPExcel->getActiveSheet()->SetCellValue('H2',  'LENGTHMM');
$objPHPExcel->getActiveSheet()->SetCellValue('I2',  'WIDTHMM');
$objPHPExcel->getActiveSheet()->SetCellValue('J2',  'BALL/GEM SIZE');
$objPHPExcel->getActiveSheet()->SetCellValue('K2',  'LENGTH');
$objPHPExcel->getActiveSheet()->SetCellValue('L2',  'WIDTH');
$objPHPExcel->getActiveSheet()->SetCellValue('M2',  'HEIGHT');


/* format */
$objPHPExcel->getActiveSheet()->getStyle('A2:AI2')->getFont()->setBold(true);


$row = 3;

$activeSheet = $objPHPExcel->getActiveSheet();
	
	foreach($datas as $key => $val){

 		$activeSheet->setCellValueByColumnAndRow(0,$row,$val['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(1,$row,$val['Product']['identification']);
		$activeSheet->setCellValueByColumnAndRow(2,$row,$val['Color']['name']);
		$activeSheet->setCellValueByColumnAndRow(3,$row,$val['Productdimension']['gaugeinch']);

		$activeSheet->setCellValueByColumnAndRow(4,$row,$val['Productdimension']['lengthinch']);

		$activeSheet->setCellValueByColumnAndRow(5,$row,$val['Productdimension']['widthinch']);

		$activeSheet->setCellValueByColumnAndRow(6,$row,$val['Productdimension']['gaugemm']);
		$activeSheet->setCellValueByColumnAndRow(7,$row,$val['Productdimension']['lengthmm']);

		$activeSheet->setCellValueByColumnAndRow(8,$row,$val['Productdimension']['widthmm']);
		$activeSheet->setCellValueByColumnAndRow(9,$row,$val['Productdimension']['ball_gem_size']);
		$activeSheet->setCellValueByColumnAndRow(10,$row,$val['Productdimension']['length']);
		$activeSheet->setCellValueByColumnAndRow(11,$row,$val['Productdimension']['width']);
		$activeSheet->setCellValueByColumnAndRow(12,$row,$val['Productdimension']['height']);

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
