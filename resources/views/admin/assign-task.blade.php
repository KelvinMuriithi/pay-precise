@extends('master')

@section('content')
<div class="container">
    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tasks.store') }}" method="POST" id="createTaskForm">
                        @csrf
                        <div class="mb-3">
                            <label for="task_name" class="form-label">Task Name</label>
                            <input type="text" name="task_name" class="form-control" id="task_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="task_description" class="form-label">Task Description</label>
                            <textarea name="task_description" class="form-control" id="task_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Assign to Employee</label>
                            <select name="emp_id" class="form-select" id="employee_id" required>
                                <option value="" selected disabled>Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" class="form-select" id="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" id="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" id="end_date">
                        </div>
                        <input type="hidden" name="status" value="Pending">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h1>Tasks</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                Create Task
            </button>
        </div>
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Assigned To</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->task_description }}</td>
                            <td>{{ $task->emp_id??'N/A' }}</td> <!-- Assuming the employee has a fullname field -->
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->status }}</td>
                            <td>
                               <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
