<?php 

print_r($_FILES);
print_r($_GET);
print_r($_POST);

$file_name = $_POST['image_name'];
$file_tmp = $_POST['image_path'];
copy($file_tmp, '/www/web/demo/data/' . $file_name);
