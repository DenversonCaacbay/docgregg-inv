<?php

require_once("classes/conn.php");

// Get ID from GET (better POST but for easy debug...)
if (isset($_GET["blot_photo"])) {
    $blot_photo = $_GET["blot_photo"];
} else {
    echo "Wrong input";
    exit;
}

try {
    // Establish a connection to the database
    $database = new PDO("mysql:host=localhost;dbname=bmis", "admin", "admin12345");

    // Assuming the connection is successful, proceed with the query
    $q = $database->prepare("SELECT * FROM `tbl_blotter` WHERE `blot_photo`=:blot_photo");
    $q->bindParam(":blot_photo", $blot_photo);
    $q->execute();

    if ($q->rowCount() == 1) {
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $image = $row['image'];

        // Clean disconnect
        $database = null;

        header("Content-type: image/jpeg");
        header('Content-Disposition: attachment; filename="table_with_image_image'.$blot_photo.'.jpg"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: ".strlen($image));
        
        echo $image;
    } else {
        $database = null;
        echo "No image found";
    }
} catch (PDOException $e) {
    // Catch any potential connection errors
    echo "Connection failed: " . $e->getMessage();
}
exit();
?>
