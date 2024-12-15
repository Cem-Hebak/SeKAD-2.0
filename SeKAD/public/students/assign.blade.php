@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Students to Classes</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('students.assign') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="year">Select Year</label>
            <select id="year" name="year" class="form-control" onchange="filterStudents(this.value)">
                <option value="" selected disabled>Select Year</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">Year {{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="student_id">Select Student</label>
            <select id="student_id" name="student_id" class="form-control" required>
                <option value="" selected disabled>Select a student</option>
                @foreach ($students as $year => $group)
                    @foreach ($group as $student)
                        <option data-year="{{ $year }}" value="{{ $student->id }}">{{ $student->name }} (DOB: {{ $student->dob }})</option>
                    @endforeach
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="class">Assign Class</label>
            <select id="class" name="class" class="form-control" required>
                <option value="" selected disabled>Select Class</option>
                <option value="Pendeta">Pendeta</option>
                <option value="Cendekiawan">Cendekiawan</option>
                <option value="Intelek">Intelek</option>
                <option value="Sarjana">Sarjana</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Class</button>
    </form>
</div>

<script>
    function filterStudents(selectedYear) {
        const studentDropdown = document.getElementById('student_id');
        Array.from(studentDropdown.options).forEach(option => {
            if (option.dataset.year) {
                option.style.display = option.dataset.year == selectedYear ? 'block' : 'none';
            }
        });
        studentDropdown.value = '';
    }
</script>
@endsection
