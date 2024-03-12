<?php
// Database connection parameters
include "connect.php";

// Function to sanitize inputs
function sanitize($data) {
    // Remove whitespace and other potentially harmful characters
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to insert data into database
function insertData($conn, $data) {
    if(isset($_POST['temname'])) {
        $name = $_POST['temname'];
        }
    // Insert data into database
    $sql = "INSERT INTO `template` 
            (`tem_name`, 
             `emaPeriod1`, `emaPeriod1_F`, `emaPeriod1_1`, `emaPeriod1_2`, `emaPeriod1_3`,
             `emaPeriod2`, `emaPeriod2_F`, `emaPeriod2_1`, `emaPeriod2_2`, `emaPeriod2_3`,
             `emaPeriod3`, `emaPeriod3_F`, `emaPeriod3_1`, `emaPeriod3_2`, `emaPeriod3_3`,
             `lotSize`, `lotSize_F`, `lotSize_1`, `lotSize_2`, `lotSize_3`,
             `takeProfitAmount`, `takeProfitAmount_F`, `takeProfitAmount_1`, `takeProfitAmount_2`, `takeProfitAmount_3`,
             `stopLossPercent`, `stopLossPercent_F`, `stopLossPercent_1`, `stopLossPercent_2`, `stopLossPercent_3`) 
            VALUES 
            ('$name', 
             '{$data['emaPeriod1']}', '{$data['emaPeriod1,F']}', '{$data['emaPeriod1,1']}', '{$data['emaPeriod1,2']}', '{$data['emaPeriod1,3']}',
             '{$data['emaPeriod2']}', '{$data['emaPeriod2,F']}', '{$data['emaPeriod2,1']}', '{$data['emaPeriod2,2']}', '{$data['emaPeriod2,3']}',
             '{$data['emaPeriod3']}', '{$data['emaPeriod3,F']}', '{$data['emaPeriod3,1']}', '{$data['emaPeriod3,2']}', '{$data['emaPeriod3,3']}',
             '{$data['lotSize']}', '{$data['lotSize,F']}', '{$data['lotSize,1']}', '{$data['lotSize,2']}', '{$data['lotSize,3']}',
             '{$data['takeProfitAmount']}', '{$data['takeProfitAmount,F']}', '{$data['takeProfitAmount,1']}', '{$data['takeProfitAmount,2']}', '{$data['takeProfitAmount,3']}',
             '{$data['stopLossPercent']}', '{$data['stopLossPercent,F']}', '{$data['stopLossPercent,1']}', '{$data['stopLossPercent,2']}', '{$data['stopLossPercent,3']}')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: testputtem.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if file is uploaded
if(isset($_FILES["fileToUpload"])) {
    $target_dir = "template/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Allow only .set files
    if($fileType != "set") {
        echo "Sorry, only .set files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Upload file
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            
            // Read .set file
            $data = array();
            $file = fopen($target_file, "r") or die("Unable to open file!");
            while (!feof($file)) {
                $line = fgets($file);
                $parts = explode("=", $line);
                $data[sanitize($parts[0])] = sanitize($parts[1]);
            }
            fclose($file);
            
            // Insert data into database
            insertData($conn, $data);
            
            // Delete uploaded file
            unlink($target_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close connection
$conn->close();
?>
