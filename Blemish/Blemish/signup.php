    <?php
    session_start(); // Start session to pass username
    include("conn.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data (make sure HTML form uses name="First_name", etc.)
        $first_name = mysqli_real_escape_string($conn, $_POST['First_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['Last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);

        // Detect role based on which button was clicked
        $role = isset($_POST['FreelancerBtn']) ? 'Freelancer' : 'Client';

        // Check if email already exists
        $check_email = "SELECT * FROM USER WHERE email = '$email'";
        $result = mysqli_query($conn, $check_email);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email already registered! Please log in.'); window.location.href='signup.html';</script>";
            exit();
        }

        // Generate a unique username
        $base_username = strtolower($first_name . "." . $last_name);
        $username = $base_username;
        $counter = 1;
        while (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM USER WHERE UserName = '$username'")) > 0) {
            $username = $base_username . $counter;
            $counter++;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $query = "INSERT INTO USER (FirstName, LastName, UserName, Email, Password, Country, Role)
                VALUES ('$first_name', '$last_name', '$username', '$email', '$hashed_password', '$country', '$role')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['username'] = $username; // Store username in session
            header("Location: q.php"); // ✅ Redirect to q.html after signup
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>
