<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class ExportsController extends AppController {

	public $show_search_box = false;

	public $layout = false;

/*	pricate $item_per_file = 1500;*/
	private $item_per_file = 2000;

	private $categoryDescriptionSeparator = "*****";

	public function beforeFilter(){

		parent::beforeFilter();
		$this->set('show_search_box',$this->show_search_box);


		/* loading components on the fly */
		//$this->DataFormatter = $this->Components->load('DataFormatter');

		//$this->categoryDescriptionSeparator = "*****";
	

	}


	public function customer(){


		$this->set('page_title',$this->name." | ".$this->action);


		/* form submitted */
		if($this->request->data && $this->request->is('post')){

				$start_date = $this->request->data['Exports']['start_date'];
				$end_date = $this->request->data['Exports']['end_date'];

				$this->loadModel('Customer');
				$options = array();
				$options['conditions']['Customer.added BETWEEN ? and ? '] = array($start_date,$end_date);

				/* first row */
				$firstRow = 'CUSTOMER EXPORT - '.date("M d, Y",strtotime($start_date))." - ".date("M d, Y",strtotime($end_date));
				$this->set('firstRow',$firstRow);
				
				$datas = $this->Customer->find('all',$options);
				$this->set('datas',$datas);

				$filename = "customer-list-".date("mdY",strtotime($start_date))."-".date("mdY",strtotime($end_date)).".xls";
				$this->set('filename',$filename);

				$this->render('customer_export');


		}		

	}	

	private function _buildExportTemporaryTables(){

		$this->loadModel('Product');


		$this->Product->query("drop table if exists `temp_exp_product_category` ");
		/*$this->Product->query("create table if not exists `temp_exp_product_category`(
			                  		`product_id` int unsigned not null primary key auto_increment,
			                  		`categories` varchar(200) not null
			                  	)
			               ");
		$this->Product->query("insert into temp_exp_product_category (SELECT t1.product_id, group_concat(t2.name) 
												   					  FROM categories_products t1 INNER JOIN categories t2 on (t1.category_id = t2.id) 
												   					  GROUP BY t1.product_id) ");*/
		
		/* Temp Category / Product Combination - based on NEW excel list (July 8, 2014) */
		$this->Product->query("create table if not exists `temp_exp_product_category`(
			                  		`product_id` int unsigned not null primary key auto_increment,
			                  		`categories` varchar(200) not null,
			                  		`categories_desc` TEXT not null
			                  	)
			               ");
		$this->Product->query("insert into temp_exp_product_category (SELECT t1.product_id, group_concat(t2.name), group_concat(t2.description SEPARATOR '".$this->categoryDescriptionSeparator."') 
												   					  FROM categories_products t1 INNER JOIN categories t2 on (t1.category_id = t2.id) 
												   					  GROUP BY t1.product_id) ");



		/* Temp Sub Category / Product Combination */
		$this->Product->query("drop table if exists `temp_exp_product_subcategory` ");
		$this->Product->query("create table `temp_exp_product_subcategory`(
			                  		`product_id` int unsigned not null primary key auto_increment,
			                  		`subcategories` varchar(200) not null
			                  	) 
			                  ");		

		$this->Product->query("insert into temp_exp_product_subcategory (SELECT t1.product_id, group_concat(t2.name) 
																	     FROM subcategories_products t1 INNER JOIN subcategories t2 on (t1.subcategory_id = t2.id) 
																	     GROUP BY t1.product_id) ");		


		/* Temp Material / Product Combination */
		$this->Product->query("drop table if exists `temp_exp_product_material` ");
		$this->Product->query("create table if not exists `temp_exp_product_material`(
			                  		`product_id` int unsigned not null primary key auto_increment,
			                  		`materials` varchar(300) not null
			                  	) 
			               ");	

		$this->Product->query("insert into temp_exp_product_material (SELECT t1.product_id, group_concat(t2.name) 
																	  FROM materials_products t1 INNER JOIN materials t2 on (t1.material_id = t2.id) 
																	  GROUP BY t1.product_id) ");

		/* Sep 12, 2014 - Added this for Bodyparts */
		/* Temp Bodypart / Product Combination */
		$this->Product->query("drop table if exists `temp_exp_product_bodypart` ");
		$this->Product->query("create table if not exists `temp_exp_product_bodypart`(
			                  		`product_id` int unsigned not null primary key auto_increment,
			                  		`bodyparts` varchar(300) not null
			                  	) 
			               ");	

		$this->Product->query("insert into temp_exp_product_bodypart (SELECT b1.product_id, group_concat(b2.name) 
																	  FROM bodyparts_products b1 INNER JOIN bodyparts b2 on (b1.bodypart_id = b2.id) 
																	  GROUP BY b1.product_id) ");	


	}

	private function _dropExportTemporaryTables(){

		$this->loadModel('Product');

		$this->Product->query("drop table if exists `temp_exp_product_category` ");
		$this->Product->query("drop table if exists `temp_exp_product_subcategory` ");
		$this->Product->query("drop table if exists `temp_exp_product_material` ");
		$this->Product->query("drop table if exists `temp_exp_product_bodypart` ");	/* Sep 12, 2014 - for Bodypart */
		

		/*
		$this->Product->query("truncate table `temp_exp_product_category` ");
		$this->Product->query("truncate table `temp_exp_product_subcategory` ");
		$this->Product->query("truncate table `temp_exp_product_material` ");
		*/

	}

	public function product(){

		$this->loadModel('Product');
		$this->set('page_title','Product Export');

		$options = array();

		$totalProduct = $this->Product->find('count',$options);

		$list_options = intval($totalProduct / $this->item_per_file);



		if( ($totalProduct % $this->item_per_file) > 0 ) $list_options = $list_options + 1;

		$this->set('list_options',$list_options);
		$this->set('item_per_file',$this->item_per_file);

	 
		if($this->request->data && $this->request->is('post')){

			/* */
			/*ini_set('memory_limit', '512');*/
			ini_set('memory_limit', '-1');	/* As of October 14, 2014 - This enables to continue exporting without exhausting the memory limit. */
			//ini_set('max_execution_time',240);
			ini_set('max_execution_time',240);
			
			$lowestIndex = intval($this->request->data['Exports']['list']) * $this->item_per_file;

			/* orphan variable */
			$highestIndex = $lowestIndex+$this->item_per_file;

			/* first row */
			$firstRow = "PRODUCT EXPORT - ".$lowestIndex." to ".($lowestIndex+$this->item_per_file);
			$this->set('firstRow',$firstRow);

			/* filename */
			$filename = "export-product-".$lowestIndex."--".($lowestIndex+$this->item_per_file).".xls";
			$this->set('filename',$filename);


			/* temp product and category */
			$this->_buildExportTemporaryTables();

			/*
			*	The NEW product excel format: July, 04, 2014
			*/
				/*	Excel Field 				Database Field
				*	
				*
				*	NO 							products.id
				* 	DATABASE NAME 				products.db_name
				*	DATE ADDED 					products.added
				*	IMAGE NAME 					products.image_name
				*	PROD NO 					products.number
				*	CATALOG NAME 				catalogs.name
				*	CATALOG PAGE 				catalogs_products.pagenumber
				*	DESCRIPTION 				products.description
				*	EMAILERLINK					products.emailerlink
				*	BRAND 						products.brand_id
				*	CATEGORY 					categories.name
				*	CATEGORY DESC 				categories.description
				*	MATERIAL 					materials.name
				*	SUBCAT 						products.subcat
				*	BODYPARTS					bodyparts.name
				*	SPOTLIGHT LINK 				products.spotlight_link
				* 	FEATURE						products.feature
				*	PRICE 						products.price
				*	S-PRICE 					products.s_price
				*	WEIGHT						products.weight
				*	DISCOUNT VALUE 				products.discount_value
				*	PROMOCODE 					products.promocode
				*	DISCOUNT CHART 				products.discount_chart
				*	PACKAGE DEAL 				products.package_deal
				* 	VIEW BY PIECE 				products.view_piece
				* 	VIEW BY PACK 				products.view_pack
				*	NEWSTYLES 					products.new_styles
				* 	STATUS 						products.status
				*	PACKAGING					products.packaging
				* 	REGULAR PRICE 				products.reg_price
				*/
			/*
			*	end of NEW product excel format
			*/

			$options =  array();

			/* NEW */
			/*,'Product.subcat','Product.bodyparts'*/
			/* this is commented out since bodyparts field is now removed from products table ,'Product.bodyparts'*/
			$options['fields'] = array(
				
				'Product.id','Product.db_name','Product.added',
				'Product.image_name','Product.number',
				'Product.description','Product.emailerlink',
				'Product.brand_id','Product.spotlight_link','Product.feature','Product.price','Product.s_price',
				'Product.discount_value','Product.promocode','Product.discount_chart','Product.package_deal','Product.view_piece','Product.view_pack','Product.new_styles',
				'Product.status','Product.packaging','Product.reg_price', 'Product.weight', 

				'CategoryProduct.categories',
				'CategoryProduct.categories_desc',
				'Catalog.name',

				'Brand.name',
				'CatalogProduct.pagenumber',
				'SubcategoryProduct.subcategories',
				'MaterialProduct.materials',
				'BodypartProduct.bodyparts' /* added sep 12, 2014 */

			);

			$options['limit'] = $this->item_per_file;		
			$options['offset'] = $lowestIndex;
			

			$options['conditions'] = array('Product.id >' => 0);
			$options['order'] = "Product.added DESC";
			$options['joins'] = array(

									array(
										'table'=>'brands',
										'alias'=>'Brand',
										'type'=>'INNER',
										'conditions'=> array('Brand.id = Product.brand_id')
									),

									array(
										'table'=>'temp_exp_product_category',	
										'alias'=>'CategoryProduct',
										'type'=>'INNER',
										'conditions'=> array('CategoryProduct.product_id = Product.id')
									),		
									
									array(
										'table'=>'temp_exp_product_subcategory',
										'alias'=>'SubcategoryProduct',
										'type'=>'LEFT',
										'conditions'=>array('SubcategoryProduct.product_id = Product.id')

									),
									
									array(
										'table'=>'temp_exp_product_material',
										'alias'=>'MaterialProduct',
										'type'=>'LEFT',
										'conditions'=>array('MaterialProduct.product_id = Product.id')
									),

									/*bodyparts sep 12, 2014*/
									array(
										'table'=>'temp_exp_product_bodypart',
										'alias'=>'BodypartProduct',
										'type'=>'LEFT',
										'conditions'=>array('BodypartProduct.product_id = Product.id')
									),
									/* end */
									
									array(
									       'table'=>'catalogs_products',
									       'alias'=>'CatalogProduct',
									       'type'=>'LEFT',
									       /*'conditions'=>array('CatalogProduct.product_id=Product.id')*/
									       'conditions'=>array('CatalogProduct.number=Product.number')
									),
									
									array(
											'table'=>'catalogs',
											'alias'=>'Catalog',
											'type'=>'LEFT',
											'conditions'=>array('Catalog.id=CatalogProduct.catalog_id')
									),

									array(
										 'table'=>'productdimensions',
										 'alias'=>'Dimension',
										 'type'=>'LEFT',
										 'conditions'=> array('Dimension.product_id = Product.id')
									),

									/*
									* This is removed since a new condition above has been added - 
									* to be deleted when this is finalized 
									* temporarily commendted out - Sep 12, 2014
									*/
									/*array(
										'table'=>'bodyparts_products',
										'alias'=>'BodypartProduct',
										'type'=>'LEFT',
										'conditions'=> array('BodypartProduct.product_id = Product.id')
									),
									
									array(
										'table'=>'bodyparts',
										'alias'=>'Bodypart',
										'type'=>'LEFT',
										'conditions'=> array('Bodypart.id = BodypartProduct.bodypart_id')
									)*/

								);

			$datas = $this->Product->find('all',$options);

			/*pr( $datas );
			exit();*/

		
			/* clean reference tables */
			$this->_dropExportTemporaryTables();



			$this->set('datas',$datas);



			$this->render('product_export');


		}	



	}


	/*
	*	for product dimensions export
	*/
	public function productdimensions(){

		/* Customized item_per_file */
		$this->item_per_file = 5000;


		$this->loadModel('Productdimension');
		$this->set('page_title','Product Dimension Export');

		$options = array();
		$options['joins'] = array(

				array( 	'table' => 'products', 
	            		'alias' => 'Product', 
	            		'type' =>'inner', 
	            		'conditions' => array('Product.id = Productdimension.product_id') 
	            )
		);
		$options['group'] = 'Productdimension.product_id';

		$totalProductDimensions = $this->Productdimension->find('count',$options);


		$list_options = intval($totalProductDimensions / $this->item_per_file);

		if( ($totalProductDimensions % $this->item_per_file) > 0 ) $list_options = $list_options + 1;


		$this->set('list_options',$list_options);
		$this->set('item_per_file',$this->item_per_file);


	 
		if($this->request->data && $this->request->is('post')){

			ini_set('memory_limit', '-1');	/* As of October 14, 2014 - This enables to continue exporting without exhausting the memory limit. */

			$lowestIndex = intval($this->request->data['Exports']['list']) * $this->item_per_file;
			$highestIndex = $lowestIndex+$this->item_per_file;

			/*first row*/
			$firstRow = "PRODUCT DIMENSION EXPORT - ".$lowestIndex." to ".($lowestIndex+$this->item_per_file);
			$this->set('firstRow',$firstRow);

			/*filename*/
			$filename = "export-product-dimension".$lowestIndex."--".($lowestIndex+$this->item_per_file).".xls";
			$this->set('filename',$filename);

			/*
			*	The NEW product dimension excel format: July, 08, 2014
			*/
				/*	Excel Field 				Database Field
				*	
				*
				*	PRODNO 					products.id
				* 	IDENTIFICATION			Productdimension.identification
				*	COLOR 					Productdimension.color
				*	GAUGEINCH 				Productdimension.gaugeinch
				*	LENGTHINCH 				Productdimension.lengthinch
				*	WIDTHINCH 				Productdimension.widthinch
				*	GAUGEMM 				Productdimension.gaugemm
				*	LENGTHMM 				Productdimension.lengthmm
				*	WIDTHMM					Productdimension.widthmm
				*	BALL/GEM SIZE 			Productdimension.ball_gem_size
				*	LENGTH 					Productdimension.length
				*	WIDTH 					Productdimension.width
				*	HEIGHT 					Productdimension.height
				*	WEIGHT 					Productdimension.weight
				*/
			/*
			*	end of NEW product dimension excel format
			*/


			$options =  array();

			$options['fields'] = array('Productdimension.*', 'Product.identification','Product.number','Color.name');

			/*$options['limit'] = $this->item_per_file;*/	
			$options['limit'] = $highestIndex;			// this limit is set dynamically based on the dropdon list
			$options['conditions'] = array('Productdimension.id >' => 0);
			$options['group'] = array('Productdimension.id');
			$options['joins'] = array(
									array(
										 'table'=>'products',
										 'alias'=>'Product',
										 'type'=>'INNER',
										 'conditions'=> array('Product.id = Productdimension.product_id')
									),

									array(
										 'table'=>'colors',
										 'alias'=>'Color',
										 'type'=>'LEFT',
										 'conditions'=> array('Product.color_id = Color.id')
									),

								);
 

			$datas = $this->Productdimension->find('all',$options);


			$this->set('datas',$datas);

			/* added to solve "PHP: Fatal Error: Allowed Memory Size of 134217728 Bytes Exhausted" */
/*			ini_set('memory_limit', '512M');
			set_time_limit(0);
			ini_set('max_execution_time','9999');*/

			$this->render('product_dimensions_export');

		}


	}


	/*
	*	for product other images export
	*/
	public function productotherimages(){

		/* Customized item per file  */
		$this->item_per_file = 5000;


		$this->loadModel('Productotherimage');
		$this->set('page_title','Product Other Images Export');

		$options = array();

		$totalProductImages = $this->Productotherimage->find('count',$options);

		$list_options = intval($totalProductImages / $this->item_per_file);


		if( ($totalProductImages % $this->item_per_file) > 0 ) $list_options = $list_options + 1;

		$this->set('list_options',$list_options);
		$this->set('item_per_file',$this->item_per_file);

	 
		if($this->request->data && $this->request->is('post')){

			ini_set('memory_limit', '-1');	/* As of October 14, 2014 - This enables to continue exporting without exhausting the memory limit. */


			$lowestIndex = intval($this->request->data['Exports']['list']) * $this->item_per_file;
			$highestIndex = $lowestIndex+$this->item_per_file;

			/*first row*/
			$firstRow = "PRODUCT OTHER IMAGES EXPORT - ".$lowestIndex." to ".($lowestIndex+$this->item_per_file);
			$this->set('firstRow',$firstRow);

			/*filename */
			$filename = "export-product-other-images".$lowestIndex."--".($lowestIndex+$this->item_per_file).".xls";
			$this->set('filename',$filename);


			/*
			*	The NEW product other images excel format: July, 08, 2014
			*/
				/*	Excel Field 					Database Field
				*	
				*
				*	PRODNO 							products.id
				* 	PRODUCT IMAGE					products.db_name
				*	OTHER IMAGE 1 					products.added
				*	OTHER IMAGE 2 					products.image_name
				*	OTHER IMAGE 3 					products.number
				*	OTHER IMAGE 4 					catalogs.name
				*/
			/*
			*	end of NEW other images excel format
			*/


			$options =  array();

			$options['fields'] = array('Productotherimage.*', 'Product.number', 'Product.image_name');

			/*$options['limit'] = $this->item_per_file;	*/
			$options['limit'] = $highestIndex;		// this limit is set dynamically based on the dropdon list
			$options['conditions'] = array('Productotherimage.id >' => 0);
			$options['group'] = array('Productotherimage.id');
			$options['joins'] = array(
									array(
										 'table'=>'products',
										 'alias'=>'Product',
										 'type'=>'INNER',
										 'conditions'=> array('Product.id = Productotherimage.product_id')
									)

								);
 

			$datas = $this->Productotherimage->find('all',$options);

			$this->set('datas',$datas);

			$this->render('product_other_images_export');

		}
	}
	/*
	*
	*/


	/*
	*	for product quantities export
	*/
	public function productquantities(){

		/* customized item per file */
		$this->item_per_file = 5000;

		$this->set('page_title','Product Quantities Export');



		/* product Count */
		$this->loadModel('Product');
		$productCount = $this->Product->find('count');

		$list_options = intval($productCount / $this->item_per_file);


		if( ($productCount % $this->item_per_file) > 0 ) {

				$list_options = $list_options + 1;

		}	


		$this->set('list_options',$list_options);
		$this->set('item_per_file',$this->item_per_file);

	 
		if($this->request->data && $this->request->is('post')){

			ini_set('memory_limit', '-1');	/* As of October 14, 2014 - This enables to continue exporting without exhausting the memory limit. */


			/* Calculating product limit and range */
			$lowestIndex = intval($this->request->data['Exports']['list']) * $this->item_per_file;
			$highestIndex = $lowestIndex+$this->item_per_file;


			/* First row */
			$firstRow = "PRODUCT QUANTITY EXPORT - ".$lowestIndex." to ".($lowestIndex+$this->item_per_file);
			$this->set('firstRow',$firstRow);

			/* Filename */
			$filename = "export-product-quantity".$lowestIndex."--".($lowestIndex+$this->item_per_file).".xls";
			$this->set('filename',$filename);



			/*
			*	The NEW product quantity excel format: July, 04, 2014
			*/
				/*	Excel Field 					Database Field
				*	
				*
				*/
			/*
			*	end of NEW product quantity excel format
			*/


			$options =  array();

			/* $options['limit'] = $this->item_per_file; */	
			$options['limit'] = $highestIndex;		/* this limit is set dynamically based on the dropdon list */
			$options['limit'] = 10;
			$options['fields'] = array('Product.number,Product.avail_qty','Upcbin.*');
 			$options['conditions'] = array('Product.id >' => 0);
			$options['joins'] = array(
									array(
										 'table'=>'upcbins',
										 'alias'=>'Upcbin',
										 'type'=>'INNER',
										 'conditions'=> array('Product.number = Upcbin.product_number')
									)
								);
 
			$this->Product->recursive = -1;
			$datas = $this->Product->find('all',$options);

			/* sending data to view */
			$this->set('datas',$datas);


			/* render view */
			$this->render('product_quantities_export');


		}

		
	}


}
