<?php 
require './function.php';
$data = readJsonFile('./temp.json');
saveToExcelFile('data.xls',$data);