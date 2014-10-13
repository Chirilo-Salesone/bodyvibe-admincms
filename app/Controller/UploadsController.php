<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */

class UploadsController extends AppController {

	/* public $components = array('ExcelReader'); */

	private $masterTableList = array();
	private $masterTableDeleteList = array();
	public $show_search_box = false;


	static private $filter_pattern = "/[^a-zA-Z0-9_.-]/s";


	public function beforeFilter(){


		parent::beforeFilter();

		
		/* form data */
		if(!empty($this->request->data)) {	

			$this->loadModel('Product');
			$this->loadModel('Productdimension');
			$this->loadModel('Productotherimage');

			$this->loadModel('Products_image');

			$this->loadModel('Bodypart');
			$this->loadModel('Bodyparts_product');

			$this->loadModel('Upc_code');

			$this->brandList();
			$this->bodyPartList();
			$this->categoryList();
			$this->subCategoryList();
			$this->materialList();
			
			$this->catalogList();
			$this->colorList();


		}	
			/* Removing the search box */
			$this->set('show_search_box',false);



			$this->DataFormatter = $this->Components->load('DataFormatter');




	}



	private function materialList(){

		$this->loadModel('Material');
		$options = array();
		$options['fields'] = array('valueurl','id');
		$this->masterTableList['material'] = $this->Material->find('list',$options);		

	}	

	private function catalogList(){

		$this->loadModel('Catalog');
		$options = array();
		$options['fields'] = array('name','id');
		$this->masterTableList['catalog'] = $this->Catalog->find('list',$options);		

	}		


	private function categoryList(){

		$this->loadModel('Category');
		$options = array();
		$options['fields'] = array('categoryurl','id');
		$this->masterTableList['category'] = $this->Category->find('list',$options);		

	}

	private function bodyPartList(){

		$this->loadModel('Bodypart');
		$options = array();
		$options['fields'] = array('valueurl','id');
		$this->masterTableList['bodypart'] = $this->Bodypart->find('list',$options);		


	}

	private function subCategoryList(){

		$this->loadModel('Subcategory');
		$options = array();
		$options['fields'] = array('valueurl','id');
		$this->masterTableList['subcategory'] = $this->Subcategory->find('list',$options);		


	}	

	private function brandList(){

		/* brands */
		$this->loadModel('Brand');
		$options = array();
		$options['fields'] = array('name','id');
		$this->masterTableList['brand'] = $this->Brand->find('list',$options);	

	}


	private function colorList(){

		/* brands */
		$this->loadModel('Color');
		$options = array();
		$options['fields'] = array('code','id');
		$this->masterTableList['color'] = $this->Color->find('list',$options);	

	}	



	/*

		this function return the Brand id 

	*/

	function addBrand($brand=''){

		$brand_id = 0;
			if(array_key_exists($brand,$this->masterTableList['brand'])) {

				return $this->masterTableList['brand'][$brand];
			}

			else{

				$saves= array('Brand'=>array('name'=>$brand,'display_type'=>'site','seq_no'=>'1'));
				$this->Brand->create();
				$this->Brand->save($saves);
				$this->brandList();

				return $this->Brand->id;									   

			}	

	}

	

	
	/* Adding Color */

	function addColor($color=''){

		$color = trim($color);
		$code = preg_replace(self::$filter_pattern,'-',strtolower($color));

		if(!empty($color)){



			if(array_key_exists($color,$this->masterTableList['color'])) {

				return $this->masterTableList['color'][$color];

			}

			else{
			
				$saves = array();
				$saves['Color']['name']  = $color;
				$saves['Color']['code']  = $code;
				$saves['Color']['added'] = date("Y-m-d H:i:s");

				$query = "
							INSERT INTO colors(name,code,added) VALUES('".$saves['Color']['name']."','".$saves['Color']['code']."',now()) 
							ON DUPLICATE KEY UPDATE id = id, name='".$saves['Color']['name']."', added='".$saves['Color']['added']."'
				         ";

				$this->Color->query($query);
				$this->colorList();


				/* get match color id */
				$options = array();
				$options['condition']['code'] = $code;
				$color = $this->Color->find('first',array($options));

				return $color['Color']['id'];


			}	

		}	

		return null;

	}	


	
	function addMaterialProduct($options=array()){

			$materialProductArr = array();
			$product_id = $options['product_id'];
			
			if($options['materials']!="") {

				$materials = explode(",",$options['materials']);

 				$tobeDeletedMaterialProductArr = array();

				foreach($materials as $material){

					$material = trim($material);
					$materialurl = preg_replace(self::$filter_pattern,'-',strtolower($material));

						if(array_key_exists($materialurl,$this->masterTableList['material'])) {

							$materialProductArr[] =  "({$this->Product->id},{$this->masterTableList['material'][$materialurl]},now(),now())";

						}

						else{

							$materialSave = array();
							$materialSave['name'] = $material;
							$materialSave['added'] = date("Y-m-d H:i:s");
							$materialSave['valueurl'] = $materialurl;
							$materialSave['status'] = 'active';

							$this->Material->create();
							$this->Material->Save(array('Material'=>$materialSave));
							unset($materialSave);

							/* updating  materialList property */
							$this->materialList();
							$materialProductArr[] =  "({$product_id},{$this->masterTableList['material'][$materialurl]},now(),now())";

						}	

						$tobeDeletedMaterialProductArr[] = $this->masterTableList['material'][$materialurl];

						
				} /* foreach end */


				/* Deleting orphan data */
				if(count($tobeDeletedMaterialProductArr) > 0 ){

					$query = "delete from materials_products where product_id=".$product_id. " and material_id not in (".implode(",",$tobeDeletedMaterialProductArr).")";	
					$this->Material->query($query);

				}	

			}
			
			return implode(",",$materialProductArr);

	}

	/*
	* For Catalog Name and Catalog Page for products - Sep 12, 2014
	*/
	function addCatalogProduct($options=array()){

			/*echo '<pre>';
				print_r($options);
				print_r($this->masterTableList['catalog']);
			echo '</pre>';
			exit();*/


			$catalogProductArr = array();

			/*if($options['catalog_name']!="") {*/
			if(count($options) > 0 && $options['catalog_name']!="" &&  $options['catalog_pagenumber']!="" ){

				$tobeDeletedCatalogProductArr = array();

				$product_id 			= $options['product_id'];
				$catalog_name 			= $options['catalog_name'];
				$catalog_pagenumber 	= $options['catalog_pagenumber'];
				$catalog_productnumber 	= '"'.str_replace(array("'", '"'), array("\\'", '\\"'),	$options['number']).'"'; /* September 20, 2014 - filters out characters like ', " and / */

 				/*$tobeDeletedMaterialProductArr = array();*/

 				/**/
				if(array_key_exists($catalog_name,$this->masterTableList['catalog'])) {

					/*return $this->masterTableList['catalog'][$catalog_name];*/
					$catalogProductArr[] =  "({$product_id},{$this->masterTableList["catalog"][$catalog_name]},{$catalog_pagenumber},{$catalog_productnumber})";

				}

				else{

					$catalogSave = array();
					$catalogSave['name'] = $catalog_name;
					$catalogSave['description'] = "";
					$catalogSave['imgsrc'] = "";
					$catalogSave['filesrc'] = "";
					$catalogSave['status'] = 'active';
					$catalogSave['sequence_no'] = 'active';
					$catalogSave['view_type'] = 'download';
					$catalogSave['url'] = $catalog_name. '-' .$catalog_pagenumber;
					$catalogSave['added'] = date("Y-m-d H:i:s");

					$this->Catalog->create();
					$this->Catalog->Save(array('Catalog'=>$catalogSave));
					unset($catalogSave);

				}

				$tobeDeletedCatalogProductArr[] = $this->masterTableList['catalog'][$catalog_name];
			}

			/*echo '<pre>';
				print_r($tobeDeletedCatalogProductArr);
			echo '</pre>';
			exit();
*/
			/* Deleting orphan data */
			if(count($tobeDeletedCatalogProductArr) > 0 ){

				$query = "delete from catalogs_products where product_id=".$product_id. " and catalog_id not in (".implode(",",$tobeDeletedCatalogProductArr).")";	
				$this->Catalog->query($query);

			}	

			return implode(",",$catalogProductArr);

	}
	/*
	* end for Catalog Name and Catalog Page - Sep 12, 2014
	*/

	
	function addSubCategoryProduct($params=array()){

			$product_id      = $params['product_id'];
			$subCategories   = explode(",",$params['subcategories']);
			
					
			$subCategoryProductArr = array();
			$tobeDeletedSubCategoryProductArr = array();

			foreach($subCategories as $subcategory){

				   $subcategory = trim($subcategory);
				   $subcategoryurl = preg_replace(self::$filter_pattern,'-',strtolower($subcategory));


					if(array_key_exists($subcategoryurl,$this->masterTableList['subcategory'])) {

						$subCategoryProductArr[] =  "({$product_id},{$this->masterTableList['subcategory'][$subcategoryurl]},now(),now())";

					}

					else{

						$subCategorySave = array();
						$subCategorySave['name'] = $subcategory;
						$subCategorySave['valueurl'] = $subcategoryurl;
						$subCategorySave['added'] = date("Y-m-d H:i:s");

							/* Create Subcategory */
							$this->Subcategory->create();								
							$this->Subcategory->Save(array('Subcategory'=>$subCategorySave));
							$this->subCategoryList();

							unset($subCategorySave);
							$subCategoryProductArr[] =  "({$product_id},{$this->masterTableList['subcategory'][$subcategoryurl]},now(),now())";

					}

					$tobeDeletedSubCategoryProductArr[] = $this->masterTableList['subcategory'][$subcategoryurl];

			}

			/* Deleting orphan data  */
			if(count($tobeDeletedSubCategoryProductArr) > 0 ){

				$query = "delete from subcategories_products where product_id=".$product_id. " and subcategory_id not in (".implode(",",$tobeDeletedSubCategoryProductArr).")";
				$this->Subcategory->query($query);

			}


			return implode(",",$subCategoryProductArr);


	}

	function addCategoryProduct($params=array()){

			$product_id      = $params['product_id'];
			$names           = $params['categories'];    // array
			$descriptions    = $params['category_desc']; // array


			$categoryProductArr = array();
			$excludeFromRemovalArr = array();


			/* Setting $categories */
			if( count($names) > 0){

				foreach($names as $key => $name){


					$description = (array_key_exists($key, $descriptions) ? $descriptions[$key] : "");

					$categoryurl = preg_replace(self::$filter_pattern,'-',strtolower(trim($name)));


					if(array_key_exists($categoryurl,$this->masterTableList['category'])) {

						$categoryProductArr[] =  "({$product_id},{$this->masterTableList['category'][$categoryurl]},now(),now())";


						$this->Category->id = $this->masterTableList['category'][$categoryurl];
						$this->Category->save(array('description'=>$description));


					}

					else{

						/* New category */
						$newCategory = array();
						$newCategory['name'] = $name;
						$newCategory['description'] = $description;
						$newCategory['categoryurl'] = $categoryurl;
						
						$this->Category->create();
						$this->Category->Save(array('Category'=>$newCategory));
						$this->categoryList();

						unset($newCategory);
						$categoryProductArr[] =  "({$product_id},{$this->masterTableList['category'][$categoryurl]},now(),now())";

					}	

					$excludeFromRemovalArr[] = $this->masterTableList['category'][$categoryurl];


				} // end foreach

				
				if(count($excludeFromRemovalArr) > 0) {

					$query = "DELETE FROM categories_products WHERE product_id=".$product_id. " AND category_id not in (".implode(",",$excludeFromRemovalArr).")";
					$this->Category->query($query);

				}

			}


			return implode(",",$categoryProductArr);	

	}



	function addBodypartProduct($params=array()){

			$product_id      	= $params['product_id'];
			$bodyParts   		= explode(",",$params['bodyparts']);
			
			$bodyPartProductArr = array();


			/* Previous bodyparts of current product */
			$tobeDeletedBodyPartProductArr = array();


			/* if $bodyParts not empty */
			if(count($bodyParts) > 0 ){


				foreach($bodyParts as $bodypart){

					$bodypart = trim($bodypart);
					$bodyparturl = preg_replace(self::$filter_pattern,'-',strtolower($bodypart));

					if(array_key_exists($bodyparturl,$this->masterTableList['bodypart'])) {

						$bodyPartProductArr[] =  "({$product_id},{$this->masterTableList['bodypart'][$bodyparturl]},now(),now())";

					}

					else{

						$bodyPartSave = array();

						$bodyPartSave['name'] = $bodypart;
						$bodyPartSave['valueurl'] = $bodyparturl;

						$bodyPartSave['added'] = date("Y-m-d H:i:s");
						$bodyPartSave['modified'] = date("Y-m-d H:i:s");

						$duplicate = $this->Bodypart->find('first',array('conditions'=>array('valueurl'=>$bodyPartSave['valueurl'])));


						if( $duplicate ){

							/* new bodypartsave arr */
							$bodyPartSave = array();
							$bodyPartSave['name'] = $bodypart;
							$bodyPartSave['valueurl'] = $bodyparturl;
							$bodyPartSave['modified'] = date("Y-m-d H:i:s");

							/* updating record */
							$this->Bodypart->id = $duplicate['Bodypart']['id'];
							$this->Bodypart->Save(array('Bodypart'=>$bodyPartSave));

						}
						else{

							$this->Bodypart->create();								
							$this->Bodypart->Save(array('Bodypart'=>$bodyPartSave));
							$this->bodyPartList();

						} /* end if-else */


						unset($bodyPartSave);

						$bodyPartProductArr[] =  "({$product_id},{$this->masterTableList['bodypart'][$bodyparturl]},now(),now())";

					}

					$tobeDeletedBodyPartProductArr[] = $this->masterTableList['bodypart'][$bodyparturl];


				} /* end foreach */

			}	


			/* Deleting orphan data  */
			if(count($tobeDeletedBodyPartProductArr) > 0 ){

				$query = "delete from bodyparts_products where product_id=".$product_id. " and bodypart_id not in (".implode(",",$tobeDeletedBodyPartProductArr).")";
				$this->Bodypart->query($query);

			}


			return implode(",",$bodyPartProductArr);

	}

	

	private function addProductDimensions($params=array()){

		$options = array();
		$options['conditions']['product_id'] = $params['Productdimension']['product_id'];

 		$foundRecord = $this->Productdimension->find('first',$options); 

		if( count($foundRecord) > 0 ){

				$this->Productdimension->id = $foundRecord['Productdimension']['id'];

		 }  

		 else{

		 		$this->Productdimension->create();
		 }

		 foreach($params['Productdimension'] as $key => $val){

		 		$params['Productdimension'][$key] = addslashes($val);

		 }

		 $this->Productdimension->save($params);

	}

	private function getAutoGeneratedProductUrlID($val = array()){


		$producturlid = "";

			/* substr(strrev(md5($this->request->data['Product']['image_name']. '-' .$this->request->data['Product']['number']. '-' .$this->request->data['Product']['id'])), 0, 10);*/

			$producturlid    	= substr(strrev(md5( $val[3]. '-' .$val[4]. '-' .$val[0] )), 0, 10); 

			/* filter out the categoryurl to disregard special characters */

			$producturlid = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $producturlid);
			$producturlid = str_replace(array('.', ',', '[', ']', '(', ')', '&', '%'), '', $producturlid);
			$producturlid = str_replace(' ', '-', $producturlid); 

			/* replaces space with dash */


		return $producturlid;

	}


	private function getGeneratedDescription($val=array()){

		/* DESCRIPTION (category+subcategory+material)*/
		$descriptionArr = array();
		$descriptionArr[] = $val[10];
		$descriptionArr[] = $val[13];
		$descriptionArr[] = $val[12];

		return implode(" - ",$descriptionArr);
		
	}
	
	
	private function productUpload($file=""){
	
	
			if($file==""){ throw new NotFoundException(__('Invalid File')); }	

	
				/* loading the file into components */

				/*	public $components = array('ExcelReader'); */
				$this->ExcelReader = $this->Components->load('ExcelReader');
				$this->ExcelReader->loadExcelFile($file);		
				$excelData = $this->ExcelReader->dataArray; 


				$uploadQueryArr = array();
				$uploadQueryArr['product'] = array();
				$uploadQueryArr['category_product'] = array();
				$uploadQueryArr['subcategory_product'] = array();
				$uploadQueryArr['material_product'] = array();
				$uploadQueryArr['bodypart_product'] = array();

				/*for catalog name and catalog page - sep 12*/
				$uploadQueryArr['catalog_name_product'] = array();
				$uploadQueryArr['catalog_page_product'] = array();

				$uploadQueryArr['catalog_product'] = array();	/* sep 23 */


				/* list of brands to be based when updating the value for brand */
				$brands = $this->Brand->find('list');

				/* end */

				ini_set('max_execution_time',200);

				$looper = 1;


				$this->loadModel('Productsearch');

				foreach($excelData as $val){

					/* ---------------------------------------------------------------------------- PRODUCT */
						$ProductInfo = array();

						$ProductInfo['Product']['db_name'] 			= (!empty($val[1])) ? $val[1] : "";	/* DATABASE NAME */

						$ProductInfo['Product']['added'] 			= PHPExcel_Style_NumberFormat::toFormattedString($val[2]+($looper++/86400), "YYYY-MM-DD HH:i:s");	/* DATE ADDED */
						$ProductInfo['Product']['image_name'] 		= $val[3];	/* IMAGE NAME */
						$ProductInfo['Product']['number'] 			= $val[4];	/* PRODNO */



						if( isset( $val[7]) && $val[7] != null ){

							$ProductInfo['Product']['description'] 	= $val[7];	/* DESCRIPTION */

						}
						else{

							$ProductInfo['Product']['description'] 	= $this->getGeneratedDescription($val);	

						}


						$ProductInfo['Product']['emailerlink'] 		= (empty($val[8])) ? "" : $val[8];	/* EMAILERLINK */
						$ProductInfo['Product']['brand_id'] 		= (empty($val[9])) ?  '2' : array_search($val[9], $brands);	/* BRAND_ID */
						$ProductInfo['Product']['feature'] 			= $val[16];	/* FEATURE */
						$ProductInfo['Product']['price'] 			= floatval($val[17]);	/* PRICE */
						$ProductInfo['Product']['s_price'] 			= floatval($val[18]);	/* S-PRICE */

						$ProductInfo['Product']['weight'] 			= floatval($val[19]);	/* weight */
						$ProductInfo['Product']['discount_value'] 	= intval($val[20]);	/* DISCOUNT VALUE */

						$ProductInfo['Product']['promocode'] 		= (empty($val[2])) ? "" : $val[21];	/* PROMOCODE */
						$ProductInfo['Product']['discount_chart'] 	= $val[22];	/* DISCOUNT CHART */
						$ProductInfo['Product']['package_deal'] 	= $val[23];	/* PACKAGE DEAL */
						$ProductInfo['Product']['view_piece'] 		= (empty($val[24])) ? "" : $val[24];	/* VIEW BY PIECE */
						$ProductInfo['Product']['view_pack'] 		= (empty($val[25])) ? "" : $val[25];	/* VIEW BY PACK */
						$ProductInfo['Product']['new_styles'] 		= $val[26];	/* NEW STYLES */
						$ProductInfo['Product']['status'] 			= $val[27];	/* STATUS */



						/* Packaging */
						if(!empty($val[28])){

							$ProductInfo['Product']['packaging'] 	= $val[28];	
						}
						else{
							
							$ProductInfo['Product']['packaging'] 	= "package-not-available";	
						}



						$ProductInfo['Product']['reg_price'] 		= floatval($val[29]);	/* REGULAR PRICE */
						
						$ProductInfo['Product']['subcat']			= $val[13];	
						$ProductInfo['Product']['spotlight_link']	= $val[15];	/* spotlight_link */
	

						/* getting Generated Product URLID */
						$ProductInfo['Product']['producturlid']    	= $this->getAutoGeneratedProductUrlID($val);

			
						$existProduct = $this->Product->find('first',array('conditions'=>array('number'=>$ProductInfo['Product']['number'])));


						if(count($existProduct) == 0 ) {

							$this->Product->create();
							$this->Product->save($ProductInfo); 


						}	
						else{

							/*	
							*	On this part, since a product with that certain product_number already exists, it should just be updated instead of creating new products
							*	updateAll() might be used in here
							*/

							$this->Product->id = $existProduct['Product']['id'];

							/*$this->Product->save($ProductInfo);*/
							/*$this->Product->updateAll($ProductInfo);*/

							$this->Product->saveField('db_name', $ProductInfo['Product']['db_name']);
							$this->Product->saveField('added', $ProductInfo['Product']['added']);
							$this->Product->saveField('image_name', $ProductInfo['Product']['image_name']);
							$this->Product->saveField('number', $ProductInfo['Product']['number']);
							$this->Product->saveField('description', $ProductInfo['Product']['description']);
							$this->Product->saveField('emailerlink', $ProductInfo['Product']['emailerlink']);
							$this->Product->saveField('brand_id', $ProductInfo['Product']['brand_id']);
							$this->Product->saveField('feature', $ProductInfo['Product']['feature']);
							$this->Product->saveField('price', $ProductInfo['Product']['price']);
							$this->Product->saveField('s_price', $ProductInfo['Product']['s_price']);
							$this->Product->saveField('discount_value', $ProductInfo['Product']['discount_value']);
							$this->Product->saveField('promocode', $ProductInfo['Product']['promocode']);
							$this->Product->saveField('discount_chart', $ProductInfo['Product']['discount_chart']);
							$this->Product->saveField('package_deal', $ProductInfo['Product']['package_deal']);
							$this->Product->saveField('view_piece', $ProductInfo['Product']['view_piece']);
							$this->Product->saveField('view_pack', $ProductInfo['Product']['view_pack']);
							$this->Product->saveField('new_styles', $ProductInfo['Product']['new_styles']);
							$this->Product->saveField('status', $ProductInfo['Product']['status']);
							$this->Product->saveField('packaging', $ProductInfo['Product']['packaging']);
							$this->Product->saveField('reg_price', $ProductInfo['Product']['reg_price']);
							$this->Product->saveField('weight', $ProductInfo['Product']['weight']);

							/* save body_parts and spotlight_link */
							$this->Product->saveField('subcat', $ProductInfo['Product']['subcat']);
							/*$this->Product->saveField('bodyparts', $ProductInfo['Product']['bodyparts']);*/
							$this->Product->saveField('spotlight_link', $ProductInfo['Product']['spotlight_link']);
							/* end of save body_parts */

						}

					/* ---------------------------------------------------------------------------- PRODUCT */

					/* ---------------------------------------------------------------------------- BODY PARTS */
					if($val[14]!=""){	

						/*
						* Sep 11, 2014 - Declare whether product id exists
						* This will be executed if and only if the product existed - to be verified using $exisProduct
						*/
						
						if( count($existProduct) != 0 ){	/* this certifies the product exists */

							/* set the product by verifying this existed - sep 11 */
							$this->Product->id = $existProduct['Product']['id'];

							$addBodypartProductParams = array();
							/*$addBodypartProductParams['product_id'] = $this->Product->id;*/
							/*$addBodypartProductParams['product_id'] = $existProduct['Product']['id'];*/	/* this is under observation - initially this works - Sep 10, 2014 - Chirilo */
							$addBodypartProductParams['product_id'] = $this->Product->id; /* reverted back to the old code - this time this value is being verified first */
							$addBodypartProductParams['bodyparts']  = $val[14];	
							
							$uploadQueryArr['bodypart_product'][]   = $this->addBodypartProduct($addBodypartProductParams);
							unset($addBodypartProductParams);

						}

						/*
						* end Sep 11, 2014
						*/

					}

				

					/* ---------------------------------------------------------------------------- CATEGORY and PRODUCT */

						$addCategoryProductParams=array();
						$addCategoryProductParams['product_id']      = $this->Product->id;
						$addCategoryProductParams['categories']      = explode(",",$val[10]); 
						$addCategoryProductParams['category_desc']   = explode($this->DataFormatter->categoryDescSeparator,$val[11]);  



						$uploadQueryArr['category_product'][] = $this->addCategoryProduct($addCategoryProductParams);
						unset($addCategoryProductParams);




					/* ---------------------------------------------------------------------------- SUB CATEGORY and PRODUCT*/

					if($val[13]!=""){

						$addSubCategoryProductParams = array();
						$addSubCategoryProductParams['product_id']      = $this->Product->id;
						$addSubCategoryProductParams['subcategories'] = $val[13];
						
						$uploadQueryArr['subcategory_product'][] = $this->addSubCategoryProduct($addSubCategoryProductParams);
						unset($addSubCategoryProductParams);
					}





					/* ---------------------------------------------------------------------------- MATERIAL and PRODUCT */

					if($val[12]!="") { 

						$addMaterialProductParams=array();
						$addMaterialProductParams['product_id']      = $this->Product->id;
						$addMaterialProductParams['materials']      = $val[12]; 

						$uploadQueryArr['material_product'][] = $this->addMaterialProduct($addMaterialProductParams);
						unset($addMaterialProductParams);

					}





					/* ---------------------------------------------------------------------------- PRODUCT CATALOG */
					/* edited on sep 12, 2014 ----------------------------------------------------- PRODUCT CATALOG NAME and PRODUCT CATALOG PAGE */
					if( $val[5] != "" && $val[6] != "") { 	/* product catalog name */

						/*if( count($existProduct) != 0 ){*/

							/* set the product by verifying this existed - sep 12 */
							/*$this->Product->id = $existProduct['Product']['id'];*/

							$addCatalogProductParams=array();
							$addCatalogProductParams['product_id']      	= $this->Product->id;
							$addCatalogProductParams['catalog_name']      	= $val[5];
							$addCatalogProductParams['catalog_pagenumber']  = $val[6];
							$addCatalogProductParams['number']  			= $existProduct['Product']['number'];

							$uploadQueryArr['catalog_product'][] = $this->addCatalogProduct($addCatalogProductParams);
							/*echo 'uploadQueryArr[catalog_product]';
							pr( $uploadQueryArr['catalog_product'] );
							exit();*/
							unset($addCatalogProductParams);

						/*}*/

					}

					
					/* end sep 12 */



					/* ---------------------------------------------------------------------------- PRODUCT SEARCH */

						$searches = addslashes(implode(' ',$val));
						$search_query = " INSERT INTO productsearches(product_id,status,parameters) values(".$this->Product->id.",'".$ProductInfo['Product']['status']."','".$searches."')  ";
						$search_query .= " ON DUPLICATE KEY UPDATE  id=id, parameters='".$searches."', status='".$ProductInfo['Product']['status']."', product_id=".$this->Product->id." ";

						$this->Productsearch->query($search_query);


				} /* foreach end */






				/* BULK INSERT AND UPDATE  */

					/* Subcategory and Product */
					$subCategoryProductUploadQueryArrString = "INSERT INTO subcategories_products(product_id,subcategory_id,created,updated) values ".implode(",",$uploadQueryArr['subcategory_product'])." ON DUPLICATE KEY UPDATE  id=id, updated=now()";
					$this->Product->query($subCategoryProductUploadQueryArrString);


					/* Material and Product */
					$materialProductUploadQueryArrString = "INSERT INTO materials_products(product_id,material_id,created,updated) values ".implode(",",$uploadQueryArr['material_product'])." ON DUPLICATE KEY UPDATE  id=id, updated=now()";
					$this->Product->query($materialProductUploadQueryArrString);

					/* Catalog Name and Product - sep 12, 2014 */
					if( !empty( $uploadQueryArr['catalog_product'] ) ){	/* updated on sep 23, 2014 */
						$catalogProductUploadQueryArrString = "INSERT INTO catalogs_products(product_id,catalog_id,pagenumber,number) values ".implode(",",$uploadQueryArr['catalog_product'])." ON DUPLICATE KEY UPDATE  id=id";
						$this->Product->query($catalogProductUploadQueryArrString);
					}



					/* Category and Product */
					if(!empty($uploadQueryArr['category_product'])) {

						$categoryProductUploadQueryArrString = "INSERT INTO categories_products(product_id,category_id,created,updated) values ".implode(",",$uploadQueryArr['category_product'])." ON DUPLICATE KEY UPDATE  id=id, updated=now()";
						$this->Product->query($categoryProductUploadQueryArrString);

					}

					
					/* Bodypart and Product */
					if(!empty($uploadQueryArr['bodypart_product'])){

						$bodyPartProductUploadQueryArrString = "INSERT INTO bodyparts_products(product_id,bodypart_id,created,updated) values ".implode(",",$uploadQueryArr['bodypart_product'])." ON DUPLICATE KEY UPDATE  id=id, updated=now()";
						$this->Product->query($bodyPartProductUploadQueryArrString);
					}



				/* ----------------------------------------------------------------------- VARIABLE CLEANING */

					unset($uploadQueryArr);


				/* ----------------------------------------------------------------------- BUILDING PRODUCT LISTING */
				
				
					/* 
						Generating the Product Images
						where : status:active, group: image_name, order:date_added desc 
					*/ 
					$this->Product->query("TRUNCATE TABLE products_images");
					$this->Product->query("INSERT into products_images(product_id,product_image_name,added) 
										   SELECT id,image_name, added FROM products WHERE status='active' GROUP BY image_name ORDER BY added DESC ");


					/* 
						Generating the Product Images New Styles
						where : status:active, new_styles='active'  group: image_name, order:date_added desc 
					*/ 
					$this->Product->query("TRUNCATE TABLE products_images_newstyles");
					$this->Product->query("INSERT into products_images_newstyles(product_id) 
										   select id FROM products WHERE status='active' and new_styles='active' GROUP BY image_name ORDER BY added DESC ");


					/* 
						Generating the Product Images Onsales Listing
						where : status:active, discount_value > 0 ,  group: image_name, order:date_added desc 
					*/ 
					$this->Product->query("TRUNCATE TABLE products_images_onsales");
					$this->Product->query("INSERT into products_images_onsales(product_id) 
										   select id FROM products WHERE status='active' and discount_value > 0 GROUP BY image_name ORDER BY added DESC ");





	}


	public function products(){


		if($this->request->is('post') && $this->request->data){


				$this->response->disAbleCache();

				if($this->Upload->validateExcelType($this->request->data['Product']['excel_file'])){
				
					$dest_filename = strtolower($this->Upload->filesInfo['name']);
					$dest_filename = str_replace(' ','-',$dest_filename);

					$targetPath = "files".DS.basename($dest_filename);


						move_uploaded_file($this->Upload->filesInfo['tmp_name'],$targetPath);


						if(is_readable($targetPath) && file_exists($targetPath) ) {


							/* product uploading */
							$this->productUpload($targetPath);

							$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> uploaded successfully",'default',array('class'=>'success_message'));
							
							 /*$this->redirect(array('controller'=>'uploads','action'=>'products')); */
							echo "<script>window.location = window.location</script>";
							exit();

						} 
						else{

							$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> failed to upload <span class='black-span'>failed to upload the server</span>",'default',array('class'=>'failed_message'));
							$this->redirect(array('controller'=>'uploads','action'=>'products'));

						}					


						$this->redirect(array('controller'=>'uploads','action'=>'products'));
					
				}
				else{

						$this->Session->setFlash("<b>".basename($this->request->data['Product']['excel_file']['name'])."</b> failed to upload <span class='black-span'>Invalid format</span>",'default',array('class'=>'failed_message'));

						$this->redirect(array('controller'=>'uploads','action'=>'products'));

				}				

		}




		$this->set('page_title',"Product Upload");
		

	}

	

	
	// when uploading Other Images Database
	function product_other_images(){

		if($this->request->is('post') && $this->request->data){


			if($this->Upload->validateExcelType($this->request->data['Products_image']['excel_file'])){

				$targetPath = WWW_ROOT."files".DS."imports".DS.basename(strtolower($this->Upload->filesInfo['name']));


				if(move_uploaded_file($this->Upload->filesInfo['tmp_name'],$targetPath) ) {

							/* uploading */
							$this->productOtherImagesUpload($targetPath);

							$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> uploaded successfully",'default',array('class'=>'success_message'));

							echo "<script>window.location = window.location</script>";
							exit();


				} 
				else{

					$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> failed to upload <span class='black-span'>failed to upload the server</span>",'default',array('class'=>'failed_message'));

				}

				$this->redirect(array('controller'=>'uploads','action'=>'product_other_images'));

			}
			else{

				$this->Session->setFlash("<b>".basename($this->request->data['Products_image']['excel_file']['name'])."</b> failed to upload <span class='black-span'>Invalid format</span>",'default',array('class'=>'failed_message'));

				$this->redirect(array('controller'=>'uploads','action'=>'product_other_images'));

			}

		}

		$this->set('page_title',"Product Other Images Upload");

	}

	/* function used by product_other_images() */
	function productOtherImagesUpload($file=""){

		if($file == ""){ throw new NotFoundException(__('Invalid File'));	}


		/* process the file */
		$this->ExcelReader = $this->Components->load('ExcelReader');
		$this->ExcelReader->loadExcelFile($file);		
		$excelDatas = $this->ExcelReader->dataArray;



		$productOtherImagesInfoArr = array();
		foreach( $excelDatas as $excelData ){ 
				$productOtherImagesInfoArr[] = $excelData[0]; 
		}


		/* Get Product Ids */
		$options = array();
		$options['conditions']['Product.number'] = $productOtherImagesInfoArr;
		$options['fields'] = array('id','number');

		$productIdsNumbers = $this->Product->find('list',$options);



		$this->loadModel('Productotherimage');

		foreach( $excelDatas as $excelData ){

			$productOtherImagesInfo = array();

			/*$productOtherImagesInfo['Products_image']['product_number'] 			= $excelData[0];*/

			//$productOtherImagesInfo['Products_image']['product_image_name'] 		= $excelData[1];
			$productOtherImagesInfo['Products_image']['image1']				= $excelData[2];
			$productOtherImagesInfo['Products_image']['image2']				= $excelData[3];
			$productOtherImagesInfo['Products_image']['image3']				= $excelData[4];
			$productOtherImagesInfo['Products_image']['image4']				= $excelData[5];

			$productOtherImagesInfo['Products_image']['product_id']					= array_search($excelData[0],$productIdsNumbers); 



				if($productOtherImagesInfo['Products_image']['product_id']!=""){

					$product_id = $productOtherImagesInfo['Products_image']['product_id'];

						$fields = implode(",",array_keys($productOtherImagesInfo['Products_image']));
						$array_datas = "'".implode("','",$productOtherImagesInfo['Products_image'])."'";

						/* custom query */
						$custom_query = "INSERT INTO productotherimages($fields) VALUES($array_datas) ";
						$custom_query .=" ON DUPLICATE KEY UPDATE 
											id=id, 
											image1='".$productOtherImagesInfo['Products_image']['image1'] ."',
											image2='".$productOtherImagesInfo['Products_image']['image2'] ."',
											image3='".$productOtherImagesInfo['Products_image']['image3'] ."',
											image4='".$productOtherImagesInfo['Products_image']['image4'] ."'
										";

						$this->Productotherimage->query($custom_query);

				}


		}
		
	}

	
	/* when uploading Dimension Database excel */
	function product_dimensions(){
		if($this->request->is('post') && $this->request->data){



			if($this->Upload->validateExcelType($this->request->data['Productdimension']['excel_file'])){

				$targetPath = WWW_ROOT."files".DS."imports".DS.basename(strtolower($this->Upload->filesInfo['name']));



				if(move_uploaded_file($this->Upload->filesInfo['tmp_name'],$targetPath) ) {

							/* product uploading */
							$this->productDimensionsUpload($targetPath);

							$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> uploaded successfully",'default',array('class'=>'success_message'));

							echo "<script>window.location = window.location</script>";
							exit();

				} 
				else{

					$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> failed to upload <span class='black-span'>failed to upload the server</span>",'default',array('class'=>'failed_message'));

				}

				$this->redirect(array('controller'=>'uploads','action'=>'product_dimensions'));

			}
			else{

				$this->Session->setFlash("<b>".basename($this->request->data['Productdimension']['excel_file']['name'])."</b> failed to upload <span class='black-span'>Invalid format</span>",'default',array('class'=>'failed_message'));

				$this->redirect(array('controller'=>'uploads','action'=>'product_dimensions'));

			}

		}
		$this->set('page_title',"Product Dimensions Upload");
	}



	private function getGaugeUrl($gauge=''){

		$returnGauge  = str_replace('"','in',html_entity_decode($gauge,ENT_QUOTES));
		$returnGauge = preg_replace(self::$filter_pattern,'-',strtolower($returnGauge));
		
		return $returnGauge;


	}

	private function getLengthUrl($length=''){

		$returnLength  = str_replace('"','in',html_entity_decode($length,ENT_QUOTES));
		$returnLength = preg_replace(self::$filter_pattern,'-',strtolower($returnLength));
		
		return $returnLength;

	}


	/* function used by product_dimensions */
	private function productDimensionsUpload($file=""){


		if($file == ""){ throw new NotFoundException(__('Invalid File'));	}


		/* Load the EXCEL COMPONENT */
		$this->ExcelReader = $this->Components->load('ExcelReader');
		$this->ExcelReader->loadExcelFile($file);		

		$excel_datas = $this->ExcelReader->dataArray;

        set_time_limit(200);
		ini_set('max_execution_time',120);


		$excel_datas_numbers = array();
		foreach($excel_datas as $excel_data){

			$excel_datas_numbers[] = $excel_data[0];

		}


		/* Getting product ids from Product Model */	

			$options = array();
			$options['conditions']['number'] = $excel_datas_numbers;
			$options['fields'] = array('id','number');

			$productIdsNumbers = $this->Product->find('list',$options);



			$productDimensionsStringArr = array();

			foreach( $excel_datas as $excel_data ){


				if(in_array($excel_data[0],$productIdsNumbers)){

					/*	

						$productDimensions[]['product_number'] 	= $excel_data[0]; 
						$productDimensions[]['identification'] 	= $excel_data[1];
						$productDimensions[]['color']			= $excel_data[2];

					*/	


					$productDimensions = array();


					$productDimensions['Productdimension']['gaugeinch']			= addslashes($excel_data[3]);
					$productDimensions['Productdimension']['gaugemm']			= addslashes($excel_data[6]);

					$productDimensions['Productdimension']['lengthinch']		= addslashes($excel_data[4]);
					$productDimensions['Productdimension']['lengthmm']			= addslashes($excel_data[7]);

					$productDimensions['Productdimension']['widthinch']			= addslashes($excel_data[5]);
					$productDimensions['Productdimension']['widthmm']			= addslashes($excel_data[8]);

					$productDimensions['Productdimension']['ball_gem_size']		= addslashes($excel_data[9]);

					$productDimensions['Productdimension']['length']			= addslashes($excel_data[10]);
					$productDimensions['Productdimension']['width']				= addslashes($excel_data[11]);
					$productDimensions['Productdimension']['height']			= addslashes($excel_data[12]);


					/* 
						formatting gaugeincurl = 
					*/

					$productDimensions['Productdimension']['gaugeincurl']		= $this->getGaugeUrl($excel_data[3]);
					$productDimensions['Productdimension']['lengthinurl'] 	= $this->getLengthUrl($excel_data[4]);



					/* Providing a product id */
					$productDimensions['Productdimension']['product_id']		= array_search($excel_data[0],$productIdsNumbers); 

					$product_id = $productDimensions['Productdimension']['product_id'];

					$fields = implode(",",array_keys($productDimensions['Productdimension']));



					/* Inserting Updating the Product Dimension Table */

						$query_string = " INSERT INTO productdimensions($fields) values ('".implode("','",$productDimensions['Productdimension'])."') 
										  ON DUPLICATE KEY UPDATE id=id, 									  	
										    gaugeinch='{$productDimensions['Productdimension']['gaugeinch']}',
										    gaugeincurl='{$productDimensions['Productdimension']['gaugeincurl']}',
										  	gaugemm='{$productDimensions['Productdimension']['gaugemm']}',

										  	lengthmm='{$productDimensions['Productdimension']['lengthmm']}',
										  	lengthinch='{$productDimensions['Productdimension']['lengthinch']}',

										  	lengthinurl='{$productDimensions['Productdimension']['lengthinurl']}',

										  	widthinch='{$productDimensions['Productdimension']['widthinch']}',
										  	widthmm='{$productDimensions['Productdimension']['widthmm']}',

										  	ball_gem_size='{$productDimensions['Productdimension']['ball_gem_size']}',

										  	length='{$productDimensions['Productdimension']['length']}',
										  	width='{$productDimensions['Productdimension']['width']}',
										  	height='{$productDimensions['Productdimension']['height']}'

										";


						$this->Productdimension->query($query_string);


					/* Updating the Product Table */	

					$this->Product->id = $product_id;


					$productParams = array();

					$productParams['color_id'] = $this->addColor("".$excel_data[2]."");
					$productParams['identification'] = addslashes($excel_data[1]); /* identification */


					$this->Product->save($productParams);
					




				}

			}


	}



	
	/* this has to be bulk update; in the meantime just update the Products table with avail_qty value */
	/* when uploading Quantity Database */
	function product_quantities(){

		if($this->request->is('post') && $this->request->data){



			if($this->Upload->validateExcelType($this->request->data['Products_quantity']['excel_file'])){

				$targetPath = WWW_ROOT."files".DS."imports".DS.basename(strtolower($this->Upload->filesInfo['name']));

				/*pr( $targetPath );
				exit();*/

				if(move_uploaded_file($this->Upload->filesInfo['tmp_name'],$targetPath) ) {

							// product uploading
							$this->productQuantitiesUpload($targetPath);

							$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> uploaded successfully",'default',array('class'=>'success_message'));

							echo "<script>window.location = window.location</script>";
							exit();


				} 
				else{

					$this->Session->setFlash("<b>".basename($this->Upload->filesInfo['name'])."</b> failed to upload <span class='black-span'>failed to upload the server</span>",'default',array('class'=>'failed_message'));

				}

				$this->redirect(array('controller'=>'uploads','action'=>'product_quantities'));

			}
			else{

				$this->Session->setFlash("<b>".basename($this->request->data['Products_quantity']['excel_file']['name'])."</b> failed to upload <span class='black-span'>Invalid format</span>",'default',array('class'=>'failed_message'));

				$this->redirect(array('controller'=>'uploads','action'=>'product_quantities'));
			
			}

		}
		$this->set('page_title',"Product Quantities Upload");

	}
	
	/* function used by product_quantities */
	private function productQuantitiesUpload($file=""){

		if($file == "") throw new NotFoundException(__('Invalid File'));	

		/* process the file */
		$this->ExcelReader = $this->Components->load('ExcelReader');
		$this->ExcelReader->loadExcelFile($file);		
		$excelDatas = $this->ExcelReader->dataArray;


		/* */
		$excel_datas_numbers  = array();
		foreach($excelDatas as $excelData ){ $excel_datas_numbers[] = $excelData[1]; }


		/* Getting product ids from Product Model */	

			$options = array();
			$options['conditions']['number'] = $excel_datas_numbers;
			$options['fields'] = array('id','number');

			$productIdsNumbers = $this->Product->find('list',$options);



		foreach( $excelDatas as $excelData ){

			$productQuantities = array();

			$productQuantities['Products_quantity']['product_number'] 	= rawurlencode($excelData[1]);
			$productQuantities['Products_quantity']['upc_code']			= $excelData[2];
			$productQuantities['Products_quantity']['bin_number']		= $excelData[3];
			$productQuantities['Products_quantity']['avail_qty']		= $excelData[4];


				/* For Product Table */
				if(in_array($excelData[0],$productIdsNumbers)){

					/* Updating Product */

						$productDimensions['Products_quantity']['product_id'] =  array_search($excelData[0],$productIdsNumbers); 

						$query = " INSERT INTO products(id,avail_qty) 
						           VALUES(".$productDimensions['Products_quantity']['product_id'].",".$productQuantities['Products_quantity']['avail_qty'].") 
						           ON DUPLICATE KEY UPDATE id=id, avail_qty='".$productQuantities['Products_quantity']['avail_qty']."' ";

						$this->Product->query($query);

				}	



				/* upcbin */
				$query  = "INSERT INTO upcbins(product_number,upc_code,bin_number,avail_qty) VALUES('".$productQuantities['Products_quantity']['product_number']."','".$productQuantities['Products_quantity']['upc_code']."','".$productQuantities['Products_quantity']['bin_number']."','".$productQuantities['Products_quantity']['avail_qty']."') 
					       ON DUPLICATE KEY UPDATE 
					       	id=id, 
					       	product_number='".$productQuantities['Products_quantity']['product_number']."',
					       	upc_code='".$productQuantities['Products_quantity']['upc_code']."',
					       	bin_number='".$productQuantities['Products_quantity']['bin_number']."',
					       	avail_qty='".$productQuantities['Products_quantity']['avail_qty']."'

					     ";

				$this->Product->query($query);


			
		}


	}





}

