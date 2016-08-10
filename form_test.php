<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

$uploaddir = '/usr/share/nginx/html/profiles/';
$uploadfile = $uploaddir . basename($_FILES['myfile']['name']);
/*
echo '<pre>';
if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}
*/
echo 'Here is some more debugging info:';
print_r($_FILES);
echo '<br />';
echo ini_get('upload_tmp_dir');
echo '<br />';
echo 'FINAL : ' . $uploadfile . '<br />';
echo 'TEMP  : ' . $_FILES['myfile']['tmp_name'];


$filename = '/usr/share/nginx/html/';
if (is_writable($filename)) {
    echo 'The file is writable';
} else {
    echo 'The file is not writable';
}

echo exec('whoami');
print "</pre>";
