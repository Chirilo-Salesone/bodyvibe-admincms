<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$layout_title = "Bodyvibe Admin ";

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $layout_title;?>
		<?php echo $page_title;?>
	</title>

	<?php
	//	echo $this->Html->css('cake.generic.css');
		echo $this->Html->css('bootstrap/bootstrap.min.css');
		echo $this->Html->css('bootstrap/normalize.css');
		echo $this->Html->css('admin.core.css');
		echo $this->Html->css('jquery-ui/themes/base/jquery-ui.css');

		echo $this->fetch('css');



		echo $this->Html->script('bootstrap/jquery.js');
		
		echo $this->fetch('js');

	?>
		<script type="text/javascript" src="<?php echo Router::url('/',true)?>css/jquery-ui/ui/jquery-ui.js"></script>
</head>
<body>
	<div class="container-fluid">


					<div class="row">

						<div id="admin-header" class="admin-header"> 

								<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
								  <!-- Brand and toggle get grouped for better mobile display -->
								  <div class="navbar-header">
								    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								      <span class="sr-only">Toggle navigation</span>
								      <span class="icon-bar"></span>
								      <span class="icon-bar"></span>
								      <span class="icon-bar"></span>
								    </button>
								    <a class="navbar-brand" href="<?php echo Router::url('/',true).'users';?>">
								    	 <span class="glyphicon glyphicon-home"></span> 
								    	Home
								    </a>
								  </div>

								  <!-- Collect the nav links, forms, and other content for toggling -->
								  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

								    <ul class="nav navbar-nav">

								      <li class="dropdown">
									  	    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customers / Transactions <b class="caret"></b></a>
									        <ul class="dropdown-menu">
									          <li><a href="<?php echo Router::url('/',true);?>customers">Customers</a></li>
									          <li><a href="#">Send Customer Account</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>orders">Orders</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>carts">Non CheckOut List</a></li>
									          <li><a href="#">Newsletter List</a></li>
									        </ul>										  	    
								      </li>


								      <li class="dropdown">
									    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
									        <ul class="dropdown-menu">
									          <li><a href="#">Revenue Reports</a></li>
									          <li><a href="#">Customer Orders</a></li>
									          <li><a href="#">Product Purchase</a></li>
									          <li><a href="#">Total Order Amount</a></li>
									          <li><a href="#">Marketing</a></li>
									          <li><a href="#">Shoppingcart Reminder</a></li>
									          <li role="presentation" class="dropdown-header">RMA</li>
									          <li><a href="<?php echo Router::url('/',true);?>rma/add">RMA Add</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>rma/search">RMA Search</a></li>
									        </ul>									    

								      </li>
								      <li class="dropdown">
								      		
									        <a href="#" class="dropdown-toggle" data-toggle="dropdown">General Settings <b class="caret"></b></a>
									        <ul class="dropdown-menu">
									          <li><a href="<?php echo Router::url('/',true);?>salesreps">Salesrep Management</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>productpackages">Product Packages </a></li>
									          <li><a href="<?php echo Router::url('/',true);?>coupons">Coupons</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>news">News</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>events">Events</a></li>
									          <li><a href="#">Discount Chart</a></li>
									          <li><a href="#">Total Order Discount</a></li>
									          <li><a href="#">Vault Product Delete</a></li>
									          <li><a href="#">UPS Shipping</a></li>
									          <li><a href="#">WC Files</a></li>
									          <li><a href="#">Collection Products</a></li>
									          <li><a href="#">Online Merchandiser</a></li>
									          <li><a href="<?php echo Router::url('/',true);?>fixedshippingratecountries">Fixed Shipping Rates </a></li>
									        </ul>								      		

								      </li>


								      <li class="dropdown">
								      		
									        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Imports / Uploads<b class="caret"></b></a>
									        <ul class="dropdown-menu">
									          <li><a href="<?php echo Router::url('/',true)."uploads/products";?>">Product Uploads</a></li>
									          <li><a href="<?php echo Router::url('/',true)."uploads/product_other_images";?>">Product Other Images Uploads</a></li>
									          <li><a href="<?php echo Router::url('/',true)."uploads/product_dimensions";?>">Product Dimensions Uploads</a></li>
									          <li><a href="<?php echo Router::url('/',true)."uploads/product_quantities";?>">Product Quantities Uploads</a></li>
									          <!-- <li><a href="<?php /*echo Router::url('/',true)."uploads/barcode"*/;?>">Barcode / Bin No</a></li> -->
									        </ul>								      		

								      </li>			

									  <li class="dropdown">
								      		
									        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Exports / Downloads <b class="caret"></b></a>
									        <ul class="dropdown-menu">
									          <li><a href="<?php echo Router::url("/",true);?>exports/customer">Customer Exports</a></li>
									          <li><a href="<?php echo Router::url("/",true);?>exports/product">Product Exports</a></li>
									          <li><a href="<?php echo Router::url("/",true);?>exports/productotherimages">Product Other Images Exports</a></li>
									          <li><a href="<?php echo Router::url("/",true);?>exports/productdimensions">Product Dimensions Exports</a></li>
									          <li><a href="<?php echo Router::url("/",true);?>exports/productquantities">Product Quantities Exports</a></li>
									        </ul>								      		

								      </li>	
								      <li class="dropdown">

									        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Others<b class="caret"></b></a>
									        <ul class="dropdown-menu">
									            <li role="presentation" class="dropdown-header">TESTIMONIALS</li>
									            <li><a href="#">Pending Links</a></li>
									            <li><a href="#">Posted Links</a></li>
									           	<li role="presentation" class="dropdown-header">PRODUCT TEMPLATES</li>
									            <li><a href="#">Manage Product Template</a></li>
											   	<li role="presentation" class="dropdown-header">MASTER TABLES </li>
									          	<li><a href="<?php echo Router::url('/',true);?>categories">Categories</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>category_groups">Category Groups</a></li>
									          	<!-- <li><a href="<?php echo Router::url('/',true);?>sub_categories">Sub Categories</a></li> -->
									          	<li><a href="<?php echo Router::url('/',true);?>subcategories">Subcategories</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>brands">Brands</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>products">Products</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>productdimensions">Product Dimensions</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>colors">Colors</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>materials">Materials</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>promotional_products">Promotional Products</a></li>
									          	<li><a href="<?php echo Router::url('/',true);?>productsearches">Searches</a></li>	
									          	<!-- <li><a href="<?php //echo Router::url('/',true);?>bodyparts">Body Parts</a></li> -->
									        </ul>									      
								      	
								      </li>

								    </ul>

								    <a href="<?php echo Router::url('/',true);?>/users/logout" title="Admin Logout">
								    <button type="button" class="btn btn-danger navbar-btn navbar-right">Sign out</button>
								    </a>


								  </div>
								</nav>

						</div>

					</div>

					<div class="clearfix"></div>

					<div class="row" id="admin-content-wrapper">


							<div class="col-lg-12 col-md-12 col-sm-12">
									
									<div id="admin-content" class="admin-content">
										
										<?php echo $this->Session->flash(); ?>

										<div class="row">
											<div class="col-md-12">
												

												<div class="row page-header">

													<div class="col-md-8">
														<h2> <?php echo $page_title;?></h2>

													</div>
												
													<div class="col-md-4">
														<h2>

															<!-- search box -->
															<?php 
																if($show_search_box==true){
																
																	$form_options = array();
																	$form_options['type'] = "get";
																	$form_options['action'] = $this->action;
																	echo $this->Form->create($this->name,$form_options); 

																	$search_string = ( array_key_exists('search',$this->request->query)) ? $this->request->query['search'] : "Search Here ..."; 
															?>

															<div class="input-group">
																 <input type="text" class="form-control" name="search" placeholder="Search Here..." value="<?php echo $search_string?>">
																 <span class="input-group-btn">
																   <button class="btn btn-primary" type="submit">Search Here</button>
																 </span>
															</div>															
																 

															<?php echo $this->form->end(); ?>
															<?php } ?>
															<!-- show search box -->
															
														</h2>
													</div>
												</div>	
													
																						
											</div>


										</div>
										
										<?php echo $this->fetch('content'); ?>

									</div>

							</div>
						

					</div>


	</div>

</body>

<?php 

		echo $this->Html->script('bootstrap/jquery.js');
		echo $this->Html->script('bootstrap/bootstrap.min.js');
		//echo $this->Html->script('highcharts/highcharts.js');

		echo $this->fetch('script');
?>
</html>
