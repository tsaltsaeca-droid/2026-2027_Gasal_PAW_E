<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register</title>
<style>
  body { font-family: Verdana, sans-serif; font-size: 13px; }
  fieldset { background: #ccf; width: 420px; }
  .field { margin: 4px 0; }
  .field label { display: inline-block; width: 120px; text-align: right; margin-right: 6px; vertical-align: top; }
  .error { color: #b00020; }
</style>
</head>
<body>
<h1>Register</h1>
<?php
// Self-submission: form, validasi, dan pesan hasil berada dalam satu file.
$errors = array();

if (isset($_POST['surname'])) {            // Ada isian form? -> Ya
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');

    if ($errors) {                          // Ada error? -> Ya
        echo '<h2 class="error">Invalid, correct the following errors:</h2>';
        foreach ($errors as $field => $error)
            echo "<span class=\"error\">" . htmlspecialchars($field) . " $error</span><br/>";

        // tampilkan kembali form DENGAN isian data (lihat form.inc)
        include 'form.inc';
    } else {                                // Ada error? -> Tidak
        echo 'Form submitted successfully with no errors';
    }
} else {                                    // Ada isian form? -> Tidak
    include 'form.inc';                     // tampilkan form kosong
}
?>
</body>
</html>