 <?php  
 
 App::uses('Component', 'Controller');  
 
  class DataFormatterComponent extends Component {  
  

  	static private $filter_pattern = "/[^a-zA-Z0-9_.-]/s";
  	public $categoryDescSeparator = "******";


   	public function initialize(Controller $controller) {  
   
     	parent::initialize($controller);  
	 
    } 



    public function getUrlFriendlyValue($val=""){

    	 preg_replace(self::$filter_pattern,'-',strtolower($value));

    }

	public function getGaugeUrl($gauge=''){

		$returnGauge  = str_replace('"','in',html_entity_decode($gauge,ENT_QUOTES));
		$returnGauge = preg_replace(self::$filter_pattern,'-',strtolower($returnGauge));
		
		return $returnGauge;


	}

	public function getLengthUrl($length=''){

		$returnLength  = str_replace('"','in',html_entity_decode($length,ENT_QUOTES));
		$returnLength = preg_replace(self::$filter_pattern,'-',strtolower($returnLength));
		
		return $returnLength;

	}



	
   
 }  
 ?>      