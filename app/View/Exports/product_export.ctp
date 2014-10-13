<?php
App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  


$objPHPExcel = new PHPExcel();

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle('Product Export List');

/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setSize(16)->setBold(true);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

$objPHPExcel->getActiveSheet()->mergeCells('A1:AI1');

/* NEW */
$objPHPExcel->getActiveSheet()->SetCellValue('A2',  'NO');
$objPHPExcel->getActiveSheet()->SetCellValue('B2',  'DATABASE NAME');
$objPHPExcel->getActiveSheet()->SetCellValue('C2',  'DATE ADDED');
$objPHPExcel->getActiveSheet()->SetCellValue('D2',  'IMAGE NAME');
$objPHPExcel->getActiveSheet()->SetCellValue('E2',  'PRODNO');
$objPHPExcel->getActiveSheet()->SetCellValue('F2',  'CATALOG NAME');
$objPHPExcel->getActiveSheet()->SetCellValue('G2',  'CATALOG PAGE');
$objPHPExcel->getActiveSheet()->SetCellValue('H2',  'DESCRIPTION');
$objPHPExcel->getActiveSheet()->SetCellValue('I2',  'EMAILER LINK');
$objPHPExcel->getActiveSheet()->SetCellValue('J2',  'BRAND');
$objPHPExcel->getActiveSheet()->SetCellValue('K2',  'CATEGORY');
$objPHPExcel->getActiveSheet()->SetCellValue('L2',  'CATEGORY DESC');
$objPHPExcel->getActiveSheet()->SetCellValue('M2',  'MATERIAL');
$objPHPExcel->getActiveSheet()->SetCellValue('N2',  'SUBCAT');
$objPHPExcel->getActiveSheet()->SetCellValue('O2',  'BODYPARTS');
$objPHPExcel->getActiveSheet()->SetCellValue('P2',  'SPOTLIGHT LINK');
$objPHPExcel->getActiveSheet()->SetCellValue('Q2',  'FEATURE');					
$objPHPExcel->getActiveSheet()->SetCellValue('R2',  'PRICE');					
$objPHPExcel->getActiveSheet()->SetCellValue('S2',  'S-PRICE');					
$objPHPExcel->getActiveSheet()->SetCellValue('T2',  'WEIGHT');					
$objPHPExcel->getActiveSheet()->SetCellValue('U2',  'DISCOUNT VALUE');					
$objPHPExcel->getActiveSheet()->SetCellValue('V2', 'PROMOCODE');					
$objPHPExcel->getActiveSheet()->SetCellValue('W2', 'DISCOUNT CHART');					
$objPHPExcel->getActiveSheet()->SetCellValue('X2', 'PACKAGE DEAL');					
$objPHPExcel->getActiveSheet()->SetCellValue('Y2', 'VIEW BY PIECE');					
$objPHPExcel->getActiveSheet()->SetCellValue('Z2', 'VIEW BY PACK');					
$objPHPExcel->getActiveSheet()->SetCellValue('AA2', 'NEW STYLES');					
$objPHPExcel->getActiveSheet()->SetCellValue('AB2', 'STATUS');					
$objPHPExcel->getActiveSheet()->SetCellValue('AC2', 'PACKAGING');
$objPHPExcel->getActiveSheet()->SetCellValue('AD2',  'REGULAR PRICE');
/**/

foreach($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
    /*$col->setAutoSize(true);*/
    $col->setRowWidth(30);
}


$objPHPExcel->getActiveSheet()->getStyle('A2:AI2')->getFont()->setBold(true);


$row = 3;

$activeSheet = $objPHPExcel->getActiveSheet();

	foreach($datas as $key => $val){

 		/* NEW */
 		$activeSheet->setCellValueByColumnAndRow(0,$row,$val['Product']['id']);
		$activeSheet->setCellValueByColumnAndRow(1,$row,$val['Product']['db_name']);
		$activeSheet->getStyle('C'.$row)->getNumberFormat()->setFormatCode('m/d/yyyy');	// for price and s_price - new

		$activeSheet->setCellValueByColumnAndRow(2,$row,date('m/d/Y',strtotime($val['Product']['added'])));
		$activeSheet->setCellValueByColumnAndRow(3,$row,$val['Product']['image_name']);
		$activeSheet->setCellValueByColumnAndRow(4,$row,$val['Product']['number']);

		/* sep 23 - to avoid unnecessary invalid catalog names and page numbers, BOTH must have value in order for both to */
		if( $val['Catalog']['name'] != "" && $val['CatalogProduct']['pagenumber'] != "" ){
			$activeSheet->setCellValueByColumnAndRow(5,$row,ucfirst($val['Catalog']['name']));
			$activeSheet->setCellValueByColumnAndRow(6,$row,$val['CatalogProduct']['pagenumber']);
		}
		else{
			$val['Catalog']['name'] = ""; $val['CatalogProduct']['pagenumber'] = "";
			$activeSheet->setCellValueByColumnAndRow(5,$row,$val['Catalog']['name']);
			$activeSheet->setCellValueByColumnAndRow(6,$row,$val['CatalogProduct']['pagenumber']);
		}
		/* end sep 23*/
		

		$activeSheet->setCellValueByColumnAndRow(7,$row,stripslashes($val['Product']['description']));
		$activeSheet->setCellValueByColumnAndRow(8,$row,$val['Product']['emailerlink']);

		$activeSheet->setCellValueByColumnAndRow(9,$row,$val['Brand']['name']);
		$activeSheet->setCellValueByColumnAndRow(10,$row,$val['CategoryProduct']['categories']);
		$activeSheet->setCellValueByColumnAndRow(11,$row,$val['CategoryProduct']['categories_desc']);
		$activeSheet->setCellValueByColumnAndRow(12,$row,$val['MaterialProduct']['materials']);

		/*
			$activeSheet->setCellValueByColumnAndRow(13,$row,$val['Product']['subcat']); 
		*/
		$activeSheet->setCellValueByColumnAndRow(13,$row,$val['SubcategoryProduct']['subcategories']);	/* this the subcat on NEW excel list */

 		/*
 			$activeSheet->setCellValueByColumnAndRow(14,$row,$val['Product']['bodyparts']);
 		*/

 		/*
 		* this is added to get multiple bodyparts  - sep 12, 2014
 		*/
 		if(isset($val['BodypartProduct']['bodyparts']))	{

 			$activeSheet->setCellValueByColumnAndRow(14,$row,$val['BodypartProduct']['bodyparts']);

 		}
 		

 		$activeSheet->setCellValueByColumnAndRow(15,$row,$val['Product']['spotlight_link']);
 		$activeSheet->setCellValueByColumnAndRow(16,$row,stripslashes($val['Product']['feature']));
 		$activeSheet->setCellValueByColumnAndRow(17,$row,$val['Product']['price']);
 		$activeSheet->setCellValueByColumnAndRow(18,$row,$val['Product']['s_price']);

		/* formatting */
		/* $activeSheet->getStyle('U'.$row.':W'.$row)->getNumberFormat()->setFormatCode('####0.00'); */

		$activeSheet->getStyle('R'.$row.':S'.$row)->getNumberFormat()->setFormatCode('####0.00');	// for price and s_price - new

 		$activeSheet->setCellValueByColumnAndRow(19,$row,$val['Product']['weight']);
 		$activeSheet->setCellValueByColumnAndRow(20,$row,$val['Product']['discount_value']);
 		$activeSheet->setCellValueByColumnAndRow(21,$row,$val['Product']['promocode']);
 		$activeSheet->setCellValueByColumnAndRow(22,$row,$val['Product']['discount_chart']);
 		$activeSheet->setCellValueByColumnAndRow(23,$row,$val['Product']['package_deal']);
 		$activeSheet->setCellValueByColumnAndRow(24,$row,$val['Product']['view_piece']);
 		$activeSheet->setCellValueByColumnAndRow(25,$row,$val['Product']['view_pack']);
 		$activeSheet->setCellValueByColumnAndRow(26,$row,$val['Product']['new_styles']);
 		$activeSheet->setCellValueByColumnAndRow(27,$row,$val['Product']['status']);
 		$activeSheet->setCellValueByColumnAndRow(28,$row,$val['Product']['packaging']);
 		$activeSheet->setCellValueByColumnAndRow(29,$row,$val['Product']['reg_price']);
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
