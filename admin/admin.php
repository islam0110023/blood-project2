<?php
require_once('../database/database.php');
$db = db::getInstance('localhost', 'root', '', 'blood_donation', 'reg');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $db->setTable("reg");
    $result = $db->select()->where("emails", "=", $email)->get();
    // $result1=$db->select()->where("password","=","$password")->get();
    // echo "<pre>";
    // print_r($result);

}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Blood Donation System</title>
    <link rel="stylesheet" href="admin.css">

</head>

<body>

    <!-- Login Screen -->
    <div class="login-screen">
        <div class="login-box">

            <h2>Enter </h2>
            <input type="text" id="username" placeholder="username" name="email" />
            <input type="password" id="password" placeholder="password" name="password" />
            <button onclick="login()">Login </button>

        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu-btn" onclick="toggleSidebar()">☰</div>
        <h2>Blood Donation Admin</h2>
        <ul>
            <li><a href="#" onclick="showDashboard()">Dashboard</a></li>
            <li><a href="manage_hos.php">Manage Hospitals</a></li>
            <li><a href="manage_donors.php">Manage Donors</a></li>
            <li><a href="register_hospital.php">Regiser For Hospitals</a></li>
            <li><a href="../home/index.php">Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome, Admin!</h1>
        <div class="dashboard">
            <div class="card">
                <h3>Total Donors</h3>
                <p id="donors-count">0</p> <!-- Total number of donors -->
            </div>
            <div class="card">
                <h3>Total Hospitals</h3>
                <p id="hospitals-count">0</p> <!-- Total number of hospitals -->
            </div>
            <div class="card">
                <h3>Total Blood Types Available</h3>
                <p id="blood-types-count">0</p> <!-- Total number of blood types -->
            </div>
        </div>
    </div>

    <script>

        function login() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === "admin" && password === "admin") {
                document.querySelector('.login-screen').style.display = 'none';
                document.querySelector('.sidebar').style.display = 'block';
                document.querySelector('.main-content').style.display = 'block';
            } else {
                alert(' THE USERNAME OR PASSWORD IS WRONG');
            }
        }
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const menuList = document.querySelector('.sidebar ul');
            sidebar.classList.toggle('active');
            menuList.classList.toggle('active');
        }
        function showDashboard() {
            document.querySelector('.main-content').style.display = 'block';
        }
    </script>

    <script src="script.js"></script>

</body>

</html>