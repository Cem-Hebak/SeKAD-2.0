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

                $name = $row[0];
                $email = $row[1];
                $mobilenumber = $row[2];
                $emergencymobilenumber = $row[3];
                $role = $row[4];
                $class = $row[5];
                $date_of_birth = $row[6];
                $gender = $row[7];
                $ic_number = $row[8];
                $nationality = $row[9];
                $address = $row[10];
                $fname = $row[11];
                $fcontact = $row[12];
                $foccupation = $row[13];
                $mname = $row[14];
                $mcontact = $row[15];
                $moccupation = $row[16];
                $gname = $row[17];
                $gcontact = $row[18];
                $goccupation = $row[19];
                $blood_type = $row[20];
                $allergies = $row[21];

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
?>
