<?php
    include("db_connection.php");

    if (isset($_POST['import'])) {
        $fileName = $_FILES['excel']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedType = ['xls', 'xlsx', 'csv'];

        if (in_array($fileExtension, $allowedType)) {
            $targetPath = 'uploads/' . basename($fileName);
            move_uploaded_file($_FILES['excel']['tmp_name'], $targetPath);

            require 'excelReader/excel_reader2.php';
            require 'excelReader/SpreadsheetReader.php';

            try {
                $reader = new SpreadsheetReader($targetPath);
                foreach ($reader as $key => $row) {
                    if ($key === 0) continue; // Skip header row

                    if (empty(array_filter($row))) {
                        continue; // Skip empty rows
                    }

                    // Log the current row for debugging
                    error_log(print_r($row, true));

                    $name = $row[0] ?? null;
                    $email = $row[1] ?? null;
                    $mobilenumber = $row[2] ?? null;
                    $emergencymobilenumber = $row[3] ?? null;
                    $role = $row[4] ?? null;
                    $class = $row[5] ?? null;
                    $date_of_birth = $row[6] ?? null;
                    $gender = $row[7] ?? null;
                    $ic_number = $row[8] ?? null;
                    $nationality = $row[9] ?? null;
                    $address = $row[10] ?? null;
                    $fname = $row[11] ?? null;
                    $fcontact = $row[12] ?? null;
                    $foccupation = $row[13] ?? null;
                    $mname = $row[14] ?? null;
                    $mcontact = $row[15] ?? null;
                    $moccupation = $row[16] ?? null;
                    $gname = $row[17] ?? null;
                    $gcontact = $row[18] ?? null;
                    $goccupation = $row[19] ?? null;
                    $blood_type = $row[20] ?? null;
                    $allergies = $row[21] ?? null;

                    $generatedPassword = '1234567890';
                    $hashedPassword = password_hash($generatedPassword, PASSWORD_BCRYPT);

                    $stmt = $pdo->prepare("
                        INSERT INTO users 
                        (name, email, mobilenumber, emergencymobilenumber, role, class, date_of_birth, gender, ic_number, nationality, address, fname, fcontact, foccupation, mname, mcontact, moccupation, gname, gcontact, goccupation, blood_type, allergies, password) 
                        VALUES 
                        (:name, :email, :mobilenumber, :emergencymobilenumber, :role, :class, :date_of_birth, :gender, :ic_number, :nationality, :address, :fname, :fcontact, :foccupation, :mname, :mcontact, :moccupation, :gname, :gcontact, :goccupation, :blood_type, :allergies, :password)
                    ");
                    $stmt->execute([
                        ':name' => $name,
                        ':email' => $email,
                        ':mobilenumber' => $mobilenumber,
                        ':emergencymobilenumber' => $emergencymobilenumber,
                        ':role' => $role,
                        ':class' => $class,
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
                        ':password' => $hashedPassword,
                    ]);
                }
                echo "<script>alert('Data Imported Successfully'); window.location.href = 'register.php';</script>";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<script>alert('Invalid file type'); window.location.href = 'register.php';</script>";
        }
    }

    // Handle manual form submission
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $ic_number = $_POST['ic_number'];
        $password = $_POST['password'];
        $mobilenumber = $_POST['mobilenumber'];
        $emergencymobilenumber = $_POST['emergencymobilenumber'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];
        $address = $_POST['address'];
        $role = $_POST['role'];
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

        // Handle profile picture upload
        // $avatarPath = null;
        // if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        //     $avatarPath = 'uploads/' . basename($_FILES['avatar']['name']);
        //     move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
        // }

        $generatedPassword = '1234567890';
        $hashedPassword = password_hash($generatedPassword, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
            INSERT INTO users 
            (name, email, ic_number, password, mobilenumber, emergencymobilenumber, date_of_birth, gender, nationality, address, role, fname, fcontact, foccupation, mname, mcontact, moccupation, gname, gcontact, goccupation, blood_type, allergies) 
            VALUES 
            (:name, :email, :ic_number, :password, :mobilenumber, :emergencymobilenumber, :date_of_birth, :gender, :nationality, :address, :role, :fname, :fcontact, :foccupation, :mname, :mcontact, :moccupation, :gname, :gcontact, :goccupation, :blood_type, :allergies)
        ");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':ic_number' => $ic_number,
            ':password' => $hashedPassword,
            ':mobilenumber' => $mobilenumber,
            ':emergencymobilenumber' => $emergencymobilenumber,
            ':date_of_birth' => $date_of_birth,
            ':gender' => $gender,
            ':nationality' => $nationality,
            ':address' => $address,
            ':role' => $role,
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
        ]);

        echo "<script>alert('Registration Successful'); window.location.href = 'register.php';</script>";
    }
?>
