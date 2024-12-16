<!DOCTYPE html>
<html>
<head>
    <title>Low Attendance Alert</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Low Attendance Alert</h1>
        @if ($lowAttendanceStudents->isEmpty())
            <div class="alert alert-success text-center">
                <strong>All students have attendance above 75%!</strong>
            </div>
        @else
            <div class="alert alert-danger text-center">
                <strong>Warning:</strong> The following students have attendance below 75%:
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>IC Number</th>
                        <th>Class</th>
                        <th>Attendance (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lowAttendanceStudents as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->ic_number }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->attendance_percentage }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
