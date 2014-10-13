 <?php  
 
 App::import('Vendor', 'PHPExcel',array('file'=>'PHPExcel'.DS.'PHPExcel.php'));  
 App::uses('Component', 'Controller');  
 
  class ExcelReaderComponent extends Component {  
  
   protected $PHPExcelReader;  
   protected $PHPExcelLoaded = false;  
   public $dataArray;  
   
   public function initialize(Controller $controller) {  
   
     parent::initialize($controller);  
	 
	 
     if (!class_exists('PHPExcel'))  
       throw new CakeException('Vendor class PHPExcel not found!');  
	   
     $dataArray = array();  
	 
   } 

	private function getFileExtension($file){
	
	
		$fileParts = explode(".",$file);
		return $fileParts[count($fileParts)-1];
	
	}   
   
   
   public function loadExcelFile($filename) {  
   
     //$this->PHPExcelReader = PHPExcel_IOFactory::createReaderForFile($filename);  
	 
	 $file_ext = $this->getFileExtension($filename);
	 
		if($file_ext!="xls")
			$this->PHPExcelReader = PHPExcel_IOFactory::createReaderForFile($filename);  
		else
			$this->PHPExcelReader = new PHPExcel_Reader_Excel5();
			
     $this->PHPExcelLoaded = true;  
     $this->PHPExcelReader->setReadDataOnly(true);  
     $excel = $this->PHPExcelReader->load($filename);  
     
	 //$this->dataArray = $excel->getSheet(0)->toArray();  
	 $returnData = $excel->getSheet(0)->toArray(); 
	 unset($returnData[0]);
	 $this->dataArray = $returnData;
	 
   }  
   
 }  
 ?>      