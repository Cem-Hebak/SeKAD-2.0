document.addEventListener('DOMContentLoaded', function () {
    const studentTable = document.getElementById("studentTable");
    const studentTableBody = studentTable.querySelector("#studentTable tbody");
    const submitButton = document.getElementById("submit-attendance");

    function fetchStudents() {
        
        console.log("Fetching students...");
        fetch("getStudent.php")
            .then((response) => {
                console.log("Response:", response);
                if (!response.ok) {
                    throw new Error("Failed to fetch students");
                }
                return response.json();
            })
            .then((students) => {
                console.log("Students data:", students);
                populateTable(students);
            })
            .catch((error) => {
                console.error("Error fetching students:", error);
            });
    }

    // Populate the table with students
    function populateTable(students) {
        console.log("Populating table with students"); 
        studentTableBody.innerHTML = ""; // Clear any existing rows
        students.forEach((student) => {
            const row = document.createElement("tr");

            const checkboxCell = document.createElement("td");
            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.name = "studentCheckbox";
            checkbox.value = student.id;
            checkboxCell.appendChild(checkbox);

            const nameCell = document.createElement("td");
            nameCell.textContent = student.name;

            const icNumberCell = document.createElement("td");
            icNumberCell.textContent = student.ic_number;

            row.appendChild(checkboxCell);
            row.appendChild(nameCell);
            row.appendChild(icNumberCell);

            studentTableBody.appendChild(row);
        });
    }

    // Submit attendance
    submitButton.addEventListener("click", function () {
        const checkboxes = studentTableBody.querySelectorAll(
            "input[name='studentCheckbox']:checked"
        );
        const attendance = Array.from(checkboxes).map((checkbox) => ({
            id: checkbox.value,
        }));

        console.log("Submitting attendance:", attendance); // Log selected students for debugging

        fetch("submitAttendance.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(attendance),
        })
            .then((response) => {
                console.log("Submit Response:", response); // Log the response for debugging
                if (!response.ok) {
                    throw new Error("Failed to submit attendance");
                }
                return response.text();
            })
            .then((result) => {
                console.log("Attendance submission result:", result); // Log the result for debugging
                alert("Attendance submitted successfully!");
            })
            .catch((error) => {
                console.error("Error submitting attendance:", error);
            });
    });

    // Initial fetch of students
    fetchStudents();
});
