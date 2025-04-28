<?php
// Include your database connection file h
require '../../../conf/db.php';
include "../../../conf/Get_time_zone.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded without errors
    if (isset($_FILES["excel"]) && $_FILES["excel"]["error"] == 0) {
        // Define target directory for file upload
        $targetDirectory = "uploads/";
        
        // Define new file name with current date and time
        $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . pathinfo($_FILES["excel"]["name"], PATHINFO_EXTENSION);
        
        // Set target path for file upload
        $targetPath = $targetDirectory . $newFileName;

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["excel"]["tmp_name"], $targetPath)) {
            // Read uploaded CSV file
            if (($handle = fopen($targetPath, "r")) !== FALSE) {
                // Iterate through each row in CSV file
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $full_name = $data[0];
                    $number = $data[1];
                    $phone_code = $data[2];
                    $ins_date = date("d-m-Y");
                    // Check if full name and number are not empty
                    if (!empty($full_name) && !empty($number)) {
                        // Check if the record already exists in the database
                        $stmt = $con->prepare("SELECT * FROM upload_data WHERE number=? AND ins_date=?");
                        $stmt->bind_param("ss", $number, $ins_date);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows == 0) {
                            // Record doesn't exist, insert it
                            $insert = $con->prepare("INSERT INTO upload_data(full_name, number, phone_code, ins_date, dial_status) VALUES(?, ?, ?, ?, 'NEW')");
                            $insert->bind_param("ssss", $full_name, $number, $phone_code, $ins_date);
                            if ($insert->execute()) {
                                echo json_encode(array("status" => "success", "message" => "Your file has been uploaded successfully."));
                            } else {
                                echo json_encode(array("status" => "error", "message" => "Failed to insert data into database."));
                            }
                        } else {
                            echo json_encode(array("status" => "error", "message" => "Record already exists in the database."));
                        }
                        $stmt->close();
                    }
                }
                fclose($handle);
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to open uploaded file."));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to move uploaded file."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "No file uploaded or file upload error occurred."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
