<!DOCTYPE html>
<html>
<head>
    <title>Attendance Warning</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Low Attendance Warning</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>IC Number</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lowAttendanceStudents as $student)
                    @if ($student->present == 2)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->ic_number }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->date }}</td>
                            <td>Rejected Absence Proof</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
