<?php
App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  

/* data for Customer Details = $all_datas['customer_details'] */
/* data for Customer Products = $all_datas['customer_products'] */


$objPHPExcel = new PHPExcel();

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle('Carts Information');

/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);


/* for the image */
$sheet = $objPHPExcel->setActiveSheetIndex(0);
$sheet->getColumnDimension('A')->setWidth(10.43);


$row = 1;

$activeSheet = $objPHPExcel->getActiveSheet();
	
	foreach( $all_datas['customer_products'] as $product ){
		
		/*$activeSheet->setCellValueByColumnAndRow(0,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(1,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(2,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(3,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(4,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(5,$row,$product['Product']['number']);
		$activeSheet->setCellValueByColumnAndRow(6,$row,$product['Product']['number']);*/

		/* for product image */
		$gdImage = imagecreatefromjpeg(PRODUCTS_IMAGES_THUMBS. $product['Product']['image_name'] .'.jpg');
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Sample image');
		$objDrawing->setDescription('Sample image');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setWidthAndHeight(77,71);
		$objDrawing->setCoordinates('A'.$row);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(53.25);
		/* edn of for product image */

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
