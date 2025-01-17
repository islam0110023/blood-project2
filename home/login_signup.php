<?php
session_start();
require_once('../database/database.php');
$db = db::getInstance('localhost', 'root', '', 'blood_donation', 'reg');

if (isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];
    $db->setTable("reg");
    $result = $db->select()->where("emails", "=", $email)->get();
    if ($result == null) {
        echo "<script>
    alert('Transaction failed: " . addslashes("email error") . "');
        </script>";
    } else {
        if ($result['Password'] === $password && $result['Role'] == 2) {
            $_SESSION['user'] = $result;
            header("location:index.php");
        } else if ($result['Password'] === $password && $result['Role'] == 3) {
            $_SESSION['hospital'] = $result;
            header("location:../hospital/hospitals.php");
        } else {
            echo "<script>
alert('Transaction failed: " . addslashes("password error") . "');
    </script>";
        }
    }
}

if (isset($_POST['submit'])) {
    try {
        $db->beginTransaction();
        $db->setTable("reg");
        $db->insert([
            "user_names" => $_POST['userName'],
            "emails" => $_POST['signupEmail'],
            "password" => $_POST['signupPassword'],
            "role" => "2"
        ])->excute();
        $reg_id = $db->getConnection()->insert_id;
        $db->setTable("users");
        $db->insert([
            "reg_id" => $reg_id,
            "first_name" => $_POST['firstName'],
            "last_name" => $_POST['lastName'],
            "phone_Num" => $_POST['phone'],
            "location" => $_POST['location'],
            "blood_type_id" => $_POST['bloodGroup']

        ])->excute();
        $db->commit();
    } catch (Exception $e) {
        $db->rollback();
        // echo "<script> alert('";
        // echo "Transaction failed: " . $e->getMessage();
        // echo "');</script";
        //echo "<script> alert('Transaction failed: " . $e->getMessage() . "');  </script>";
        echo "<script>
        alert('Transaction failed: " . addslashes($e->getMessage()) . "');
                </script>";


        // echo "<script>alert('Transaction failed: error');</script>";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - Blood Donation System</title>
    <link rel="stylesheet" href="login_signup.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <h2>Blood Donation</h2>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="donor.php">Donor List</a></li>
            <li><a href="../admin/admin.php">Admin</a></li>
            <li><a href="login_signup.php">Login/ Sign Up</a></li>
        </ul>
    </div>

    <!-- Auth Container -->
    <div class="auth-container">
        <!-- Login Form -->
        <div class="auth-form" id="loginForm">
            <h2>Login</h2>
            <form id="loginFormContent" action="login_signup.php" method="post">
                <label for="loginEmail">Email:</label>
                <input type="email" id="loginEmail" name="loginEmail" placeholder="Enter your email" required>

                <label for="loginPassword">Password:</label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter your password"
                    required>

                <button type="submit" name="login">Login</button>
            </form>
            <p>Don't have an account? <a href="#" id="showSignupForm">Sign Up</a></p>
        </div>

        <!-- Sign Up Form -->
        <div class="auth-form" id="signupForm" style="display: none;" onsubmit="return validateForm()">
            <h2>Sign Up</h2>
            <form id="signupFormContent" method="post" action="login_signup.php">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>

                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName" placeholder="Enter your user name" required>

                <label for="signupEmail">Email:</label>
                <input type="email" id="signupEmail" name="signupEmail" placeholder="Enter your email" required>

                <label for="signupPassword">Password:</label>
                <input type="password" id="signupPassword" name="signupPassword" placeholder="Enter your password"
                    required>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password"
                    required>
                <p id="errorMessage" class="error" style="color: red;"></p>
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

                <label for="bloodGroup">Blood Group:</label>
                <select id="bloodGroup" name="bloodGroup" required>
                    <option value="">Select your blood group</option>
                    <option value="1">A+</option>
                    <option value=2>A-</option>
                    <option value=3>B+</option>
                    <option value=4>B-</option>
                    <option value=5>AB+</option>
                    <option value=6>AB-</option>
                    <option value=7>O+</option>
                    <option value=8>O-</option>
                </select>

                <!-- <label for="healthStatus">Health Status:</label>
                <textarea id="healthStatus" name="healthStatus" rows="4"
                    placeholder="Describe your current health condition" required></textarea> -->

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Enter your location" required>

                <button type="submit" name="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="#" id="backToLogin">Login</a></p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <!-- Contact Us Section -->
        <div id="contact" class="contact-section">
            <h2>Contact Us</h2>
            <p>Feel free to reach us through any of the following platforms</p>
            <div class="contact-icons">
                <a href="https://facebook.com" target="_blank" class="icon">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://wa.me/yourwhatsappnumber" target="_blank" class="icon">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="mailto:youremail@example.com" target="_blank" class="icon">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="icon">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="icon">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
        <p>&copy; 2024 Blood Donation System. All rights reserved For The Organization.</p>
    </footer>

    <script>
        // JavaScript for form switching
        const loginForm = document.getElementById("loginForm");
        const signupForm = document.getElementById("signupForm");

        document.getElementById("showSignupForm").addEventListener("click", () => {
            loginForm.style.display = "none";
            signupForm.style.display = "block";
        });

        document.getElementById("backToLogin").addEventListener("click", () => {
            signupForm.style.display = "none";
            loginForm.style.display = "block";
        });
        function validateForm() {
            const signupPassword = document.getElementById("signupPassword").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            const errorMessage = document.getElementById("errorMessage");

            // Reset the error message
            errorMessage.textContent = "";

            if (signupPassword !== confirmPassword) {
                errorMessage.textContent = "Passwords do not match. Please try again.";
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>

</body>

</html>