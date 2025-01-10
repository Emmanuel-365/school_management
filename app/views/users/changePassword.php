<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="dashboard">

        <div class="content">

            <div class="dashboard-content">
                <h1>Change Password</h1>
                <form>
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" placeholder="Enter your current password" required>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" placeholder="Enter a new password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" placeholder="Re-enter your new password" required>
                    </div>
                    <div class="form-group center">
                        <button type="submit"><i class="fas fa-key"></i> Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FontAwesome Icons (Include via CDN or locally) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>
