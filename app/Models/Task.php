<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'task_description',
        'emp_id',
        'priority',
        'start_date',
        'end_date',
        'status'
    ];

    public function employeeDetail()
    {
        return $this->belongsTo(EmployeeDetail::class);
    }
}
