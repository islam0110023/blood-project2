<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">
</head>

<body>
    <div id="app">
        <div id="login-prompt" class="hidden">
            <h1>Please Log In</h1>
            <p>You need to log in to access your profile.</p>
            <a href="login_signup.php" class="button">Go to Login</a>
        </div>

        <div id="profile-page" class="hidden">
            <h1>Welcome to Your Profile</h1>
            <form id="profile-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">

                <label for="blood-type">Blood Type:</label>
                <input type="text" id="blood-type" name="blood-type">

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone">

                <button type="button" id="donation-btn" class="not-available">Available for Donation</button>
            </form>
        </div>
    </div>

    <script>
        // Mock login state
        const loggedIn = false; // Change to true to simulate logged-in state

        const loginPrompt = document.getElementById('login-prompt');
        const profilePage = document.getElementById('profile-page');
        const donationBtn = document.getElementById('donation-btn');

        if (loggedIn) {
            profilePage.classList.remove('hidden');
        } else {
            loginPrompt.classList.remove('hidden');
        }

        donationBtn.addEventListener('click', () => {
            donationBtn.classList.toggle('available');
            donationBtn.textContent = donationBtn.classList.contains('available')
                ? 'Available for Donation'
                : 'Not Available for Donation';
        });
    </script>
</body>

</html>