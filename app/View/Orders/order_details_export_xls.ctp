<?php
App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  

/* data for Customer Details = $all_datas['customer_details'] */
/* data for Customer Products = $all_datas['customer_products'] */



$objPHPExcel = new PHPExcel();

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle('Orders Information');

/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);
/*$objPHPExcel->getActiveSheet()->setCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setSize(16)->setBold(true);*/
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);

$row = 12;

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
$objPHPExcel->getActiveSheet()->setCellValue('I2', ucwords($all_datas['order_data']['OrderCustomer']['ship_company']) );

$objPHPExcel->getActiveSheet()->setCellValue('B3','5');
$objPHPExcel->getActiveSheet()->setCellValue('C3','B');
$objPHPExcel->getActiveSheet()->setCellValue('H3','D');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Web Order # '.$all_datas['order_data']['Order']['id'] );

$objPHPExcel->getActiveSheet()->setCellValue('B4','5');
$objPHPExcel->getActiveSheet()->setCellValue('C4','B');
$objPHPExcel->getActiveSheet()->setCellValue('H4','D');
$objPHPExcel->getActiveSheet()->setCellValue('I4', 'Sales Representative:  '.ucfirst($all_datas['order_data']['CustomerSalesRep']['sales_representative']) );

/* Packaged: Yes or No */
$objPHPExcel->getActiveSheet()->setCellValue('B5','5');
$objPHPExcel->getActiveSheet()->setCellValue('C5','B');
$objPHPExcel->getActiveSheet()->setCellValue('H5','D');
if( $all_datas['order_data']['OrderPackage']['id'] != 0 ){
	$objPHPExcel->getActiveSheet()->setCellValue('I5', 'Jewelry Packaged? YES ( $'. number_format($all_datas['order_data']['OrderPackage']['cost'], 2, '.', ', ') .' )' );
}
else{
	$objPHPExcel->getActiveSheet()->setCellValue('I5', 'Jewelry Packaged? NO' );
}
/**/

/* shipping */
$objPHPExcel->getActiveSheet()->setCellValue('B6','5');
$objPHPExcel->getActiveSheet()->setCellValue('C6','B');
$objPHPExcel->getActiveSheet()->setCellValue('H6','D');
$objPHPExcel->getActiveSheet()->setCellValue('I6', 'Shipping:  +$'.$all_datas['order_data']['Shipping']['upsServicePrice']. ' ('. $all_datas['order_data']['Shipping']['upsServiceName'] .')' );
/**/

/* payment */
$objPHPExcel->getActiveSheet()->setCellValue('B7','5');
$objPHPExcel->getActiveSheet()->setCellValue('C7','B');
$objPHPExcel->getActiveSheet()->setCellValue('H7','D');
if( $all_datas['order_data']['Payment']['name'] == 'cod' ){
	$objPHPExcel->getActiveSheet()->setCellValue('I7', 'Payment:  +$12.00'. ' ('.$all_datas['order_data']['Payment']['name'].')' );
}
else{
	$objPHPExcel->getActiveSheet()->setCellValue('I7', 'Payment:  +$0.00'. ' ('.$all_datas['order_data']['Payment']['name'].')' );
}
/**/

/* coupon discount */
$objPHPExcel->getActiveSheet()->setCellValue('B8','5');
$objPHPExcel->getActiveSheet()->setCellValue('C8','B');
$objPHPExcel->getActiveSheet()->setCellValue('H8','D');
if( $all_datas['order_data']['OrderCoupon']['id'] != 0 || $all_datas['order_data']['OrderCoupon']['id'] != null ){
	$objPHPExcel->getActiveSheet()->setCellValue('I8', 'Coupon Disount:  +$'.$all_datas['order_data']['OrderCoupon']['discountrate'] );
}
else{
	$objPHPExcel->getActiveSheet()->setCellValue('I8', 'Coupon Disount:  +$0.00' );
}
/**/

/* volume discount */
$objPHPExcel->getActiveSheet()->setCellValue('B9','5');
$objPHPExcel->getActiveSheet()->setCellValue('C9','B');
$objPHPExcel->getActiveSheet()->setCellValue('H9','D');
$objPHPExcel->getActiveSheet()->setCellValue('I9', 'Volume Disount:  +$'.$all_datas['order_data']['Order']['volumediscount'] );
/**/


$objPHPExcel->getActiveSheet()->setCellValue('B10','5');
$objPHPExcel->getActiveSheet()->setCellValue('C10','B');
$objPHPExcel->getActiveSheet()->setCellValue('H10','D');

$objPHPExcel->getActiveSheet()->setCellValue('B11','5');
$objPHPExcel->getActiveSheet()->setCellValue('C11','B');
$objPHPExcel->getActiveSheet()->setCellValue('H11','D');
/**/

	
	/*foreach( $all_datas as $product ){*/
	foreach( $all_datas['product_data'] as $product ){

		$activeSheet->setCellValueByColumnAndRow(1,$row,'3');
		$activeSheet->setCellValueByColumnAndRow(2,$row,'B');

		$activeSheet->setCellValueByColumnAndRow(7,$row,$product['OrderProduct']['number']);
		$activeSheet->setCellValueByColumnAndRow(8,$row,$product['OrderProduct']['description']);

		/* 
		* used for product discounted price and product discount value
		* based on the calculation by Zach Tanzinco - oct 8, 2014 
		*/
		$discount_value_for_each_product = '';	/* product discount value */
		$discounted_price_for_each_product = 0;
		$total_calculated_amount_for_each_product = 0;
		if( $product['OrderDetail']['qty'] <= 2 ){	/* 1-2 products */
			
			/* check if product has discount_value */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] != 0.00 ){
				$discount_value_for_each_product = $product['OrderProduct']['discount_value'].'%';
			}
			elseif( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 0.00 ){
				$discount_value_for_each_product = '0.00%';
			}
			
			/* For special discount_values (e.g. 75%) */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 75.00 ){
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.75), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}
			else{
				$discounted_price_for_each_product = $product['OrderProduct']['price'];
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}
			
		}
		elseif( $product['OrderDetail']['qty'] == 3 || $product['OrderDetail']['qty'] <= 5 ){
			
			/* check if product has discount_value - for discount_Value display on product details */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] != 0.00 ){
				$discount_value_for_each_product = $product['OrderProduct']['discount_value'].'%';
			}
			elseif( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 0.00 ){
				$discount_value_for_each_product = '15.00%';
			}

			/* For special discount_values (e.g. 75%) */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 75.00 ){
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.75), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}
			else{
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.15), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}

			
		}
		elseif( $product['OrderDetail']['qty'] == 6 || $product['OrderDetail']['qty'] <= 11 ){
			
			/* check if product has discount_value */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] != 0.00 ){
				$discount_value_for_each_product = $product['OrderProduct']['discount_value'].'%';
			}
			elseif( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 0.00 ){
				$discount_value_for_each_product = '25.00%';
			}

			/* For special discount_values (e.g. 75%) */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 75.00 ){
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.75), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}
			else{
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.25), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}

			
		}
		elseif( $product['OrderDetail']['qty'] >= 12 ){
			
			/* check if product has discount_value */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] != 0.00 ){
				$discount_value_for_each_product = $product['OrderProduct']['discount_value'].'%';
			}
			elseif( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 0.00 ){
				$discount_value_for_each_product = '35.00%';
			}

			/* For special discount_values (e.g. 75%) */
			if( isset( $product['OrderProduct']['discount_value'] ) && $product['OrderProduct']['discount_value'] == 75.00 ){
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.75), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}
			else{
				$the_discount_value = number_format( ($product['OrderProduct']['price'] * 0.35), 2, '.', ', ');
				$discounted_price_for_each_product = $product['OrderProduct']['price'] - $the_discount_value;
				$total_calculated_amount_for_each_product = $product['OrderDetail']['qty'] * $discounted_price_for_each_product;
			}

			
		}
		$price = $discounted_price_for_each_product;
		$discount = $discount_value_for_each_product;
		$totalamount = number_format($total_calculated_amount_for_each_product, 2, '.', ' ,');
		/**/

		$activeSheet->setCellValueByColumnAndRow(9,$row,$product['OrderDetail']['qty']);
		/*$activeSheet->setCellValueByColumnAndRow(10,$row,$product['OrderProduct']['price']);*/
		$activeSheet->setCellValueByColumnAndRow(10,$row,$discounted_price_for_each_product);
		/*$activeSheet->setCellValueByColumnAndRow(11,$row,$product['OrderProduct']['discount_value']);*/
		$activeSheet->setCellValueByColumnAndRow(11,$row,$discount);

	
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
