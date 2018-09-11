<?php

print_r($_FILES);

$file_name = $_FILES['image']['name'];
$file_tmp = $_FILES['image']['tmp_name'];
move_uploaded_file($file_tmp, '/www/web/demo/' . $file_name);