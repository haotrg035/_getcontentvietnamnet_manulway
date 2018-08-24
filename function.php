<?php
require './libs/PHPExcel/Classes/PHPExcel.php';
include './libs/DiDom/Document.php';
include './libs/DiDom/Encoder.php';
include './libs/DiDom/Query.php';
include './libs/DiDom/Errors.php';
include './libs/DiDom/Element.php';
use DiDom\Document;
use Didom\Query;
$dataStore =[];
function saveToJsonFile($fileUrl = null)
{
    if (!isset($fileUrl)) {
        $fileUrl = './JsonTemp.json';
    }
    $file = fopen($fileUrl,'w');
    if(!$file) echo ('Tao file json that bai'); else {
        fwrite($file,json_encode($GLOBALS['dataStore']));
        echo 'Tao file json thanh cong';
        fclose($file);
    }
}
function readJsonFile($fileUrl = null)
{
    if (!isset($fileUrl)) {
        $fileUrl = './JsonTemp.json';
    }
    if(!file_exists($fileUrl)) die('File json khong ton tai');
    $filecontent = file_get_contents($fileUrl);
    return json_decode($filecontent);
}
function pushContent($_url = null)
{
    if (!isset($_url)) {
        die('URL khong hop le');
    }
    $html = new Document();
    $html->loadHtmlFile($_url);
    $content ='';
    $sumarizes = $html->first('#ArticleContent>p')->text();
    $temp = $html->find('#ArticleContent>p');
    for ($i=1; $i < count($temp); $i++) { 
        $content .= trim($temp[$i]->text());
    }
    array_push($GLOBALS['dataStore'],[$sumarizes,$content]);
}

function saveToExcelFile($fileUrl = null ,$data = null)
{
    if(!isset($fileUrl)) $fileUrl = 'data.xls';
    $excelobj = new PHPExcel();
    $excelobj->setActiveSheetIndex(0);
    $excelobj->getActiveSheet()->setTitle = 'Data Vietnamnet';
    $excelobj->getActiveSheet()->getColumnDimension('A')->setWidth(100);
    $excelobj->getActiveSheet()->getColumnDimension('B')->setWidth(500);
    $excelobj->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
    $excelobj->getActiveSheet()->setCellValue('A1','Sumarizes');
    $excelobj->getActiveSheet()->setCellValue('B1','Content');
    $numRow=2;
    foreach ($data as $row) {
        $excelobj->getActiveSheet()->setCellValue('A'.$numRow,$row[0]);
        $excelobj->getActiveSheet()->setCellValue('B'.$numRow,$row[1]);
        $numRow++;
    }
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="data.xls"');
    PHPExcel_IOFactory::createWriter($excelobj, 'Excel2007')->save('php://output');
}
function getContentFromListLink($fileUrl=null)
{
    $fileUrl = (isset($fileUrl)) ? $fileUrl : './listlink.txt' ;
    $file = fopen($fileUrl,'r');
    if (!$file) echo ('mo file khong thanh cong');
    else {
        while (!feof($file)) {
            $link = fgets($file);
            pushContent($link);
        }
    }
    saveToJsonFile('./temp.json');
}