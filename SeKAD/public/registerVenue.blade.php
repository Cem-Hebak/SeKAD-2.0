<?php
session_start(); // Start the session
include('db_connection.php'); // Include database connection

    
 $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');


?>
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
    <h2>SeKAD Register New Venue</h2>
    <p>Please fill in the form to create a venue.</p>
    <form class="form-container" action="RegisterVenueHandling.blade.php" method="POST" enctype="multipart/form-data">
        <style>
            .form-container {
                max-width: 600px;
                margin: 0 auto;
                font-family: Arial, sans-serif;
            }

            .form-column {
                margin-bottom: 20px;
            }

            h3 {
                font-size: 1.5em;
                margin-bottom: 15px;
                text-align: center;
            }

            label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }

            input[type="text"], input[type="number"], input[type="file"], select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
                font-size: 14px;
            }

            .facility-item {
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            .facility-item label {
                font-weight: normal;
            }

            .btn-register {
                background-color: #007bff;
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-align: center;
                width: 100%;
            }

            .btn-register:hover {
                background-color: #0056b3;
            }

            .remove-facility {
                background-color: #dc3545;
                color: white;
                margin-top: 10px;
            }

            .remove-facility:hover {
                background-color: #c82333;
            }

            .full-width {
                width: 100%;
            }
        </style>

        <!-- Venue Details -->
        <div class="form-column">
            <h3>Venue Details</h3>
            <label for="venue_name">Venue Name:</label>
            <input type="text" id="venue_name" name="venue_name" required>

            <label for="venue_picture">Venue Picture:</label>
            <input type="file" id="venue_picture" name="venue_picture" accept=".jpg, .jpeg, .png" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" min="1" placeholder="Enter maximum capacity" required>
        </div>

        <!-- Facilities Section -->
        <div class="form-column">
            <h3>Facilities</h3>
            <div id="facility-list">
                <!-- Facility Item Template -->
                <div class="facility-item">
                    <label for="facility_name[]">Facility:</label>
                    <select name="facility_name[]" class="facility-dropdown" onchange="toggleOtherFacilityInput(this)" required>
                        <option value="" disabled selected>Select a facility</option>
                        <option value="Computer">Computer</option>
                        <option value="Projector">Projector</option>
                        <option value="Smart Whiteboard">Smart Whiteboard</option>
                        <option value="Others">Others</option>
                    </select>

                    <label for="facility_quantity[]">Quantity:</label>
                    <input type="number" name="facility_quantity[]" placeholder="e.g., 30" min="1" required>

                    <!-- Input for 'Others' -->
                    <div class="other-facility-container" style="display: none;">
                        <label for="other_facility_name[]">Specify Facility:</label>
                        <input type="text" name="other_facility_name[]" placeholder="Specify the facility">
                    </div>

                    <!-- <button type="button" class="remove-facility" onclick="removeFacilityField(this)">Remove Facility</button> -->
                    <button type="button" class="remove-facility btn-register" onclick="removeFacilityField(this)">Remove</button>
                </div>
            </div>
            <button type="button" id="add-facility" class="btn-register" onclick="addFacilityField()">Add Facility</button>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-register full-width">Register</button>
    </form>

    <script>
        // Function to toggle the input field for 'Others' facility name
        function toggleOtherFacilityInput(select) {
            var otherFacilityContainer = select.closest('.facility-item').querySelector('.other-facility-container');
            if (select.value === 'Others') {
                otherFacilityContainer.style.display = 'block';
            } else {
                otherFacilityContainer.style.display = 'none';
            }
        }

        // Function to add new facility input fields
        function addFacilityField() {
            var facilityList = document.getElementById('facility-list');
            var newFacilityItem = document.createElement('div');
            newFacilityItem.classList.add('facility-item');
            newFacilityItem.innerHTML = `
                <label for="facility_name[]">Facility:</label>
                <select name="facility_name[]" class="facility-dropdown" onchange="toggleOtherFacilityInput(this)" required>
                    <option value="" disabled selected>Select a facility</option>
                    <option value="Computer">Computer</option>
                    <option value="Projector">Projector</option>
                    <option value="Smart Whiteboard">Smart Whiteboard</option>
                    <option value="Others">Others</option>
                </select>

                <label for="facility_quantity[]">Quantity:</label>
                <input type="number" name="facility_quantity[]" placeholder="e.g., 30" min="1" required>

                <div class="other-facility-container" style="display: none;">
                    <label for="other_facility_name[]">Specify Facility:</label>
                    <input type="text" name="other_facility_name[]" placeholder="Specify the facility">
                </div>

                
                <button type="button" class="remove-facility btn-register" onclick="removeFacilityField(this)">Remove</button>
            `;
            facilityList.appendChild(newFacilityItem);
        }

        // Function to remove a facility input field
        function removeFacilityField(button) {
            var facilityItem = button.closest('.facility-item');
            facilityItem.remove();
        }
    </script>
    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en', // Default language of your website
            includedLanguages: 'en,ms', // Languages to include (English and Bahasa Melayu)
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>


