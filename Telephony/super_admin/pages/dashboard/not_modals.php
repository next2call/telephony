<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lead</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .section-title h6 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .my-input {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<!-- Add Lead Modal -->
<div class="modal fade" id="dynamic_lead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST" enctype="multipart/form-data" id="leadForm">
                <div class="modal-body">
                    <div class="row">
                        <!-- Dynamic Fields Section -->
                        <div class="col-12">
                            <div class="section-title">
                                <h6>Dynamic Form Fields</h6>
                            </div>
                            <div id="dynamicFieldsContainer"></div>
                            <button type="button" class="btn btn-primary mt-3" onclick="addField()">Add Field</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add user modal ends here -->

<script>
    // Function to add input fields dynamically
    function addField() {
        var dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');

        var inputType = prompt("Enter input type (e.g., text, email, etc.):");
        var label = prompt("Enter label:");
        var maxSize = prompt("Enter max size:");
        var labelSize = prompt("Enter label size:");

        var input = document.createElement('input');
        input.type = inputType;
        input.name = label;
        input.placeholder = label;
        input.maxLength = maxSize;
        input.style.width = labelSize + 'px';
        input.classList.add('form-control');

        var labelElement = document.createElement('label');
        labelElement.innerHTML = label + ": ";

        var inputWrapper = document.createElement('div');
        inputWrapper.classList.add('my-input');
        inputWrapper.appendChild(labelElement);
        inputWrapper.appendChild(input);

        dynamicFieldsContainer.appendChild(inputWrapper);
    }
</script>

<?php
session_start();

if (!isset($_SESSION['user'])) {
    // If user session is not set, redirect to login page or show error
    echo 'User not logged in!';
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../../conf/db.php";


    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Get all submitted fields
    $fields = array();
    foreach ($_POST as $key => $value) {
        // Exclude non-label fields
        if ($key != "submit") {
            // Store field label and value
            $fields[$key] = $value;
        }
    }

    // Create a new table if it doesn't exist
    $tableName = "dynamic_leads_" . time(); // Unique table name based on timestamp
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY, user VARCHAR(255))";

    if ($con->query($sql) === TRUE) {
        // Add columns to the new table
        foreach ($fields as $key => $value) {
            $sql = "ALTER TABLE $tableName ADD $key VARCHAR(255)";
            if ($con->query($sql) !== TRUE) {
                // Error adding column
                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
                <script>
                window.onload = function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error adding column ' . $key . '",
                        confirmButtonText: "OK"
                    });
                }
                </script>';
                exit;
            }
        }

        // Insert the user and fields into the table
        $fields['user'] = $user; // Include user session value

        $columns = implode(", ", array_keys($fields));
        $values = implode("', '", array_values($fields));
        $sql = "INSERT INTO $tableName ($columns) VALUES ('$values')";

        if ($con->query($sql) === TRUE) {
            // Success message
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
            <script>
            window.onload = function() {
                Swal.fire({
                    icon: "success",
                    title: "Lead Note added successfully!",
                    confirmButtonText: "OK"
                });
            }
            </script>';
        } else {
            // Error inserting data
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
            <script>
            window.onload = function() {
                Swal.fire({
                    icon: "error",
                    title: "Error adding Lead Note!",
                    confirmButtonText: "OK"
                });
            }
            </script>';
        }
    } else {
        // Error creating table
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
        <script>
        window.onload = function() {
            Swal.fire({
                icon: "error",
                title: "Error creating Lead Note!",
                confirmButtonText: "OK"
            });
        }
        </script>';
    }

    // Close the database connection
    $con->close();
}
?>
</body>
</html>
