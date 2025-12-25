<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['work_type'])) {
    $_SESSION['client_q1'] = $_POST['work_type'];
    header("Location: client_q2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Questionnaire 1</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Copy-paste same styles you used for q1.html */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0fff0;
            margin: 0;
            padding: 0;
            text-align: center;
            font-size: 22px;
        }

        header {
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            font-size: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .logo { color: darkgreen; font-weight: bold; }
        .user-icon { font-size: 32px; color: black; text-decoration: none; cursor: pointer; }

        .container {
            width: 80%;
            margin: 80px auto;
            padding: 50px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .options {
            display: flex;
            justify-content: space-around;
            margin: 50px 0;
        }

        .option {
            padding: 30px;
            border-radius: 20px;
            background: #fff;
            font-size: 26px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s ease;
        }

        .option img {
            width: 180px;
            height: 180px;
            margin-bottom: 20px;
        }

        .option input { display: none; }
        .option.selected {
            border: 3px solid darkgreen;
            background-color: #e6ffe6;
            box-shadow: 0 5px 20px rgba(0,128,0,0.6);
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 80px;
        }

        button {
            padding: 18px 35px;
            font-size: 24px;
            font-weight: bold;
            background-color: #90ee90;
            border: none;
            border-radius: 12px;
            cursor: pointer;
        }

        .next:disabled {
            background-color: lightgray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">GigEco</div>
        <a href="profile.html"><div class="user-icon">&#128100;</div></a>
    </header>

    <main>
        <p class="step">1/3</p>
        <h1>What type of work do you usually post?</h1>
        <p class="subtext">This helps us better understand your needs as a client.</p>

        <form method="POST">
            <div class="options">
                <label class="option" onclick="enableNext(this)">
                    <input type="radio" name="work_type" value="short-term">
                    <div class="content">
                        <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" alt="Short-term">
                        <p>Short-term projects</p>
                    </div>
                </label>

                <label class="option" onclick="enableNext(this)">
                    <input type="radio" name="work_type" value="long-term">
                    <div class="content">
                        <img src="https://cdn-icons-png.flaticon.com/512/2933/2933826.png" alt="Long-term">
                        <p>Long-term collaborations</p>
                    </div>
                </label>

                <label class="option" onclick="enableNext(this)">
                    <input type="radio" name="work_type" value="one-time">
                    <div class="content">
                        <img src="https://cdn-icons-png.flaticon.com/512/3820/3820330.png" alt="One-time">
                        <p>One-time tasks</p>
                    </div>
                </label>
            </div>

            <div class="buttons">
                <a href="q.html"><button type="button">Back</button></a>
                <a href="profile.html"><button type="button">Skip</button></a>
                <button class="next" id="nextBtn" type="submit" disabled>Next</button>
            </div>
        </form>
    </main>

    <script>
        function enableNext(selectedOption) {
            document.getElementById("nextBtn").removeAttribute("disabled");
            let options = document.querySelectorAll(".option");
            options.forEach(option => option.classList.remove("selected"));
            selectedOption.classList.add("selected");
            selectedOption.querySelector("input").checked = true;
        }
    </script>
</body>
</html>
