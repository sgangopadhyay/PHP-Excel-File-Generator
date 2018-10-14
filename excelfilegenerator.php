<?php
// Program : PHP program to generate Excel file from the MySQL Database
// Author : Suman Gangopadhyay
// Date of Coding : 20-July-2015
// MySQL Database : php_mysqli
// Table Name : userinfo
// Caveats : Change the MySQL Database and the Table name
// Copyright © 2015 Suman Gangopadhyay

// Create the MySQL Database Connection and fetch all the data from the table
define("IP","localhost");
define("USERNAME","root");
define("PASSWORD","suman");
define("DBNAME","php_mysqli");
$filename = "suman_php_excel";
$sql = "SELECT * FROM userinfo";
$connection = mysqli_connect(IP, USERNAME, PASSWORD,DBNAME);
$result = mysqli_query($connection,$sql);
// Create the file header type for the Excel file
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
// Fetch the Column name from the MySQL database
$i=0;
while($i < mysqli_num_fields($result)){
  $col_object = mysqli_fetch_field_direct($result,$i);
  $column_name = $col_object->name;
  echo $column_name."\t";
  $i = $i + 1;
}
// Fetch all the rows from the MySQL database according to there respective column into the Excel file
echo "\n";
while($row = mysqli_fetch_row($result)){
  $data = "";
  for($j=0; $j<mysqli_num_fields($result);$j++){
    if(!isset($row[$j])){
      $data .= "NULL"."\t";
    }elseif($row[$j] != ""){
      $data .= "$row[$j]"."\t";
    }else{
      $data .= ""."\t";
    }
  }		
  $data = str_replace("\t"."$", "", $data);
  $data = preg_replace("/\r\n|\n\r|\n|\r/", " ", $data);
  $data .= "\t";
  print(trim($data));
  echo "\n";
}
?>
