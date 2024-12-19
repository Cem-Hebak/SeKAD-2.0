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
?>
