<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance'; // Link to the table
    protected $fillable = ['user_id', 'name', 'ic_number', 'date', 'present', 'class'];

    /**
     * Query scope to fetch students with low attendance (<75%) in a given month.
     */
    public function scopeLowAttendance($query, $month)
    {
        return $query->select('user_id', 'name', 'ic_number', 'class')
            ->selectRaw("ROUND((SUM(CASE WHEN present = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage")
            ->whereMonth('date', $month)
            ->groupBy('user_id', 'name', 'ic_number', 'class')
            ->having('attendance_percentage', '<', 75);
    }
}

