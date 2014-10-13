<?php 
	

$this->PhpExcel->createWorksheet(); 
$this->PhpExcel->setDefaultFont('Calibri', 11); 


$this->PhpExcel->setActiveSheet(0)->setSheetName('Customer List');
//$this->PhpExcel->SetCellValue('A1',$firstRow)->getStyle('A1')->getFont()->setBold(true);
$this->PhpExcel->SetCellValue('A1',$firstRow);
$this->PhpExcel->mergeCells('A1:BB1');

$this->PhpExcel->SetCellValue('A2','Customer List')->getStyle('A2')->getFont()->setBold(true);


// ------------------------------------------------------------------

$this->PhpExcel->SetCellValue('A3', 'ID');
$this->PhpExcel->SetCellValue('B3', 'Email');
$this->PhpExcel->SetCellValue('C3', 'Shipping Name');
$this->PhpExcel->SetCellValue('D3', 'Shipping Company');
$this->PhpExcel->SetCellValue('E3', 'Shipping Address');
$this->PhpExcel->SetCellValue('F3', 'Shipping City');
$this->PhpExcel->SetCellValue('G3', 'Shipping State');
$this->PhpExcel->SetCellValue('H3', 'Shipping Country');
$this->PhpExcel->SetCellValue('I3', 'Shipping Postcode');
$this->PhpExcel->SetCellValue('J3', 'Shipping Phone');
$this->PhpExcel->SetCellValue('K3', 'Shipping Fax');

$this->PhpExcel->SetCellValue('L3', 'Billing Name');
$this->PhpExcel->SetCellValue('M3', 'Billing Company');
$this->PhpExcel->SetCellValue('N3', 'Billing Address');
$this->PhpExcel->SetCellValue('O3', 'Billing City');
$this->PhpExcel->SetCellValue('P3', 'Billing State');
$this->PhpExcel->SetCellValue('Q3', 'Billing Country');
$this->PhpExcel->SetCellValue('R3', 'Billing Postcode');
$this->PhpExcel->SetCellValue('S3', 'Billing Phone');
$this->PhpExcel->SetCellValue('T3', 'Billing Fax');	


$this->PhpExcel->SetCellValue('U3', 'Business Type');					
$this->PhpExcel->SetCellValue('V3', 'Business Value');					
$this->PhpExcel->SetCellValue('W3', 'Business License');					

$this->PhpExcel->SetCellValue('X3', 'Hear Us ');					
$this->PhpExcel->SetCellValue('Y3', 'Hear Value ');					
$this->PhpExcel->SetCellValue('Z3', 'Date Registered');					

$this->PhpExcel->SetCellValue('AA3', 'Date Modified');					
$this->PhpExcel->SetCellValue('AB3', 'Received latest Catalog');		



$this->PhpExcel->SetCellValue('AB3', 'Received latest Catalog');		



exit();
// -----------------------------------



$this->PhpExcel->addTableFooter(); 
$this->PhpExcel->output($filename,'Excel5'); 

?>