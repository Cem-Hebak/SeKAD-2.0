<!-- include("db_connection.php"); -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>
        <p>Please fill in the form to create an account.</p>
        <form class="form-container" action="registration_handling.blade.php" method="POST" enctype="multipart/form-data">
            <!-- User Details -->
            <div class="form-column">
                <h3>Personal Details</h3>
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>

                <label for="ic_number">IC Number:</label>
                <input type="text" id="ic_number" name="ic_number" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="mobilenumber">Mobile Number:</label>
                <input type="text" id="mobilenumber" name="mobilenumber" required>

                <label for="emergencymobilenumber">Emergency Mobile Number:</label>
                <input type="text" id="emergencymobilenumber" name="emergencymobilenumber">

                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth">

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <label for="nationality">Nationality:</label>
                <input type="text" id="nationality" name="nationality" value="Malaysian" readonly>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address">

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                </select>
            </div>

            <!-- Family Details -->
            <div class="form-column">
                <h3>Family Details</h3>
                <label for="fname">Father's Name:</label>
                <input type="text" id="fname" name="fname">

                <label for="fcontact">Father's Contact:</label>
                <input type="text" id="fcontact" name="fcontact">

                <label for="foccupation">Father's Occupation:</label>
                <input type="text" id="foccupation" name="foccupation">

                <label for="mname">Mother's Name:</label>
                <input type="text" id="mname" name="mname">

                <label for="mcontact">Mother's Contact:</label>
                <input type="text" id="mcontact" name="mcontact">

                <label for="moccupation">Mother's Occupation:</label>
                <input type="text" id="moccupation" name="moccupation">

                <label for="gname">Guardian's Name:</label>
                <input type="text" id="gname" name="gname" value="Not Applicable">

                <label for="gcontact">Guardian's Contact:</label>
                <input type="text" id="gcontact" name="gcontact" value="Not Applicable">

                <label for="goccupation">Guardian's Occupation:</label>
                <input type="text" id="goccupation" name="goccupation" value="Not Applicable">
            </div>

            <!-- Other Details -->
            <div class="form-column">
                <h3>Additional Details</h3>
                <label for="blood_type">Blood Type:</label>
                <input type="text" id="blood_type" name="blood_type">

                <label for="allergies">Allergies:</label>
                <input type="text" id="allergies" name="allergies" value="None">

                <label for="avatar">Profile Picture:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-register full-width">Register</button>
        </form>
    </div>
</body>
</html>
