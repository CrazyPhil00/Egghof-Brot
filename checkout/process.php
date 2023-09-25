<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['room_id'];
    $name = $_POST['second_name'];
    $productDataJSON = $_POST['product_data'];
    $productData = json_decode($productDataJSON, true);

    if ($productData === null) {
        die('Error decoding JSON data');
    }
    
    $data = [
        'name' => $name,
        'order' => $productData,
    ];

    

    $jsonData = json_encode($data);

    if ($jsonData === false) {
        die('JSON encoding failed');
    }

    $filename = 'orders/' . $roomId. '.json';
    $file = fopen($filename, 'w'); // Use 'w' to overwrite the file; 'a' to append

    if ($file === false) {
        die('Unable to open file for writing');
    }

    $bytesWritten = fwrite($file, $jsonData);

    if ($bytesWritten === false) {
        die('Error writing JSON data to file');
    }

    fclose($file);


    echo "Bestellung wurde Erfolgreich abgeschickt.";
    

    
} else {
    echo "Ein Fehler ist aufgetreten";
}

?>
