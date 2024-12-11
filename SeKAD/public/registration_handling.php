<?php
// Include database connection file
include("db_connection.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash password
    $mobilenumber = $_POST['mobilenumber'];
    $emergencymobilenumber = $_POST['emergencymobilenumber'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $ic_number = $_POST['ic_number'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $fname = $_POST['fname'];
    $fcontact = $_POST['fcontact'];
    $foccupation = $_POST['foccupation'];
    $mname = $_POST['mname'];
    $mcontact = $_POST['mcontact'];
    $moccupation = $_POST['moccupation'];
    $gname = $_POST['gname'];
    $gcontact = $_POST['gcontact'];
    $goccupation = $_POST['goccupation'];
    $blood_type = $_POST['blood_type'];
    $allergies = $_POST['allergies'];

    // Handle file upload for avatar
    $avatar = 'default.png'; // Default avatar if no file is uploaded
    if (!empty($_FILES['avatar']['name'])) {
        $upload_dir = 'img/';
        $avatar_name = time() . '_' . basename($_FILES['avatar']['name']);
        $target_file = $upload_dir . $avatar_name;

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (in_array($_FILES['avatar']['type'], $allowed_types)) {
            // Move the uploaded file
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
                $avatar = $avatar_name; // Save the new file name
            } else {
                echo "Error uploading avatar. Using default avatar instead.";
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, JPG, and GIF files are allowed.";
        }
    }

    // Prepare and execute the SQL query securely
    $sql = "INSERT INTO users 
            (name, email, password, mobilenumber, emergencymobilenumber, date_of_birth, gender, role, ic_number, nationality, address, fname, fcontact, foccupation, mname, mcontact, moccupation, gname, gcontact, goccupation, blood_type, allergies, avatar) 
            VALUES 
            (:name, :email, :password, :mobilenumber, :emergencymobilenumber, :date_of_birth, :gender, :role, :ic_number, :nationality, :address, :fname, :fcontact, :foccupation, :mname, :mcontact, :moccupation, :gname, :gcontact, :goccupation, :blood_type, :allergies, :avatar)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':mobilenumber' => $mobilenumber,
            ':emergencymobilenumber' => $emergencymobilenumber,
            ':date_of_birth' => $date_of_birth,
            ':gender' => $gender,
            ':role' => $role,
            ':ic_number' => $ic_number,
            ':nationality' => $nationality,
            ':address' => $address,
            ':fname' => $fname,
            ':fcontact' => $fcontact,
            ':foccupation' => $foccupation,
            ':mname' => $mname,
            ':mcontact' => $mcontact,
            ':moccupation' => $moccupation,
            ':gname' => $gname,
            ':gcontact' => $gcontact,
            ':goccupation' => $goccupation,
            ':blood_type' => $blood_type,
            ':allergies' => $allergies,
            ':avatar' => $avatar,
        ]);

        // Redirect to login page with success message
        header("Location: login.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
