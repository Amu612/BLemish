<?php
session_start();
include("conn.php");

// Hide warnings from users
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', '0');

// Optional: Log errors to a file
ini_set('log_errors', '1');
ini_set('error_log', 'errors.log');

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: signup.html");
    exit();
}

$username = $_SESSION['username'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile_pic = ''; // Default empty value
    $bio = $_POST['bio'] ?? '';
    $gender = $_POST['gender'] ?? '';

    // Handle image upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $upload_dir = "uploads/"; // Directory to store uploaded images
        $img_name = $_FILES['profile_pic']['name'];
        $img_tmp = $_FILES['profile_pic']['tmp_name'];
        $img_size = $_FILES['profile_pic']['size'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        
        // Validate file type and size (adjust size limits as needed)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($img_ext, $allowed_ext) && $img_size <= 5000000) { // 5MB limit
            $new_img_name = uniqid('profile_', true) . "." . $img_ext;
            $target_file = $upload_dir . $new_img_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($img_tmp, $target_file)) {
                $profile_pic = $target_file; // Store the relative file path in the database
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type or size too large.";
        }
    }

    // Update user details in the database
    $updateQuery = "UPDATE user SET profile_pic = ?, bio = ?, gender = ? WHERE username = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssss", $profile_pic, $bio, $gender, $username);
    $stmt->execute();

    // Redirect back to profile page after saving
    header("Location: profile.php");
    exit();
}

// Fetch current data from the database
$sql = "SELECT profile_pic, bio, gender FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profile</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: white;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
    }

    .heading {
      font-size: 24px;
      font-weight: bold;
      color: black;
      margin-top: 20px;
    }

    .form-group {
      margin-bottom: 20px;
      width: 80%;
      max-width: 300px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"], input[type="file"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid gray;
      border-radius: 5px;
    }

    .save-btn {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 20px;
    }

    .profile-pic-preview {
      margin-top: 20px;
      max-width: 150px;
      max-height: 150px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="heading">Edit Profile</div>

    <form method="POST" action="edit.php" enctype="multipart/form-data">
      <!-- Profile Picture Upload -->
      <div class="form-group">
        <label for="profile_pic">Profile Picture</label>
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
      </div>

      <!-- Display current profile picture preview -->
      <?php if (!empty($user['profile_pic'])): ?>
        <div class="profile-pic-preview">
          <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      <?php endif; ?>

      <!-- Bio and Gender Fields -->
      <div class="form-group">
        <label for="bio">Bio</label>
        <input type="text" id="bio" name="bio" value="<?php echo htmlspecialchars($user['bio'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="gender">Gender</label>
        <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender'] ?? ''); ?>">
      </div>

      <button class="save-btn" type="submit">Save</button>
    </form>
  </div>

</body>
</html>
