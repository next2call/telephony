<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Lead Form</title>
</head>
<body>
    <form id="leadForm" method="post">
        <div id="leadFields"></div>
        <button type="button" onclick="addInput()">Add Input Field</button>
        <button type="submit">Submit</button>
    </form>

    <script>
        function addInput() {
            var form = document.getElementById('leadForm');
            var leadFields = document.getElementById('leadFields');

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

            var labelElement = document.createElement('label');
            labelElement.innerHTML = label + ": ";

            leadFields.appendChild(labelElement);
            leadFields.appendChild(input);
            leadFields.appendChild(document.createElement('br'));
        }
    </script>

    <?php
    // PHP code to handle form submission and dynamic column creation
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

        // Prepare SQL queries to alter table and add columns dynamically
        foreach ($fields as $key => $value) {
            $sql = "ALTER TABLE dynamic_leads_ui ADD $key VARCHAR(255)";
            if ($con->query($sql) === TRUE) {
                echo "Column $key added successfully<br>";
            } else {
                echo "Error adding column $key: " . $con->error . "<br>";
            }
        }

        // Close the database connection
        $con->close();
    }
    ?>
</body>
</html>
