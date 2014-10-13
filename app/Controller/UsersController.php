<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function beforeFilter(){

		parent::beforeFilter();
		$this->Auth->allow('validateuser','login');

		if($this->Auth->loggedIn()){

			$this->layout = "user";

		}

		$this->set('page_title',"Admin Home");

		$this->set('show_search_box',false);

	}

	public function index(){


		/* loading a model */
		$this->loadModel('Product');

		/* Products */
		$products = array();

			$this->Product->recursive = -1;

			/* counting no description products */
			$options = array();
			$options['conditions']['description'] = "";
			$products['without_descriptions'] = $this->Product->find('count',$options);
			$products['without_descriptions'] = $this->Product->find('count',$options);

			/* count onsale products */
			$data = $this->Product->query("Select count(*) as count_onsale_items from products_images_onsales as Product_image_onsale ");
			$products['count_onsale_items'] = $data[0][0]['count_onsale_items'];

			/* count newstyle products */
			$data = $this->Product->query("Select count(*) as count_newstyles_items from products_images_newstyles as Product_image_newstyle ");
			$products['count_newstyles_items'] = $data[0][0]['count_newstyles_items'];		

			/* images */
			$data = $this->Product->query("Select count(*) as count_image_items from products_images ");
			$products['count_image_items'] = $data[0][0]['count_image_items'];	

			/* */
			$data = $this->Product->query("Select count(*) as count_items from products ");
			$products['count_items'] = $data[0][0]['count_items'];	

			$data = $this->Product->query("Select count(*) as count_active_items from products where status='active' ");
			$products['count_active_items'] = $data[0][0]['count_active_items'];	

			$products['count_inactive_items'] = $products['count_items'] - $products['count_active_items'];


		/* Customers */
		$this->loadModel('Customer');
		$this->Customer->recursive = -1;
		$customers = array();

		/* Monthly */
		$data = $this->Customer->query("select count(id) as monthly_signups from customers where month(added)=month(now()) and year(added)=year(now()) ");
		$customers['count_monthly_signups'] = $data[0][0]['monthly_signups'];	

		/* Weekly */
		$data = $this->Customer->query("select count(id) as weekly_signups from customers where week(added)=week(now()) and year(added)=year(now())");
		$customers['count_weekly_signups'] = $data[0][0]['weekly_signups'];	

		/* Daily */
		$data = $this->Customer->query("select count(id) as daily_signups from customers where date(added)=date(now()) ");
		$customers['count_daily_signups'] = $data[0][0]['daily_signups'];	

		/* Month-Year History */
		$customers_history = array();
		for ($i=0; $i<=11; $i++) { 
			$month_date = date('F Y', strtotime("-$i month"));
			$curr_month_year = date('Y-m-d H:i:s', strtotime("-$i month"));

			/*$data = $this->Customer->query("select count(customers.id) as total_monthly_signups from customers where customers.added < '".$curr_month_year."' and customers.added >= DATE_SUB('".$curr_month_year."', INTERVAL 1 MONTH)");*/
			$data = $this->Customer->query("select count(customers.id) as total_monthly_signups from customers where month(customers.added) = month('".$curr_month_year."') and year(customers.added)= year('".$curr_month_year."')");
			$customers_history[ $month_date ]['total_monthly_signups'] 	= ( isset($data[0][0]['total_monthly_signups']) ? $data[0][0]['total_monthly_signups'] : 0 );
		}




		/* Orders */
		$this->loadModel('Order');
		$this->Order->recursive = -1;
		$orders = array();

		/* Monthly */
		/*$data = $this->Order->query("select count(id) as monthly_orders from orders where added >= DATE_SUB(now(),INTERVAL 1 MONTH) ");*/
		/*$data = $this->Order->query("select count(id) as monthly_orders from orders where month(added) = month(now()) and year(added)=year(now())");
		$orders['count_monthly_orders'] = $data[0][0]['monthly_orders'];*/

		/* Weekly */
		/*$data = $this->Order->query("select count(id) as weekly_orders from orders where week(added)=week(now()) and year(added)=year(now())");
		$orders['count_weekly_orders'] = $data[0][0]['weekly_orders'];*/

		/* Daily */
		/*$data = $this->Order->query("select count(id) as daily_orders from orders where date(added)=date(now()) ");
		$orders['count_daily_orders'] = $data[0][0]['daily_orders'];	*/
		/* end of Orders */


		/* Orders Amount/Payment */
		$orders_amount = array();

		/* Monthly */
		/*$data = $this->Order->query("select sum(charge) as monthly_orders_amount from payments join orders on orders.payment_id=payments.id where month(orders.added)=month(now()) and year(orders.added)=year(now())");*/
		$data = $this->Order->query("select sum(charge) as monthly_orders_amount, count(orders.id) as monthly_orders from payments join orders on orders.payment_id=payments.id where month(orders.added)=month(now()) and year(orders.added)=year(now())");
		$orders_amount['count_monthly_orders_amount'] = $data[0][0]['monthly_orders_amount'];
		$orders['count_monthly_orders'] = $data[0][0]['monthly_orders'];	/* count of orders this month - sep 22, 2014 */

		/* Weekly */
		$data = $this->Order->query("select sum(charge) as weekly_orders_amount, count(orders.id) as weekly_orders from payments join orders on orders.payment_id=payments.id where weekofyear(orders.added)=weekofyear(now()) and year(orders.added)=year(now())");
		$orders_amount['count_weekly_orders_amount'] = $data[0][0]['weekly_orders_amount'];
		$orders['count_weekly_orders'] = $data[0][0]['weekly_orders'];

		/* Daily */
		$data = $this->Order->query("select sum(charge) as daily_orders_amount, count(orders.id) as daily_orders from payments join orders on orders.payment_id=payments.id where date(orders.added) = date(now())");
		$orders_amount['count_daily_orders_amount'] = $data[0][0]['daily_orders_amount'];
		$orders['count_daily_orders'] = $data[0][0]['daily_orders'];
		/* end of Orders Amount */


		/* Carts */
		$this->loadModel('Cart');
		$this->Cart->recursive = -1;
		$carts = array();

		/* Monthly */
		$data = $this->Cart->query("select count(id) as monthly_carts_updated from carts where month(added)=month(now()) and year(added)=year(now()) ");
		$carts['count_monthly_carts_updated'] = $data[0][0]['monthly_carts_updated'];

		/* Weekly */
		$data = $this->Cart->query("select count(id) as weekly_carts_updated from carts where week(added)=week(now()) and year(added)=year(now()) ");
		$carts['count_weekly_carts_updated'] = $data[0][0]['weekly_carts_updated'];

		/* Daily */
		$data = $this->Cart->query("select count(id) as daily_carts_updated from carts where date(added)=date(now())");
		$carts['count_daily_carts_updated'] = $data[0][0]['daily_carts_updated'];
		/* end of Carts */


		/* Orders History */
		$orders_amount_history = array();

		for ($i=0; $i<=11; $i++) { 
			$month_date = date('F Y', strtotime("-$i month"));
			$curr_month_year = date('Y-m-d H:i:s', strtotime("-$i month"));

			/*$data = $this->Order->query("select sum(charge) as total_monthly_orders_amount, count(orders.id) as total_monthly_orders from payments join orders on orders.payment_id=payments.id where orders.added < '".$curr_month_year."' and orders.added >= DATE_SUB('".$curr_month_year."', INTERVAL 1 MONTH)");*/
			$data = $this->Order->query("select sum(charge) as total_monthly_orders_amount, count(orders.id) as total_monthly_orders from payments join orders on orders.payment_id=payments.id where month(orders.added) = month('".$curr_month_year."') and year(orders.added)= year('".$curr_month_year."')");
			$orders_amount_history[ $month_date ]['total_monthly_orders_amount'] 	= ( isset($data[0][0]['total_monthly_orders_amount']) ? $data[0][0]['total_monthly_orders_amount'] : 0 );
			$orders_amount_history[ $month_date ]['total_monthly_orders'] 			= $data[0][0]['total_monthly_orders'];
		}


		/* Search Log */
		$this->loadModel('Searchlog');
		$search_logs = $this->Searchlog->query("SELECT param,count(*) as counter FROM searchlogs group by param ORDER BY counter DESC LIMIT 12");

		$this->set(compact('products','customers', 'orders', 'orders_amount', 'carts', 'orders_amount_history', 'customers_history','search_logs'));

	}


	public function validateuser(){

		$this->autoRender = false;



		if($this->Auth->loggedIn()){

			$redirect = array('controller'=>'users','action'=>'index');
			$this->redirect($redirect);

		}
		else{

			$this->redirect('/users/login');
		}


	}

	public function login(){


			if($this->request->is('post')){

				$options = array();

				$options['conditions']['username'] = $this->request->data['User']['username'];
				$options['conditions']['password'] = $this->request->data['User']['password'];

				$foundRecord = $this->User->find('first',$options);

				if(count($foundRecord) == 1){

					$this->Auth->login($this->request->data['User']);

					$this->request->data['User']['last_login'] = date("Y-m-d H:i:s");
					$this->User->save($this->request->data['User']);


					$params = array();
					$params['controller'] = "users";
					$params['action'] = "index";

					$this->redirect($params);

				}
				else{

					$this->Session->setFlash('Invalid Username and Password');
				}


			}
			else{

					if($this->Auth->loggedIn()){

							$params = array();
							$params['controller'] = "users";
							$params['action'] = "index";
							$this->redirect($params);
					}
			}

	}

	public function logout(){

		$this->Auth->logout();

		$params = array();
		$params['controller'] = "users";
		$params['action'] = "login";
		$this->redirect($params);
	}


}
