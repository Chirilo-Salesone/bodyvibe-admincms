<?php
App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  


$objPHPExcel = new PHPExcel();

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle('Product Quantities Export');

/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setSize(16)->setBold(true);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->mergeCells('A1:AI1');

/* NEW */
$objPHPExcel->getActiveSheet()->SetCellValue('A2',  'NO');	/* table id */
$objPHPExcel->getActiveSheet()->SetCellValue('B2',  'PROD NO');
$objPHPExcel->getActiveSheet()->SetCellValue('C2',  'UPC CODE');
$objPHPExcel->getActiveSheet()->SetCellValue('D2',  'BIN NO');
$objPHPExcel->getActiveSheet()->SetCellValue('E2',  'AVAIL QTY');
/**/


$objPHPExcel->getActiveSheet()->getStyle('A2:AI2')->getFont()->setBold(true);


$row = 3;

$activeSheet = $objPHPExcel->getActiveSheet();
	
	foreach($datas as $key => $val){

 		/* NEW */
 		$activeSheet->setCellValueByColumnAndRow(0,$row,$val['Upcbin']['id']);
		$activeSheet->setCellValueByColumnAndRow(1,$row,$val['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(2,$row,(string) $val['Upcbin']['upc_code']);
		$activeSheet->setCellValueByColumnAndRow(3,$row,$val['Upcbin']['bin_number']);
		$activeSheet->setCellValueByColumnAndRow(4,$row,$val['Product']['avail_qty']);
 		/**/

	
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
