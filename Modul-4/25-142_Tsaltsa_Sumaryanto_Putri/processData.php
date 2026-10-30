<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Process Data</title></head>
<body>
<h3>Posted data: </h3>
<?php
// 4.3 langkah 2: tampilkan semua isian form dengan foreach
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";

// 4.3.1 langkah 5: validasi server-side sederhana untuk surname
require 'validate.inc';
$errors = array();
validateName($errors, $_POST, 'surname');

echo '<hr/>';
if ($errors) {
    echo 'Errors:<br/>';
    foreach ($errors as $field => $error)
        echo "$field $error</br>";
} else {
    echo 'Data OK!';
}
?>
</body>
</html>