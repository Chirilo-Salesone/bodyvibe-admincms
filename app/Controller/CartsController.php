<?php
App::uses('AppController', 'Controller');


require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 * @property PaginatorComponent $Paginator
 */
class CartsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


/**
 * index method
 *
 * @return void
 */

	public function beforeFilter(){

		parent::beforeFilter();

		/* Removing the search box */
		$this->set('show_search_box',false);

		$this->set('page_title',"Non Checkout List");

	}

	public function index() {


		$pagination_settings = array();
		/*$pagination_settings['fields'] = array('Customer.*','Cart.*','Coupon.id');*/
		/* optimized fields - oct 7, 2014 */
		$pagination_settings['fields'] = array('Customer.ship_fname', 'Customer.ship_lname', 'Customer.email', 'Customer.ship_company', 'Customer.ship_phone',
			'Cart.id', 'Cart.added', 'Cart.shoptotal',
			'Coupon.id');
		$pagination_settings['joins'] = array(
								array(
				                     'table'=>'customers',
				                     'alias'=>'Customer',
				                     'type' =>'inner',
				                     'conditions'=>array('Cart.customer_id=Customer.id')
				                ),

								array(
				                     'table'=>'coupons',
				                     'alias'=>'Coupon',
				                     'type' =>'left',
				                     'conditions'=>array('Cart.coupon_id=Coupon.id')
				                ),


			                );
		$pagination_settings['conditions'] = array("Cart.shoptotal > 0");
		$pagination_settings['order'] = "Cart.added DESC";
		$pagination_settings['limit'] = 20;

		$this->Paginator->settings = $pagination_settings;
		$this->set('carts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {



		if (!$this->Cart->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
		$this->set('cart', $this->Cart->find('first', $options));
	}

	public function edit($id = null) {



		if (!$this->Cart->exists($id)) throw new NotFoundException('Invalid Cart');

		/*salesreps*/
		$this->loadModel('Salesrep');
		$this->set('salesreps', $this->Salesrep->find('list'));


		if ($this->request->is(array('post', 'put'))) {

			if ($this->Cart->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Cart Updated!</strong>','default',array('class' =>'alert alert-success'));

			} else {
				 $this->Session->setFlash('<strong>The Cart could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {

			$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
			$options['contain'] = array('Customer');
			/*$options['fields'] = array('Cart.*','Customer.*', 'Coupon.*', 'Package.*', 'Shipping.*');*/
			/* optimized fields - oct 7, 2014 */
			$options['fields'] = array('Cart.id', 'Cart.added', 'Cart.modified', 'Cart.shoptotal', 'Cart.coupon_id',
				'Customer.ship_fname', 'Customer.ship_lname', 'Customer.email', 'Customer.ship_company', 'Customer.ship_phone', 'Customer.salesrep_id', 'Customer.salesrep',
				'Customer.bill_company', 'Customer.bill_street', 'Customer.bill_city', 'Customer.bill_state', 'Customer.bill_country', 'Customer.bill_postcode',
				'Customer.ship_company', 'Customer.ship_street', 'Customer.ship_city', 'Customer.ship_state', 'Customer.ship_country', 'Customer.ship_postcode', 
				'Coupon.name', 'Coupon.details', 'Coupon.promocode', 'Coupon.discountrate',
				'Package.cost'/*,'Shipping.*'*/);
			/* for coupon and package */
			$options['joins'] = array(
									array(
										'table'=>'coupons',
										'alias'=>'Coupon',
										'type'=>'left',
										'conditions'=>array('Coupon.id=Cart.coupon_id')
									),
									array(
										'table'=>'productpackages',
										'alias'=>'Package',
										'type'=>'left',
										'conditions'=>array('Package.id=Cart.package_id')
									)/*,
									array(
										'table'=>'shippings',
										'alias'=>'Shipping',
										'type'=>'left',
										'conditions'=>array('Shipping.cust_id=Cart.customer_id')
									)*/
			);
			/* end of for coupon and package */
			$this->request->data = $this->Cart->find('first', $options);

		}
			
			$this->set('page_title',$this->name.' / '.$this->request->data['Cart']['id']);

			// Category
			$options = array();
			$options['conditions'] = array('Cart.id'=>$id);
			$options['fields'] = array('Product.image_name', 'Product.number', 'Product.discount_value', 'Product.price',
				'CartsProducts.qty',
				'Color.name');
			$options['joins'] = array(
									array(
					                     'table'=>'carts_products',
					                     'alias'=>'CartsProducts',
					                     'type' =>'inner',
					                     'conditions'=>array('CartsProducts.cart_id=Cart.id')
					                ),
									array(
					                     'table'=>'products',
					                     'alias'=>'Product',
					                     'type' =>'inner',
					                     'conditions'=>array('CartsProducts.product_id=Product.id')
					                ),
					                array(
					                     'table'=>'colors',
					                     'alias'=>'Color',
					                     'type' =>'left',
					                     'conditions'=>array('Product.color_id=Color.id')					                	
					                )     
				                );

			
			$datas = $this->Cart->find('all',$options);
			$this->set('carts_products',$datas);
			$this->set('show_search_box',false);

		
/*			if($this->request->ext=="pdf"){

				$this->layout = "page";
				$this->render('data');
				
			}*/

	}	


	/* Export to PDF */
	public function export_to_pdf($id = null){

		if (!$this->Cart->exists($id)) throw new NotFoundException('Invalid Cart');


		/*salesreps*/
		$this->loadModel('Salesrep');
		$salesreps = $this->Salesrep->find('list');
		$this->set('salesreps', $salesreps);


		if ($this->request->is(array('post', 'put'))) {

			if ($this->Cart->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Cart Updated!</strong>','default',array('class' =>'alert alert-success'));

			} else {
				 $this->Session->setFlash('<strong>The Cart could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {

			$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
			$options['contain'] = array('Customer');
			$options['fields'] = array('Cart.*','Customer.*', 'Coupon.*', 'Package.*', 'Shipping.*');
			/* for coupon and package */
			$options['joins'] = array(
									array(
										'table'=>'coupons',
										'alias'=>'Coupon',
										'type'=>'left',
										'conditions'=>array('Coupon.id=Cart.coupon_id')
									),
									array(
										'table'=>'productpackages',
										'alias'=>'Package',
										'type'=>'left',
										'conditions'=>array('Package.id=Cart.package_id')
									),
									array(
										'table'=>'shippings',
										'alias'=>'Shipping',
										'type'=>'left',
										'conditions'=>array('Shipping.cust_id=Cart.customer_id')
									)
			);
			/* end of for coupon and package */
			$this->request->data = $this->Cart->find('first', $options);

		}
			
			$this->set('page_title',$this->name.' / '.$this->request->data['Cart']['id']);

			// Category
			$options = array();
			$options['conditions'] = array('Cart.id'=>$id);
			$options['fields'] = array('Product.*','CartsProducts.*','Color.name');
			$options['joins'] = array(
									array(
					                     'table'=>'carts_products',
					                     'alias'=>'CartsProducts',
					                     'type' =>'inner',
					                     'conditions'=>array('CartsProducts.cart_id=Cart.id')
					                ),
									array(
					                     'table'=>'products',
					                     'alias'=>'Product',
					                     'type' =>'inner',
					                     'conditions'=>array('CartsProducts.product_id=Product.id')
					                ),
					                array(
					                     'table'=>'colors',
					                     'alias'=>'Color',
					                     'type' =>'left',
					                     'conditions'=>array('Product.color_id=Color.id')					                	
					                )     
				                );

			
			$datas = $this->Cart->find('all',$options);
			/*$this->set('carts_products',$datas);
			$this->set('show_search_box',false);

			$this->set(compact('carts_products'));
	        // Setup the PDF parameters. This is where it all happens.
	        $params = array(
	            'download' => false,
	            'name' => "customer_details.pdf",
	            'paperOrientation' => 'portrait',
	            'paperSize' => 'legal'
	        );
	        $this->set($params);*/


	        /*
	        *	PDF conversion with images - also edit dompdf_config.inc.php
	        * 	never indent the heredoc
	        */
	        
	        $dompdf = new DOMPDF();
$html = <<<ENDHTML
<html>
<head>
<style type="text/css">
table {
    border:1px solid #CCC;
    border-collapse:collapse;
}
td {
    border:none;
}
</style>
</head>
<body style="font:Verdana, Arial, Helvetica, sans-serif">
ENDHTML;
$html .= <<<ENDHTML
		<div style="margin-bottom: 100px">
		<h1> Billing Information </h1>
		<table width="100%" border="1" align="left"  style="font:Verdana, Arial, Helvetica, sans-serif; margin-bottom: 100px;">
			
			<tbody>
				<tr style="background-color: #cccccc;">
				<th width="90">Company</th>
				<th>Street</th>
				<th>City</th>
				<th>State</th>
				<th>Country</th>
				<th>Zip</th>
				</tr>
ENDHTML;
$bill_company = $this->request->data['Customer']['bill_company'];
$bill_street = $this->request->data['Customer']['bill_street'];
$bill_city = $this->request->data['Customer']['bill_city'];
$bill_state = $this->request->data['Customer']['bill_state'];
$bill_country = $this->request->data['Customer']['bill_country'];
$bill_zip = $this->request->data['Customer']['bill_postcode'];

$html .= <<<ENDHTML
			<tr>
				<td style="text-align: center;">$bill_company</td>
				<td style="text-align: center;">$bill_street</td>
				<td style="text-align: center;">$bill_city</td>
				<td style="text-align: center;">$bill_state</td>
				<td style="text-align: center;">$bill_country</td>
				<td style="text-align: center;">$bill_zip</td>
				</tr>
			</tbody>
		</table>
		</div>
ENDHTML;

$html .= <<<ENDHTML
		<div style="margin-bottom: 100px">
		<h1> Shipping Information </h1>
		<table width="100%" border="1" align="left"  style="font:Verdana, Arial, Helvetica, sans-serif; margin-bottom: 100px;">
			
			<tbody>
				<tr style="background-color: #cccccc;">
				<th width="90">Company</th>
				<th>Street</th>
				<th>City</th>
				<th>State</th>
				<th>Country</th>
				<th>Zip</th>
				</tr>
ENDHTML;
$ship_company = $this->request->data['Customer']['ship_company'];
$ship_street = $this->request->data['Customer']['ship_street'];
$ship_city = $this->request->data['Customer']['ship_city'];
$ship_state = $this->request->data['Customer']['ship_state'];
$ship_country = $this->request->data['Customer']['ship_country'];
$ship_zip = $this->request->data['Customer']['ship_postcode'];

$html .= <<<ENDHTML
			<tr>
				<td style="text-align: center;">$ship_company</td>
				<td style="text-align: center;">$ship_street</td>
				<td style="text-align: center;">$ship_city</td>
				<td style="text-align: center;">$ship_state</td>
				<td style="text-align: center;">$ship_country</td>
				<td style="text-align: center;">$ship_zip</td>
				</tr>
			</tbody>
		</table>
		</div>
ENDHTML;


$html .= <<<ENDHTML
		<div style="margin-bottom: 100px">
		<h1> Sales Representative </h1>
		<table width="100%" border="1" align="left"  style="font:Verdana, Arial, Helvetica, sans-serif; margin-bottom: 100px;">
			
			<tbody>
ENDHTML;
if( isset($this->request->data['Customer']['salesrep_id']) && $this->request->data['Customer']['salesrep_id'] != 0 ){
	$sales_representative = ucfirst($salesreps[ $this->request->data['Customer']['salesrep_id'] ]);
}
elseif( isset($this->request->data['Customer']['salesrep']) && $this->request->data['Customer']['salesrep'] != '' ){
	$sales_representative = ucfirst( $this->request->data['Customer']['salesrep'] );
}
else{
	$sales_representative = 'No Sales Representative.';
}
/*$sales_representative = ucfirst($salesreps[$this->request->data['Customer']['salesrep_id']]);*/

$html .= <<<ENDHTML
			<tr>
				<th style="background-color: #cccccc;">Sales Representative: </th>
				<td style="text-align: center;">$sales_representative</td>
			</tr>
			</tbody>
		</table>
		</div>
ENDHTML;


$html .= <<<ENDHTML
  <h1>Product Details</h1>
	<table width="100%" border="1" align="left"  style="font:Verdana, Arial, Helvetica, sans-serif">
	<tbody>
	<tr style="background-color: #cccccc;">
	<th width="90">Image</th>
	<th>Number</th>
	<th>Color</th>
	<th>Qty</th>
	<th>Unit Price</th>
	<th>Discount (%)</th>
	<th>Total</th>
	</tr>
ENDHTML;
foreach($datas as $data){
	$image_name = PRODUCTS_IMAGES_THUMBS.$data['Product']['image_name'].'.jpg';
	/*if( file_exists($image_name) ){*/
	if( @getimagesize($image_name) ){
		$image_name = '<img src='.$image_name.' width="113" height="90" style="margin-left: 2px; border: 1px solid #000;" />';
	}
	else{
		$image_name = PRODUCTS_IMAGES_THUMBS.'notavailable.jpg';
		$image_name = '<img src='.$image_name.' width="115" height="90" style="margin-left: 2px; border: 1px solid #000;" />';
	}
	/*$image_name = '<img src='.$image_name.' width="104" height="104" />';*/
	$prod_number = $data['Product']['number'];
	$color = $data['Color']['name'];
	$cp_qty = $data['CartsProducts']['qty'];

	/* 
	* used for product discounted price and product discount value
	* based on the calculation by Zach Tanzinco - sep 24, 2014 
	*/
	$discount_value_for_each_product = '';	/* product discount value */
	$discounted_price_for_each_product = 0;
	$total_calculated_amount_for_each_product = 0;
	if( $data['CartsProducts']['qty'] <= 2 ){	/* 1-2 products */
		
		/* check if product has discount_value */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $data['Product']['discount_value'].'%';
		}
		elseif( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '0.00%';
		}
		
		/* For special discount_values (e.g. 75%) */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 75.00 ){
			$the_discount_value = number_format( ($data['Product']['price'] * 0.75), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}
		else{
			$discounted_price_for_each_product = $data['Product']['price'];
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}
		
	}
	elseif( $data['CartsProducts']['qty'] == 3 || $data['CartsProducts']['qty'] <= 5 ){
		
		/* check if product has discount_value - for discount_Value display on product details */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $data['Product']['discount_value'].'%';
		}
		elseif( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '15.00%';
		}

		/* For special discount_values (e.g. 75%) */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 75.00 ){
			$the_discount_value = number_format( ($data['Product']['price'] * 0.75), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}
		else{
			$the_discount_value = number_format( ($data['Product']['price'] * 0.15), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}

		
	}
	elseif( $data['CartsProducts']['qty'] == 6 || $data['CartsProducts']['qty'] <= 11 ){
		
		/* check if product has discount_value */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $data['Product']['discount_value'].'%';
		}
		elseif( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '25.00%';
		}

		/* For special discount_values (e.g. 75%) */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 75.00 ){
			$the_discount_value = number_format( ($data['Product']['price'] * 0.75), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}
		else{
			$the_discount_value = number_format( ($data['Product']['price'] * 0.25), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}

		
	}
	elseif( $data['CartsProducts']['qty'] >= 12 ){
		
		/* check if product has discount_value */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $data['Product']['discount_value'].'%';
		}
		elseif( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '35.00%';
		}

		/* For special discount_values (e.g. 75%) */
		if( isset( $data['Product']['discount_value'] ) && $data['Product']['discount_value'] == 75.00 ){
			$the_discount_value = number_format( ($data['Product']['price'] * 0.75), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}
		else{
			$the_discount_value = number_format( ($data['Product']['price'] * 0.35), 2, '.', ', ');
			$discounted_price_for_each_product = $data['Product']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $data['CartsProducts']['qty'] * $discounted_price_for_each_product;
		}

		
	}
	$price = $discounted_price_for_each_product;
	$discount = $discount_value_for_each_product;
	$totalamount = "$".number_format($total_calculated_amount_for_each_product, 2, '.' , ', ');
	/* end */

	/*$price = $data['CartsProducts']['price'];
	$discount = $data['Product']['discount_value'];
	$totalamount = $data['CartsProducts']['qty'] * $data['Product']['price'];
	$totalamount = "$".number_format($totalamount,2,'.',0);*/
$html .= <<<ENDHTML
	<tr>
	<td>$image_name</td>
	<td style="text-align: center;">$prod_number</td>
	<td style="text-align: center;">$color</td>
	<td style="text-align: center;">$cp_qty</td>
	<td style="text-align: center;">$price</td>
	<td style="text-align: center;">$discount</td>
	<td style="text-align: center;">$totalamount</td>
	</tr>
ENDHTML;
}
$html .= <<<ENDHTML
	</tbody>
	</table>
</body>
</html>
ENDHTML;
			 
			$dompdf->load_html($html);
			$dompdf->render();
			 
			$dompdf->stream("export_to_pdf.pdf");

	        /*
	        *	end PDF conversion with images
	        */

	}
	/* end of Export to PDF */

	/* Export to Windoi */
	public function export_to_windoi($id = null){

		$all_datas = array();

		/*salesreps*/
		$this->loadModel('Salesrep');
		$salesreps = $this->Salesrep->find('list');
		$this->set('salesreps', $salesreps);


		/*first row */
		$firstRow = "Customer Cart Information";
		$this->set('firstRow',$firstRow);

		/*filename */
		$filename = "customer-cart-details.xls";
		$this->set('filename',$filename);

		/* 1 */
		$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
		$options['contain'] = array('Customer');
		$options['fields'] = array('Cart.*','Customer.*', 'Coupon.*', 'Package.*', 'Shipping.*');
		/* for coupon and package */
		$options['joins'] = array(
								array(
									'table'=>'coupons',
									'alias'=>'Coupon',
									'type'=>'left',
									'conditions'=>array('Coupon.id=Cart.coupon_id')
								),
								array(
									'table'=>'productpackages',
									'alias'=>'Package',
									'type'=>'left',
									'conditions'=>array('Package.id=Cart.package_id')
								),
								array(
									'table'=>'shippings',
									'alias'=>'Shipping',
									'type'=>'left',
									'conditions'=>array('Shipping.cust_id=Cart.customer_id')
								)
		);
		/* end of for coupon and package */
		//$this->request->data = $this->Cart->find('first', $options);
		$all_datas['customer_details'] = $this->Cart->find('first', $options);
		/* end of 1 */


		/* for salesreps - oct 7, 2014 */
		if( isset($all_datas['customer_details']['Customer']['salesrep_id']) && $all_datas['customer_details']['Customer']['salesrep_id'] != 0 ){
			$all_datas['customer_details']['sales_representative'] = ucfirst($salesreps[ $all_datas['customer_details']['Customer']['salesrep_id'] ]);
		}
		elseif( isset($all_datas['customer_details']['Customer']['salesrep']) && $all_datas['customer_details']['Customer']['salesrep'] != '' ){
			$all_datas['customer_details']['sales_representative'] = ucfirst( $all_datas['customer_details']['Customer']['salesrep'] );
		}
		else{
			$all_datas['customer_details']['sales_representative'] = 'No Sales Representative.';
		}
		/**/



		/* 2 */
		/* for Customer Products */
		$options = array();
		$options['conditions'] = array('Cart.id'=>$id);
		$options['fields'] = array('Product.*','CartsProducts.*','Color.name');
		$options['joins'] = array(
								array(
				                     'table'=>'carts_products',
				                     'alias'=>'CartsProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('CartsProducts.cart_id=Cart.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('CartsProducts.product_id=Product.id')
				                ),
				                array(
				                     'table'=>'colors',
				                     'alias'=>'Color',
				                     'type' =>'left',
				                     'conditions'=>array('Product.color_id=Color.id')					                	
				                )     
			                );

		
		$datas = $this->Cart->find('all',$options);
		//$this->set('carts_products',$datas);
		$all_datas['customer_products'] = $datas;
		/* end of 2 */


		$this->set('all_datas', $all_datas);

		ini_set('memory_limit', '512M');

		ini_set('max_execution_time','9999');
		
		$this->render('cart_details_export_xls');
	}
	/* end of Export to Windoi */

	/* Export to Windoi with Images */
	public function export_to_windoi_images($id = null){

		$all_datas = array();


		/*first row */
		$firstRow = "Customer Cart Information";
		$this->set('firstRow',$firstRow);

		/*filename */
		$filename = "customer-cart-details.xls";
		$this->set('filename',$filename);

		/* 1 */
		$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
		$options['contain'] = array('Customer');
		$options['fields'] = array('Cart.*','Customer.*', 'Coupon.*', 'Package.*', 'Shipping.*');
		/* for coupon and package */
		$options['joins'] = array(
								array(
									'table'=>'coupons',
									'alias'=>'Coupon',
									'type'=>'left',
									'conditions'=>array('Coupon.id=Cart.coupon_id')
								),
								array(
									'table'=>'productpackages',
									'alias'=>'Package',
									'type'=>'left',
									'conditions'=>array('Package.id=Cart.package_id')
								),
								array(
									'table'=>'shippings',
									'alias'=>'Shipping',
									'type'=>'left',
									'conditions'=>array('Shipping.cust_id=Cart.customer_id')
								)
		);
		/* end of for coupon and package */
		//$this->request->data = $this->Cart->find('first', $options);
		$all_datas['customer_details'] = $this->Cart->find('first', $options);
		/* end of 1 */



		/* 2 */
		/* for Customer Products */
		$options = array();
		$options['conditions'] = array('Cart.id'=>$id);
		$options['fields'] = array('Product.*','CartsProducts.*','Color.name');
		$options['joins'] = array(
								array(
				                     'table'=>'carts_products',
				                     'alias'=>'CartsProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('CartsProducts.cart_id=Cart.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('CartsProducts.product_id=Product.id')
				                ),
				                array(
				                     'table'=>'colors',
				                     'alias'=>'Color',
				                     'type' =>'left',
				                     'conditions'=>array('Product.color_id=Color.id')					                	
				                )     
			                );

		
		$datas = $this->Cart->find('all',$options);
		//$this->set('carts_products',$datas);
		$all_datas['customer_products'] = $datas;
		/* end of 2 */


		$this->set('all_datas', $all_datas);

		ini_set('memory_limit', '512M');

		ini_set('max_execution_time','9999');
		
		$this->render('cart_details_export_images_xls');
	}
	/* end of Export to Windoi with Images */

	/* Delete All Items */
	public function delete_all_items($id = null ){
		/* for Customer Products */
		$options = array();
		$options['conditions'] = array('Cart.id'=>$id);
		$options['fields'] = array('Product.*','CartsProducts.*','Color.name');
		$options['joins'] = array(
								array(
				                     'table'=>'carts_products',
				                     'alias'=>'CartsProducts',
				                     'type' =>'inner',
				                     'conditions'=>array('CartsProducts.cart_id=Cart.id')
				                ),
								array(
				                     'table'=>'products',
				                     'alias'=>'Product',
				                     'type' =>'inner',
				                     'conditions'=>array('CartsProducts.product_id=Product.id')
				                ),
				                array(
				                     'table'=>'colors',
				                     'alias'=>'Color',
				                     'type' =>'left',
				                     'conditions'=>array('Product.color_id=Color.id')					                	
				                )     
			                );

		
		$datas = $this->Cart->find('all',$options);
		//$this->set('carts_products',$datas);
		$all_datas['customer_products'] = $datas;
		/* end of 2 */

		$carts_products = array();
		foreach( $datas as $data ){
			$carts_products[] = $data['CartsProducts']['id'];
		}
		
		$this->loadModel('CartsProduct');
		foreach( $carts_products as $carts_product ){
			$this->CartsProduct->delete( $carts_product );
		}
		
		$this->Session->setFlash('<strong>Cart Products Removed!</strong>','default',array('class' =>'alert alert-success'));
		return $this->redirect(array('action' => 'edit/'.$id.''));
	}
	/* end of Delete All Items */

}