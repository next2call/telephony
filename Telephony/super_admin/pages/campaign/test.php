<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetAlert with Advanced HTML</title>
    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <button id="show-alert">Show Advanced Alert</button>

    <script>
        document.getElementById('show-alert').addEventListener('click', function() {
            Swal.fire({
                title: 'Sign Up Form',
                html: `
                    <form id="signup-form">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="swal2-input">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="swal2-input">
                        <button type="submit" class="swal2-confirm swal2-styled">Submit</button>
                    </form>
                `,
                showConfirmButton: false,
                didOpen: () => {
                    const form = document.getElementById('signup-form');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const username = document.getElementById('username').value;
                        const email = document.getElementById('email').value;
                        Swal.fire(`Submitted: ${username}, ${email}`);
                    });
                }
            });
        });
    </script>
</body>
</html>
