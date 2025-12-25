<?php
session_start();
include("conn.php");

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login.html");
    exit();
}

// Get username from session
$username = $_SESSION['username'];

// Fetch full name from database
$query = "SELECT FirstName, LastName FROM USER WHERE UserName = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
if ($row && !empty($row['FirstName']) && !empty($row['LastName'])) {
    $fullName = $row['FirstName'] . ' ' . $row['LastName'];
} else {
    $fullName = $username;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigEco Onboarding</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: black;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            font-size: 24px;
            border-bottom: 1px solid #ddd;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }

        .left-section {
            flex: 1;
            padding-right: 50px;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
        }

        .step {
            display: flex;
            align-items: center;
            margin: 20px 0;
            font-size: 20px;
        }

        .step img {
            width: 24px;
            margin-right: 10px;
        }

        .get-started {
            background-color: #008000;
            color: white;
            font-size: 18px;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .right-section {
            flex: 1;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid green;
        }

        .profile-name {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
        }

        .profile-role {
            color: gray;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .rating {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .testimonial {
            font-size: 16px;
            color: gray;
            text-align: left;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .nav-arrow {
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <div class="logo" style="color: #0a4b0a;"><b>GigEco</b></div>
    <a href="profile.html"><div class="user-icon">&#128100;</div></a>
</header>

<div class="container">
    <div class="left-section">
        <h1>Hey <?php echo htmlspecialchars($fullName); ?>. Ready for your next big opportunity?</h1>
        <div class="step">
            <span>&#128100;</span> Answer a few questions and start building your profile
        </div>
        <div class="step">
            <span>&#9993;</span> Apply for open roles or list services for clients to buy
        </div>
        <div class="step">
            <span>&#128274;</span> Get paid safely and know we’re there to help
        </div>
        <a href="q1.html"><button class="get-started">Get started</button></a>
        <p style="color: gray; font-size: 14px;">It only takes 5-10 minutes and you can edit it later. We’ll save as you go.</p>
    </div>

    <div class="right-section">
        <img class="profile-img" src="https://randomuser.me/api/portraits/women/50.jpg" alt="User Profile">
        <p class="profile-name"><?php echo htmlspecialchars($fullName); ?></p>
        <p class="profile-role">Customer Experience Consultant</p>
        <p class="rating">⭐ 5.0 &nbsp; 💲$65.00/hr &nbsp; 📌 14 jobs</p>
        <p class="testimonial">
            “GigEco has enabled me to <b>increase my rates</b>. I know what I'm bringing to the table and love the feeling 
            of being able to help a variety of <b>clients</b>.”
        </p>
        <div class="navigation">
            <span class="nav-arrow">&#8592;</span>
            <span class="nav-arrow">&#8594;</span>
        </div>
    </div>
</div>

</body>
</html>
