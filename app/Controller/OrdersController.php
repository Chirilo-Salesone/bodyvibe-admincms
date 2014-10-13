<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $layout = false;

	private $item_per_file = 200;


/**
 * index method
 *
 * @return void
 */

	public function beforeFilter(){

		parent::beforeFilter();

		/* Removing the search box */
		$this->set('show_search_box',false);

		$this->set('page_title',"Orders");

	}

	public function index() {
		$this->set('page_title','Order List');
		/*orders standard(no search) - sep 24, 2014*/
		$options = array();
		/*$options['fields'] = array('Order.*', 'OrderCustomer.*', 'Payment.*','OrderCoupon.*', 'OrderSalesrep.*', 'OrderPackage.*');*/
		/* optimized fields - oct 7, 2014 */
		$options['fields'] = array('Order.id', 'Order.added', 'Order.mode', 'Order.status', 'OrderCustomer.ship_fname', 'OrderCustomer.ship_lname', 'OrderCustomer.ship_company', 'Payment.charge');
		$options['order'] = "Order.added DESC";
		$options['limit'] = 20;
		$options['joins'] = array(
								array(
									'table'=>'ordercustomers',
									'alias'=>'OrderCustomer',
									'type'=>'inner',
									'conditions'=>array('OrderCustomer.order_id=Order.id')
								),
								array(
									'table'=>'payments',
									'alias'=>'Payment',
									'type'=>'inner',
									'conditions'=>array('Payment.id=Order.payment_id')
								)
								/* commented out, not incuded in query - oct 7, 2014 *//*,
								array(
									'table'=>'ordercoupons',
									'alias'=>'OrderCoupon',
									'type'=>'left',
									'conditions'=>array('OrderCoupon.order_id=Order.id')
								),
								array(
									'table'=>'ordersalesreps',
									'alias'=>'OrderSalesrep',
									'type'=>'left',
									'conditions'=>array('OrderSalesrep.order_id=Order.id')
								),
								array(
									'table'=>'orderpackages',
									'alias'=>'OrderPackage',
									'type'=>'left',
									'conditions'=>array('OrderPackage.order_id=Order.id')
								)*/
		);
		$options['group'] = "Order.id";	/* removes dupe records - sep 24, 2014 */
		/* end orders standar*/

		/* orders with search */
		if(array_key_exists('search',$this->request->query)){

			$search_query = $this->request->query['search'];
			$search_query .="%";
		
			$options = array();
			/**/
			$options = array();
			/*$options['fields'] = array('Order.*', 'OrderCustomer.*', 'Payment.*','OrderCoupon.*', 'OrderSalesrep.*', 'OrderPackage.*');*/
			/* optimized fields - oct 7, 2014 */
			$options['fields'] = array('Order.id', 'Order.added', 'Order.mode', 'Order.status', 'OrderCustomer.ship_fname', 'OrderCustomer.ship_lname', 'OrderCustomer.ship_company', 'Payment.charge');
			$options['order'] = "Order.added DESC";
			$options['limit'] = 20;
			$options['joins'] = array(
									array(
										'table'=>'ordercustomers',
										'alias'=>'OrderCustomer',
										'type'=>'inner',
										'conditions'=>array('OrderCustomer.order_id=Order.id')
									),
									array(
										'table'=>'payments',
										'alias'=>'Payment',
										'type'=>'inner',
										'conditions'=>array('Payment.id=Order.payment_id')
									)
									/* commented out, not included in query = oct 7, 2014 *//*,
									array(
										'table'=>'ordercoupons',
										'alias'=>'OrderCoupon',
										'type'=>'left',
										'conditions'=>array('OrderCoupon.order_id=Order.id')
									),
									array(
										'table'=>'ordersalesreps',
										'alias'=>'OrderSalesrep',
										'type'=>'left',
										'conditions'=>array('OrderSalesrep.order_id=Order.id')
									),
									array(
										'table'=>'orderpackages',
										'alias'=>'OrderPackage',
										'type'=>'left',
										'conditions'=>array('OrderPackage.order_id=Order.id')
									)*/
			);
			$options['group'] = "Order.id";	/* removes dupe records - sep 24, 2014 */
			/**/
			$options['conditions']['or']['OrderCustomer.email like '] = $search_query;
			$options['conditions']['or']['OrderCustomer.ship_fname like '] = $search_query;
			$options['conditions']['or']['OrderCustomer.ship_lname like '] = $search_query;
			$options['conditions']['or']["CONCAT(OrderCustomer.ship_fname, ' ', OrderCustomer.ship_lname) like"] = $search_query;
			$options['conditions']['or']["CONCAT(OrderCustomer.ship_lname, ' ', OrderCustomer.ship_fname) like"] = $search_query;
			$options['conditions']['or']['OrderCustomer.ship_company like '] = $search_query;
			$options['conditions']['or']['OrderCustomer.email like '] = $search_query;		

			$options['limit'] = 20;
			$this->Paginator->settings = $options;

			$this->set('customers', $this->Paginator->paginate());
			$this->set('page_title', $this->name." :: Search - ".$this->request->query['search']);		
			
			
		}
		/* end orders with search */

		$this->Paginator->settings = $options;
		$this->set('orders', $this->Paginator->paginate());
		$this->set('show_search_box',$this->show_search_box);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {



		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
		$this->set('order', $this->Order->find('first', $options));
	}

	public function edit($id = null) {



		if (!$this->Order->exists($id)) throw new NotFoundException('Invalid Orders');

		/*salesreps*/
		$this->loadModel('Salesrep');
		$this->set('salesreps', $this->Salesrep->find('list'));


		if ($this->request->is(array('post', 'put'))) {

			if ($this->Order->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Order Updated!</strong>','default',array('class' =>'alert alert-success'));

			} else {
				 $this->Session->setFlash('<strong>The Order could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {

			/*orders*/ /* this is correct, this fetches the correct salesrep for the user */
			$options = array();
			$options['conditions'] = array('Order.id'=> $id);
			$options['contain'] = array('Customer');
			/*$options['fields'] = array('Order.*', 'Customer.*', 'OrderCustomer.*', 'Payment.*','OrderCoupon.*', 'OrderSalesrep.*', 'OrderPackage.*', 'Shipping.*', 'OrderTracking.*');*/
			/* optimized fields - oct 7, 2014 */
			$options['fields'] = array('Order.id', 'Order.mode', 'Order.added', 'Order.volumediscount', 
				'Customer.salesrep_id', 
				'OrderCustomer.ship_fname', 'OrderCustomer.ship_lname', 'OrderCustomer.email',  'OrderCustomer.ship_phone',  'OrderCustomer.added',  'OrderCustomer.modified',
				'OrderCustomer.bill_company',  'OrderCustomer.bill_street',  'OrderCustomer.bill_city',  'OrderCustomer.bill_state',  'OrderCustomer.bill_country',  'OrderCustomer.bill_postcode',
				'OrderCustomer.ship_company',  'OrderCustomer.ship_street',  'OrderCustomer.ship_city',  'OrderCustomer.ship_state',  'OrderCustomer.ship_country',  'OrderCustomer.ship_postcode',
				'Payment.charge', 'Payment.name', 
				'OrderCoupon.id', 'OrderCoupon.name', 'OrderCoupon.details', 'OrderCoupon.promocode', 'OrderCoupon.discountrate',
				/*'OrderSalesrep.*',*/
				'OrderPackage.cost',
				'Shipping.upsServicePrice', 'Shipping.upsServiceName', 'Shipping.id', 'Shipping.country', 'Shipping.zip', 'Shipping.date_transacted',
				'OrderTracking.id', 'OrderTracking.tracking_number', 'OrderTracking.invoice_number', 'OrderTracking.shipdate', 'OrderTracking.total_invoice', 'OrderTracking.attached_file', 'OrderTracking.comment');
			$options['joins'] = array(
									array(
										'table'=>'ordercustomers',
										'alias'=>'OrderCustomer',
										'type'=>'inner',
										'conditions'=>array('OrderCustomer.order_id=Order.id')
									),
									array(
										'table'=>'payments',
										'alias'=>'Payment',
										'type'=>'left',
										'conditions'=>array('Payment.id=Order.payment_id')
									),
									array(
										'table'=>'shippings',
										'alias'=>'Shipping',
										'type'=>'inner',
										'conditions'=>array('Shipping.id=Order.shipping_id')
									),
									array(
										'table'=>'ordercoupons',
										'alias'=>'OrderCoupon',
										'type'=>'left',
										'conditions'=>array('OrderCoupon.order_id=Order.id')
									),
									array(
										'table'=>'ordersalesreps',
										'alias'=>'OrderSalesrep',
										'type'=>'left',
										'conditions'=>array('OrderSalesrep.order_id=Order.id')
									),
									array(
										'table'=>'orderpackages',
										'alias'=>'OrderPackage',
										'type'=>'left',
										'conditions'=>array('OrderPackage.order_id=Order.id')
									),
									/* tracking information */
									array(
										'table'=>'orders_tracking',
										'alias'=>'OrderTracking',
										'type'=>'left',
										'conditions'=>array('OrderTracking.order_id=Order.id')
									)
			);

			
			$datas = $this->Order->find('first',$options);
			$this->set('datas',$datas);
			/* end of orders */

			/* products */
			$options = array();
			$options['conditions'] = array('Order.id'=> $id);
			/*$options['fields'] = array('OrderDetail.*', 'OrderProduct.*', 'Color.*', 'ProductDimension.weight');*/
			$options['fields'] = array('OrderDetail.qty', 
				'OrderProduct.image_name', 'OrderProduct.number', 'OrderProduct.discount_value', 'OrderProduct.weight', 'OrderProduct.price', 
				'Color.name');
			$options['joins'] = array(
									array(
										'table'=>'orderdetails',
										'alias'=>'OrderDetail',
										'type'=>'inner',
										'conditions'=>array('OrderDetail.order_id=Order.id')
									),
									array(
										'table'=>'orderproducts',
										'alias'=>'OrderProduct',
										'type'=>'inner',
										'conditions'=>array('OrderProduct.orderdetail_id=OrderDetail.id')
										/*'conditions'=>array('OrderProduct.number=OrderDetail.number')*/
									),
									array(
										'table'=>'colors',
										'alias'=>'Color',
										'type'=>'left',
										'conditions'=>array('Color.id=OrderProduct.color_id')
									)
			);

			$productdatas = $this->Order->find('all', $options);
			/*pr( $productdatas );exit();*/
			$this->set('productdatas', $productdatas);
			/* end of products */
		}
			
			

	}	

	public function activate($id = null) {

		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid Order'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Order']['id'] = $this->Order->id;
		$params['Order']['status'] = "active";


		if ($this->Order->save($params)) {

			$this->Session->setFlash('<strong>The Order has been Activated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The Order could not be Activated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function deactivate($id = null) {

		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid Order'));
			exit();
		}

		$this->request->onlyAllow('post');

		$params = array();
		$params['Order']['id'] = $this->Order->id;
		$params['Order']['status'] = "inactive";


		if ($this->Order->save($params)) {

			$this->Session->setFlash('<strong>The Order has been Deactivated.</strong>','default',array('class'=>'alert alert-success'));

		} else {

			$this->Session->setFlash('<strong>The Order could not be Deactivated. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

		}


		return $this->redirect(array('action' => 'index'));
	}


	public function update_order(){
		/*pr( $_POST );*/

		$this->Order->id = $_POST['oid'];
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid Order'));
			exit();
		}

		$this->request->onlyAllow('post');
		$params = array();
		$params['Order']['id'] = $this->Order->id;
		$params['Order']['mode'] = $_POST['mode'];

		if ($this->Order->save($params)) {

			echo 'Success! Order Mode Updated!';

		} else {

			echo 'Error occured when updating Order Mode. Try Again!';

		}
		exit();

	}


	/* Export to PDF */
	public function export_to_pdf($id = null){

		if (!$this->Order->exists($id)) throw new NotFoundException('Invalid Order');


		/*salesreps*/
		$this->loadModel('Salesrep');
		$salesreps = $this->Salesrep->find('list');
		$this->set('salesreps', $salesreps );


		if ($this->request->is(array('post', 'put'))) {

			if ($this->Order->save($this->request->data)) {

				 $this->Session->setFlash('<strong>Cart Updated!</strong>','default',array('class' =>'alert alert-success'));

			} else {
				 $this->Session->setFlash('<strong>The Cart could not be saved. Please, try again.</strong>','default',array('class' =>'alert alert-danger'));
			}
		} else {

			/*orders*/
			$options = array();
			$options['conditions'] = array('Order.id'=> $id);
			$options['fields'] = array('Order.*', 'OrderCustomer.*', 'Payment.*','OrderCoupon.*', 'OrderSalesrep.*', 'OrderPackage.*', 'Shipping.*', 'Customer.*');
			$options['joins'] = array(
									array(
										'table'=>'ordercustomers',
										'alias'=>'OrderCustomer',
										'type'=>'inner',
										'conditions'=>array('OrderCustomer.order_id=Order.id')
									),
									array(
										'table'=>'payments',
										'alias'=>'Payment',
										'type'=>'inner',
										'conditions'=>array('Payment.id=Order.payment_id')
									),
									array(
										'table'=>'shippings',
										'alias'=>'Shipping',
										'type'=>'inner',
										'conditions'=>array('Shipping.id=Order.shipping_id')
									),
									array(
										'table'=>'ordercoupons',
										'alias'=>'OrderCoupon',
										'type'=>'left',
										'conditions'=>array('OrderCoupon.order_id=Order.id')
									),
									array(
										'table'=>'ordersalesreps',
										'alias'=>'OrderSalesrep',
										'type'=>'left',
										'conditions'=>array('OrderSalesrep.order_id=Order.id')
									),
									array(
										'table'=>'orderpackages',
										'alias'=>'OrderPackage',
										'type'=>'left',
										'conditions'=>array('OrderPackage.order_id=Order.id')
									),
									array(
										'table'=>'customers',
										'alias'=>'Customer',
										'type'=>'left',
										'conditions'=>array('OrderCustomer.customer_id=Customer.id')
									)
			);

			
			$datas = $this->Order->find('first',$options);
			$this->set('datas',$datas);

			/*pr( $datas );
			exit();*/
			/* end of orders */

		}
			
			/* products */
			$options = array();
			$options['conditions'] = array('Order.id'=> $id);
			/*$options['fields'] = array('OrderDetail.*', 'OrderProduct.*', 'Color.*', 'ProductDimension.weight');*/
			$options['fields'] = array('OrderDetail.*', 'OrderProduct.*', 'Color.*');
			$options['joins'] = array(
									array(
										'table'=>'orderdetails',
										'alias'=>'OrderDetail',
										'type'=>'inner',
										'conditions'=>array('OrderDetail.order_id=Order.id')
									),
									array(
										'table'=>'orderproducts',
										'alias'=>'OrderProduct',
										'type'=>'inner',
										'conditions'=>array('OrderProduct.orderdetail_id=OrderDetail.id')
									),
									array(
										'table'=>'colors',
										'alias'=>'Color',
										'type'=>'left',
										'conditions'=>array('Color.id=OrderProduct.color_id')
									),
									array(
										'table'=>'productdimensions',
										'alias'=>'ProductDimension',
										'type'=>'left',
										'conditions'=>array('ProductDimension.product_id=OrderProduct.product_id')
									)
			);

			$productdatas = $this->Order->find('all', $options);
			$this->set('productdatas', $productdatas);
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
$bill_company = $datas['OrderCustomer']['bill_company'];
$bill_street = $datas['OrderCustomer']['bill_street'];
$bill_city = $datas['OrderCustomer']['bill_city'];
$bill_state = $datas['OrderCustomer']['bill_state'];
$bill_country = $datas['OrderCustomer']['bill_country'];
$bill_zip = $datas['OrderCustomer']['bill_postcode'];
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
		<h1>  </h1>
		<h1>  </h1>
		<h1>  </h1>
ENDHTML;

$html .= <<<ENDHTML
		<div style="margin-bottom: 100px">
		<h1> Shipping Information</h1>
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
$ship_company = $datas['OrderCustomer']['ship_company'];
$ship_street = $datas['OrderCustomer']['ship_street'];
$ship_city = $datas['OrderCustomer']['ship_city'];
$ship_state = $datas['OrderCustomer']['ship_state'];
$ship_country = $datas['OrderCustomer']['ship_country'];
$ship_zip = $datas['OrderCustomer']['ship_postcode'];
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
		<h1>  </h1>
		<h1>  </h1>
		<h1>  </h1>
ENDHTML;

$html .= <<<ENDHTML
		<div style="margin-bottom: 100px">
		<h1> Sales Representative</h1>
		<table width="100%" border="1" align="left"  style="font:Verdana, Arial, Helvetica, sans-serif; margin-bottom: 100px;">
			
			<tbody>
ENDHTML;
if( isset($datas['Customer']['salesrep_id']) && $datas['Customer']['salesrep_id'] != 0 ){
	$sales_representative = ucfirst($salesreps[$datas['Customer']['salesrep_id']]);
}
elseif( isset($datas['Customer']['salesrep']) && $datas['Customer']['salesrep'] != '' ){
	$sales_representative = ucfirst( $datas['Customer']['salesrep'] );
}
else{
	$sales_representative = 'No Sales Representative.';
}

$html .= <<<ENDHTML
				<tr>
				<th style="background-color: #cccccc;">Sales Representative</th>
				<td style="text-align: center;">$sales_representative</td>
				</tr>
			</tbody>
		</table>
		</div>
		<h1>  </h1>
		<h1>  </h1>
		<h1>  </h1>
ENDHTML;


$html .= <<<ENDHTML
		<div style="margin-bottom: 0px;">
		<h1> Order Details </h1>
		<table width="100%" border="1" align="left"  style="font:Verdana, Arial, Helvetica, sans-serif; margin-bottom: 100px;">
			
			<tbody>
ENDHTML;
$order_number = $datas['Order']['id'];
$order_date = date('F d, Y H:i:s a', strtotime($datas['Order']['added']));
$order_shipping = '+'. $datas['Shipping']['upsServicePrice']. ' <strong>('. $datas['Shipping']['upsServiceName'] .')</strong>';
if( $datas['Payment']['name'] == 'cod' ){
	$order_payment = '+ $12.00'. ' <strong>('. $datas['Payment']['name'] .')</strong>';
	$order_subtotal = '$'.number_format( (($datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice'] - 12) - $datas['OrderPackage']['cost']), 2, '.', ' ,');
}
else{
	$order_payment = '+ $0.00'. ' <strong>('. $datas['Payment']['name'] .')</strong>';
	$order_subtotal = '$'.number_format( (($datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice']) - $datas['OrderPackage']['cost']), 2, '.', ' ,');
}
$order_package = '+ $'. $datas['OrderPackage']['cost'];
if( $datas['OrderCoupon']['id'] != '' ){
	$order_coupon = '- $'. $datas['OrderCoupon']['discountrate'];
}
else{
	$order_coupon = '- $0.00';
}
if( $datas['Order']['volumediscount'] != '' || $datas['Order']['volumediscount'] != NULL ){
	$order_volumediscount = '- $'.$datas['Order']['volumediscount'];
}
else{
	$order_volumediscount = '- $0.00';
}
/*if( $datas['Shipping']['upsServicePrice'] != '' || $datas['Shipping']['upsServicePrice'] != 0 ){
	$order_subtotal = $order_subtotal - $datas['Shipping']['upsServicePrice'];
}*/
$order_total_amount = '<strong>$'.$datas['Payment']['charge'].'</strong>';

$html .= <<<ENDHTML
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Order #</th>
				<td style="text-align: left; margin-left: 10px;"><strong># $order_number</strong></td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Order Date</th>
				<td style="text-align: left; margin-left: 10px;">$order_date</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Subtotal</th>
				<td style="text-align: left; margin-left: 10px;">$order_subtotal</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Shipping</th>
				<td style="text-align: left; margin-left: 10px;">$order_shipping</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Payment</th>
				<td style="text-align: left; margin-left: 10px;">$order_payment</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Packaging Charge</th>
				<td style="text-align: left; margin-left: 10px;">$order_package</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Coupon Discount</th>
				<td style="text-align: left; margin-left: 10px;">$order_coupon</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Volume Discount</th>
				<td style="text-align: left; margin-left: 10px;">$order_volumediscount</td>
				</tr>
				<tr align="left">
				<th style="background-color: #cccccc; width: 30%; margin-left: 10px;">Total Amount</th>
				<td style="text-align: left; margin-left: 10px;">$order_total_amount</td>
				</tr>
			</tbody>
		</table>
		</div>
		<h1>  </h1>
		<h1>  </h1>
		<h1>  </h1>
ENDHTML;


$html .= <<<ENDHTML
	<div style="margin-top: 300px">
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
foreach($productdatas as $productdata){
	$image_name = PRODUCTS_IMAGES_THUMBS.$productdata['OrderProduct']['image_name'].'.jpg';
	if( @getimagesize($image_name) ){
		$image_name = PRODUCTS_IMAGES_THUMBS.$productdata['OrderProduct']['image_name'].'.jpg';
	}
	else{
		$image_name = PRODUCTS_IMAGES_THUMBS.'notavailable.jpg';
	}
	$image_name = '<img src='.$image_name.' width="119" height="104" />';
	$prod_number = $productdata['OrderProduct']['number'];
	$color = $productdata['Color']['name'];
	$cp_qty = $productdata['OrderDetail']['qty'];

	/* 
	* used for product discounted price and product discount value
	* based on the calculation by Zach Tanzinco - sep 24, 2014 
	*/
	$discount_value_for_each_product = '';	/* product discount value */
	$discounted_price_for_each_product = 0;
	$total_calculated_amount_for_each_product = 0;
	if( $productdata['OrderDetail']['qty'] <= 2 ){	/* 1-2 products */
		
		/* check if product has discount_value */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
		}
		elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '0.00%';
		}
		
		/* For special discount_values (e.g. 75%) */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}
		else{
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'];
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}
		
	}
	elseif( $productdata['OrderDetail']['qty'] == 3 || $productdata['OrderDetail']['qty'] <= 5 ){
		
		/* check if product has discount_value - for discount_Value display on product details */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
		}
		elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '15.00%';
		}

		/* For special discount_values (e.g. 75%) */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}
		else{
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.15), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.15);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}

		
	}
	elseif( $productdata['OrderDetail']['qty'] == 6 || $productdata['OrderDetail']['qty'] <= 11 ){
		
		/* check if product has discount_value */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
		}
		elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '25.00%';
		}

		/* For special discount_values (e.g. 75%) */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}
		else{
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.25), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.25);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}

		
	}
	elseif( $productdata['OrderDetail']['qty'] >= 12 ){
		
		/* check if product has discount_value */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
			$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
		}
		elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
			$discount_value_for_each_product = '35.00%';
		}

		/* For special discount_values (e.g. 75%) */
		if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}
		else{
			/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.35), 2, '.', ', ');*/
			$the_discount_value = ($productdata['OrderProduct']['price'] * 0.35);
			$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
			$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
		}

		
	}
	/*$price = $discounted_price_for_each_product;*/
	$price = number_format($discounted_price_for_each_product, 2, '.', ', ');
	$discount = $discount_value_for_each_product;
	$totalamount = number_format($total_calculated_amount_for_each_product, 2, '.', ', ');
	/**/



	/*commented out on oct 2, 2014*/
	/*$price = $productdata['OrderProduct']['price'];
	$discount = $productdata['OrderProduct']['discount_value'];
	$totalamount = $productdata['OrderDetail']['qty'] * $productdata['OrderProduct']['price'];
	$totalamount = "$".number_format($totalamount,2,'.', ' ,');*/
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
	</div>
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
		$this->set('salesreps', $salesreps );


		/*first row */
		$firstRow = "Customer Order Information";
		$this->set('firstRow',$firstRow);

		/*filename */
		$filename = "customer-order-details.xls";
		$this->set('filename',$filename);

		/* 1 */
		/*orders*/
		$options = array();
		$options['conditions'] = array('Order.id'=> $id);
		$options['fields'] = array('Order.*', 'OrderCustomer.*', 'Payment.*','OrderCoupon.*', 'OrderSalesrep.*', 'OrderPackage.*', 'Shipping.*', 'Customer.*');
		$options['joins'] = array(
								array(
									'table'=>'ordercustomers',
									'alias'=>'OrderCustomer',
									'type'=>'inner',
									'conditions'=>array('OrderCustomer.order_id=Order.id')
								),
								array(
									'table'=>'payments',
									'alias'=>'Payment',
									'type'=>'inner',
									'conditions'=>array('Payment.id=Order.payment_id')
								),
								array(
									'table'=>'shippings',
									'alias'=>'Shipping',
									'type'=>'inner',
									'conditions'=>array('Shipping.id=Order.shipping_id')
								),
								array(
									'table'=>'ordercoupons',
									'alias'=>'OrderCoupon',
									'type'=>'left',
									'conditions'=>array('OrderCoupon.order_id=Order.id')
								),
								array(
									'table'=>'ordersalesreps',
									'alias'=>'OrderSalesrep',
									'type'=>'left',
									'conditions'=>array('OrderSalesrep.order_id=Order.id')
								),
								array(
									'table'=>'orderpackages',
									'alias'=>'OrderPackage',
									'type'=>'left',
									'conditions'=>array('OrderPackage.order_id=Order.id')
								),
								array(
									'table'=>'customers',
									'alias'=>'Customer',
									'type'=>'left',
									'conditions'=>array('OrderCustomer.customer_id=Customer.id')
								)
		);

		
		$datas = $this->Order->find('first',$options);
		$this->set('datas',$datas);
		/* end of 1 */


		/* for salesreps - oct 7, 2014 */
		if( isset($datas['Customer']['salesrep_id']) && $datas['Customer']['salesrep_id'] != 0 ){
			$datas['CustomerSalesRep']['sales_representative'] = ucfirst($salesreps[$datas['Customer']['salesrep_id']]);
		}
		elseif( isset($datas['Customer']['salesrep']) && $datas['Customer']['salesrep'] != '' ){
			$datas['CustomerSalesRep']['sales_representative'] = ucfirst( $datas['Customer']['salesrep'] );
		}
		else{
			$datas['CustomerSalesRep']['sales_representative'] = 'No Sales Representative.';
		}
		/**/


		/* 2 */
		/* products */
		$options = array();
		$options['conditions'] = array('Order.id'=> $id);
		/*$options['fields'] = array('OrderDetail.*', 'OrderProduct.*', 'Color.*', 'ProductDimension.weight');*/
		$options['fields'] = array('OrderDetail.*', 'OrderProduct.*', 'Color.*');
		$options['joins'] = array(
								array(
									'table'=>'orderdetails',
									'alias'=>'OrderDetail',
									'type'=>'inner',
									'conditions'=>array('OrderDetail.order_id=Order.id')
								),
								array(
									'table'=>'orderproducts',
									'alias'=>'OrderProduct',
									'type'=>'inner',
									'conditions'=>array('OrderProduct.orderdetail_id=OrderDetail.id')
								),
								array(
									'table'=>'colors',
									'alias'=>'Color',
									'type'=>'left',
									'conditions'=>array('Color.id=OrderProduct.color_id')
								),
								array(
									'table'=>'productdimensions',
									'alias'=>'ProductDimension',
									'type'=>'left',
									'conditions'=>array('ProductDimension.product_id=OrderProduct.product_id')
								)
		);

		$productdatas = $this->Order->find('all', $options);
		$this->set('productdatas', $productdatas);
		/* end of 2 */


		$merged = array();
		$merged['order_data'] = $datas;
		$merged['product_data'] = $productdatas;


		/*pr( $productdatas );
		exit();*/


		/*$this->set('all_datas', $productdatas);*/
		$this->set('all_datas', $merged);

		ini_set('memory_limit', '512M');

		ini_set('max_execution_time','9999');
		
		$this->render('order_details_export_xls');
	}
	/* end of Export to Windoi */


	/* Tracking Information */
	public function save_tracking_info($id = null){
		/*pr( $this->request->data );*/
		$tracking_info_data = $this->request->data['TrackingInfo'];
		/*pr( $tracking_info_data );

		echo 'id ni: ';
		pr($id);*/

		/*pr( $this->request->data );
		exit();*/

		$this->loadModel('OrderTracking');
		$params = array();
		if( isset( $tracking_info_data['id'] ) ){
			$params['OrderTracking']['id'] = $tracking_info_data['id'];
		}
		$params['OrderTracking']['order_id'] = $id;
		$params['OrderTracking']['tracking_number'] = $tracking_info_data['trackingNumber'];
		$params['OrderTracking']['invoice_number'] = $tracking_info_data['invoiceNumber'];
		$params['OrderTracking']['shipdate'] = date('Y-m-d h:i:s',strtotime($tracking_info_data['shipDate']));
		$params['OrderTracking']['attached_file'] = $tracking_info_data['invoice_file']['name'];
		$params['OrderTracking']['total_invoice'] = $tracking_info_data['totalInvoice'];
		$params['OrderTracking']['comment'] = $tracking_info_data['comment'];


		$options = array();
		$options['order_id'] = $id;
		$order_tracking_info = $this->OrderTracking->find('first', $options);

		/*pr( $order_tracking_info );
		exit();*/

		if( isset($order_tracking_info['OrderTracking']['id']) ){
			//if( $order_tracking_info['OrderTracking']['order_id'] ){
				/* file upload */
				if( isset($tracking_info_data['invoice_file']['name']) ){

					/*$dest_filename = strtolower($tracking_info_data['invoice_file']['name'];);
					$dest_filename = str_replace(' ','-',$dest_filename);*/
					$dest_filename = $tracking_info_data['invoice_file']['name'];
					$targetPath = "files".DS.basename($dest_filename);
					/*$targetPath = WWW_ROOT."files".DS.basename($dest_filename);*/

					move_uploaded_file($tracking_info_data['invoice_file']['tmp_name'],$targetPath);

				}
				/* end of file upload */
				if( $this->OrderTracking->save($params) ) {

					$this->Session->setFlash('<strong>The Order Tracking Information has been saved.</strong>','default',array('class'=>'alert alert-success'));

				} else {

					$this->Session->setFlash('<strong>The Order Tracking Information could not be saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );

				}
			//}
		}
		else{
			if( $this->OrderTracking->save($params) ){
				$this->Session->setFlash('<strong>The Order Tracking Information has been saved.</strong>','default',array('class'=>'alert alert-success'));
			}
			else{
				$this->Session->setFlash('<strong>The Order Tracking Information could not be saved. Please, try again.</strong>','default',array('class'=>'alert alert-danger') );
			}
		}

		
		


		return $this->redirect(array('action' => 'edit/'.$id.''));


		//exit();
	}
	/* end of Tracking Information */

	/* Send Order Information to Email */
	public function send_order_information($order_tracking_info_id){

		$this->loadModel('OrderTracking');
		$options = array();
		$options['conditions'] = array('OrderTracking.id'=> $order_tracking_info_id);
		$options['fields'] = array('OrderTracking.*');
		$order_tracking_info = $this->OrderTracking->find('first', $options);

		/**/
		/*orders*/
		$options = array();
		$options['conditions'] = array('Order.id'=> $order_tracking_info['OrderTracking']['order_id']);
		$options['fields'] = array('Order.*', 'OrderCustomer.*');
		$options['joins'] = array(
								array(
									'table'=>'ordercustomers',
									'alias'=>'OrderCustomer',
									'type'=>'inner',
									'conditions'=>array('OrderCustomer.order_id=Order.id')
								)
		);
		$ordercustomerdata = $this->Order->find('all', $options);
		$this->set('ordercustomerdata', $ordercustomerdata);
		/*pr( $ordercustomerdata[0]['OrderCustomer']['email'] );
		exit();*/
		/**/

		/* target path for file attachment */
		$target = WWW_ROOT.'files/'.$order_tracking_info['OrderTracking']['attached_file'];
		/* Sending of Email */
		$Email = new CakeEmail();	/* As of October 14, 2014 - OrderTracking Info emails are sent however they are considered as SPAM */
		$Email->from(array('info@bodyvibe.com' => 'Body Vibe: Your Order Tracking Information'));
		$Email->to($ordercustomerdata[0]['OrderCustomer']['email']);
		$Email->subject('Order Tracking Information');
		$Email->message('Order Tracking Information message details.');
		$Email->attachments($target);
		$message = 'This is your Order Tracking Information for Order#: '.$order_tracking_info['OrderTracking']['order_id'].' - ';
		$message .= 'Tracking Number: '.$order_tracking_info['OrderTracking']['tracking_number'].' - ';
		$message .= 'Invoice Number: '.$order_tracking_info['OrderTracking']['invoice_number'].' - ';
		$message .= 'Ship Date: '.$order_tracking_info['OrderTracking']['shipdate'].' - ';
		$message .= 'File Attachment: '.$order_tracking_info['OrderTracking']['attached_file'].' - ';
		$message .= 'Total Invoice: '.$order_tracking_info['OrderTracking']['total_invoice'].' - ';
		$message .= 'Comment: '.$order_tracking_info['OrderTracking']['comment'].' - ';

		if( $Email->send($message) ){
			$this->Session->setFlash('<strong>An Email (Order Tracking Information) was Successfully Sent to the customer!</strong>','default',array('class'=>'alert alert-success'));
		}
		else{
			$this->Session->setFlash('<strong>Email was not Successfully sent. Please try again!</strong>','default',array('class'=>'alert alert-danger') );
		}

		/* end of Sending Email
		 */

		return $this->redirect(array('action' => 'edit/'.$order_tracking_info['OrderTracking']['order_id'].''));

	}
	/* end of Send Order Information to Email */


	

}