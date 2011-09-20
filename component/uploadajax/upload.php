<?php
$tempdir = $_SERVER['DOCUMENT_ROOT'].'/dulichanh/cms/file/temp/';
//Tao thu muc		F:/AppServ/www/dulichanh
/*if (! is_dir($tempdir))
	mkdir( $tempdir , 0777 );*/

$filename=basename($_FILES['userfile']['name']);
$size=$_FILES['userfile']['size'];
$arfile = split('\.', $filename);
$name=$arfile[0];
$ext = $arfile[1];
$tempfile = $tempdir.$filename;
$tempname=$name.".".$ext;
$count=1;
while(file_exists($tempfile))
{
	$tempname=$name.$count.".".$ext;
	$tempfile=$tempdir.$tempname;
	$count++;
}
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $tempfile)) {
  //echo "success";
} else {
  //echo "error";
}
//echo $tempname;
echo $tempname.','.$size.','.$ext;
?>