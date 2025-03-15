<?php
session_start();
$flag = 'ATHACKCTF{f4ke_it_till_y0u_m4ke_it}';

if (isset($_FILES['file'])) {
    $allowed_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
    $file_type = exif_imagetype($_FILES['file']['tmp_name']);

    $name = $_FILES['file']['name'];
    $extension = pathinfo($name, PATHINFO_EXTENSION);

    if (!in_array($file_type, $allowed_types)) {
        // Check if file was renamed to look like an image
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            echo "<div class='flag-message'><h1>Congratulations! You've found the flag: $flag</h1></div>";
            exit;
        } else {
            die("Only image files (JPEG, PNG, GIF, WEBP) are allowed.");
        }
    }

    if ($_FILES['file']['size'] < 52428800) { // Check file size...  smaller files?? 
        if (isset($_SESSION['id'])) {
            $random = $_SESSION['id'];
        } else {
            $random = bin2hex(random_bytes(16));
            $_SESSION['id'] = $random;
        }

        $dir = 'uploads/' . $random;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = $dir . '/' . basename($name);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
            echo '<!DOCTYPE html><html>
<head>
<link rel="stylesheet" href="static/bootstrap.css">
<link rel="stylesheet" href="static/stylesheet.css">
</head>
<body>
<div class="align-middle well">
<div class="container my-5 px-4">
    <p>File has been uploaded successfully... You can find it <a href="' . $path . '">here</a>, however You will <b>NOT</b> get the flag that easy!</p>
</div>
</div>
</body>
</html> ';
        }
    } else {
        die("File too large, this service is meant for small files only");
    }
} else {
    echo "No file sent";
}
