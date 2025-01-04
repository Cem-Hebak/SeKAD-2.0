<?php
session_start();
include("db_connection.php");

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve user ID from the session
$id = $_SESSION['id'] ?? null;

if (!$id) {
    die("Error: User ID is not set in the session.");
}

try {
    // Prepare the query using PDO
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $user_data = $stmt->fetch();

    if (!$user_data) {
        die("Error: User data not found.");
    }

    // Sanitize role to avoid XSS
    $role = htmlspecialchars($user_data['role'] ?? 'Guest', ENT_QUOTES, 'UTF-8');

    // Additional data sanitization
    foreach ($user_data as $key => $value) {
        $user_data[$key] = htmlspecialchars($value ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    }

} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}

// Use sanitized variables as needed
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="register-box">
        <h2>Update Profile</h2>
        
        

        
        <form class="form-container" action="update_profile.php" method="POST" enctype="multipart/form-data">
            <!-- User Details -->
            <div class="form-column">
                <h3>Personal Details</h3>
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="ic_number">IC Number:</label>
                <input type="text" id="ic_number" name="ic_number" value="<?php echo htmlspecialchars($user_data['ic_number'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="mobilenumber">Mobile Number:</label>
                <input type="text" id="mobilenumber" name="mobilenumber" value="<?php echo htmlspecialchars($user_data['mobilenumber'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="emergencymobilenumber">Emergency Mobile Number:</label>
                <input type="text" id="emergencymobilenumber" name="emergencymobilenumber" value="<?php echo htmlspecialchars($user_data['emergencymobilenumber'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($user_data['date_of_birth'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="" <?php echo empty($user_data['gender']) ? 'selected' : ''; ?>>Select Gender</option>
                    <option value="Male" <?php echo $user_data['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $user_data['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>

                <label for="nationality">Nationality:</label>
                <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($user_data['nationality'], ENT_QUOTES, 'UTF-8'); ?>" readonly>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user_data['address'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <?php if ($role === 'Staff'): ?>
                    <option value="Student" <?php echo $user_data['role'] === 'Student' ? 'selected' : ''; ?>>Student</option>
                    <option value="Teacher" <?php echo $user_data['role'] === 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                    <?php elseif ($role === 'Admin'): ?>
                    <option value="Staff" <?php echo $user_data['role'] === 'Staff' ? 'selected' : ''; ?>>Staff</option>
                    <option value="Admin" <?php echo $user_data['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    <?php endif; ?>
                </select>

                <h3>Family Details</h3>

                <label for="fname">Father's Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($user_data['fname'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="fcontact">Father's Contact Number:</label>
                <input type="text" id="fcontact" name="fcontact" value="<?php echo htmlspecialchars($user_data['fcontact'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="foccupation">Father's Occupation:</label>
                <input type="text" id="foccupation" name="foccupation" value="<?php echo htmlspecialchars($user_data['foccupation'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="mname">Mother's Name:</label>
                <input type="text" id="mname" name="mname" value="<?php echo htmlspecialchars($user_data['mname'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="mcontact">Mother's Contact Number:</label>
                <input type="text" id="mcontact" name="mcontact" value="<?php echo htmlspecialchars($user_data['mcontact'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="moccupation">Mother's Occupation:</label>
                <input type="text" id="moccupation" name="moccupation" value="<?php echo htmlspecialchars($user_data['moccupation'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="gname">Guardian's Name:</label>
                <input type="text" id="gname" name="gname" value="<?php echo htmlspecialchars($user_data['gname'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="gcontact">Guardian's Contact Number:</label>
                <input type="text" id="gcontact" name="gcontact" value="<?php echo htmlspecialchars($user_data['gcontact'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="goccupation">Guardian's Occupation:</label>
                <input type="text" id="goccupation" name="goccupation" value="<?php echo htmlspecialchars($user_data['goccupation'], ENT_QUOTES, 'UTF-8'); ?>">

                <h3>Additional Details</h3>
                <label for="blood_type">Blood Type:</label>
                <input type="text" id="blood_type" name="blood_type" value="<?php echo htmlspecialchars($user_data['blood_type'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="allergies">Allergies:</label>
                <input type="text" id="allergies" name="allergies" value="<?php echo htmlspecialchars($user_data['allergies'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-register full-width">Update Profile</button>
        </form>
    </div>
</body>
</html>
