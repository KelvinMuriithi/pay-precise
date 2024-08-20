<?php

namespace App\Http\Controllers\Admin;
use App\Models\EmployeeDetail;
use App\Models\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Display a listing of tasks
    public function index()
    {
        $tasks = Task::all();
        $employees = EmployeeDetail::all();
        return view('admin.assign-task', compact('tasks', 'employees'));
    }

    // Show the form for creating a new task
    public function create()
    {
        $employees = Employee::all(); // Assuming you have an Employee model
        return view('tasks.create', compact('employees'));
    }

    // Store a newly created task in the database
    public function store(Request $request)
    {
        //  $request->validate([
        //      'task_name' => 'required|string|max:255',
        //      'task_description' => 'nullable|string',
        //      'emp_id' => 'required|exists:employee_details,id',
        //     //  'priority' => 'required|in:Low,Medium,High',
        //     //  'start_date' => 'required|date',
        //     //  'end_date' => 'nullable|date|after_or_equal:start_date',
        //      'status' => 'required|in:Pending,In Progress,Completed',
        //  ]);

        $task = Task::create($request->all());
        // dd($task);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // Display the specified task
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Show the form for editing the specified task
    public function edit(Task $task)
    {
        $employees = Employee::all(); // Assuming you have an Employee model
        return view('tasks.edit', compact('task', 'employees'));
    }

    // Update the specified task in the database
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'employee_id' => 'required|exists:employees,id',
            'priority' => 'required|in:Low,Medium,High',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Remove the specified task from the database
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function myTasks()
    {
        $employee = auth()->user()->employeeDetail; 
        // dd($employee);
        $tasks = Task::where('emp_id', $employee->emp_id)->get();

        return view('employee.task', compact('tasks'));
    }
}
