<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user()->tasks()->get();

        $tasks = TaskResource::collection($user);

        return response()->json([
            'message' => 'success',
            'data' => $tasks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $tasks = $request->user()->tasks()->create($request->validated());

        $task =  TaskResource::make($tasks);
        return response()->json([
            'message' => 'success',
            'data' => $task
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task = TaskResource::make($task);

        try {
            if ($task != null) {
                return response()->json([
                    'message' => 'success',
                    'data' => $task
                ], 200);
            } else {
                return response()->json([
                    'message' => 'error',
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'server error',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'succes is deleted data'
        ]);
    }
}
