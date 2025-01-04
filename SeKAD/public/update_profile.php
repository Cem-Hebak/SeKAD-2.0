<?php
session_start();
include("db_connection.php"); // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.blade.php");
    exit();
}

$id = $_SESSION['id']; // Get the logged-in user's ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get user data from POST or SESSION
        $name = htmlspecialchars($_POST['name'] ?? $_SESSION['name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'] ?? $_SESSION['email'], ENT_QUOTES, 'UTF-8');
        $mobilenumber = htmlspecialchars($_POST['mobilenumber'] ?? $_SESSION['mobilenumber'], ENT_QUOTES, 'UTF-8');
        $emergencymobilenumber = htmlspecialchars($_POST['emergencymobilenumber'] ?? $_SESSION['emergencymobilenumber'], ENT_QUOTES, 'UTF-8');
        $date_of_birth = htmlspecialchars($_POST['date_of_birth'] ?? $_SESSION['date_of_birth'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($_POST['gender'] ?? $_SESSION['gender'], ENT_QUOTES, 'UTF-8');
        $ic_number = htmlspecialchars($_POST['ic_number'] ?? $_SESSION['ic_number'], ENT_QUOTES, 'UTF-8');
        $nationality = htmlspecialchars($_POST['nationality'] ?? $_SESSION['nationality'], ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($_POST['address'] ?? $_SESSION['address'], ENT_QUOTES, 'UTF-8');
        $fname = htmlspecialchars($_POST['fname'] ?? $_SESSION['fname'], ENT_QUOTES, 'UTF-8');
        $fcontact = htmlspecialchars($_POST['fcontact'] ?? $_SESSION['fcontact'], ENT_QUOTES, 'UTF-8');
        $foccupation = htmlspecialchars($_POST['foccupation'] ?? $_SESSION['foccupation'], ENT_QUOTES, 'UTF-8');
        $mname = htmlspecialchars($_POST['mname'] ?? $_SESSION['mname'], ENT_QUOTES, 'UTF-8');
        $mcontact = htmlspecialchars($_POST['mcontact'] ?? $_SESSION['mcontact'], ENT_QUOTES, 'UTF-8');
        $moccupation = htmlspecialchars($_POST['moccupation'] ?? $_SESSION['moccupation'], ENT_QUOTES, 'UTF-8');
        $gname = htmlspecialchars($_POST['gname'] ?? $_SESSION['gname'], ENT_QUOTES, 'UTF-8');
        $gcontact = htmlspecialchars($_POST['gcontact'] ?? $_SESSION['gcontact'], ENT_QUOTES, 'UTF-8');
        $goccupation = htmlspecialchars($_POST['goccupation'] ?? $_SESSION['goccupation'], ENT_QUOTES, 'UTF-8');
        $blood_type = htmlspecialchars($_POST['blood_type'] ?? $_SESSION['blood_type'], ENT_QUOTES, 'UTF-8');
        $allergies = htmlspecialchars($_POST['allergies'] ?? $_SESSION['allergies'], ENT_QUOTES, 'UTF-8');

        // Validate required fields
        if (empty($name) || empty($email) || empty($mobilenumber) || empty($gender)) {
            $_SESSION['error'] = "Please fill in all required fields.";
            header("Location: editProfile.blade.php");
            exit();
        }

        // Update query using PDO
        $query = "UPDATE users SET 
            name = :name,
            email = :email,
            mobilenumber = :mobilenumber,
            emergencymobilenumber = :emergencymobilenumber,
            date_of_birth = :date_of_birth,
            gender = :gender,
            ic_number = :ic_number,
            nationality = :nationality,
            address = :address,
            fname = :fname,
            fcontact = :fcontact,
            foccupation = :foccupation,
            mname = :mname,
            mcontact = :mcontact,
            moccupation = :moccupation,
            gname = :gname,
            gcontact = :gcontact,
            goccupation = :goccupation,
            blood_type = :blood_type,
            allergies = :allergies
        WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':mobilenumber' => $mobilenumber,
            ':emergencymobilenumber' => $emergencymobilenumber,
            ':date_of_birth' => $date_of_birth,
            ':gender' => $gender,
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
            ':id' => $id
        ]);

        $_SESSION['success'] = "Profile updated successfully.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Failed to update profile: " . $e->getMessage();
    }

    header("Location: Profile.blade.php");
    exit();
}
?>
