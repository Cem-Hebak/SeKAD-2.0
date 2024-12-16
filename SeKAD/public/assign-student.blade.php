
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Assign Students to Classes</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('assign-student.submit') }}" method="POST">
        @csrf

        <!-- Select Year -->
        <div class="mb-3">
            <label for="year" class="form-label">Select Year</label>
            <select id="year" name="year" class="form-select" required onchange="filterStudents(this.value)">
                <option value="" disabled selected>Select Year</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">Year {{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Select Student -->
        <div class="mb-3">
            <label for="student_id" class="form-label">Select Student</label>
            <select id="student_id" name="student_id" class="form-select" required>
                <option value="" disabled selected>Select a student</option>
                @foreach ($students as $year => $group)
                    @foreach ($group as $student)
                        <option data-year="{{ $year }}" value="{{ $student->id }}">
                            {{ $student->name }} (DOB: {{ $student->dob }})
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>

        <!-- Select Class -->
        <div class="mb-3">
            <label for="class" class="form-label">Assign Class</label>
            <select id="class" name="class" class="form-select" required>
                <option value="" disabled selected>Select Class</option>
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
