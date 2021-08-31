<?php

namespace App\Http\Controllers;

use App\Models\register;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function addTask(Request $req)
    {
        $task = new Task();
        $task->user_id = $req->input('user_id');

        $task->task = $req->input('task');
        $task->save();
        
        return response()->json(['task'=>$req->input('task'),
                                 'status' => '1',
                                 'message' => 'successfully created a task' 
        ]);
    }

    public function showtable()
    {
        return Task::all();
    }

    public function showregister()
    {
        return register::all();
    }

    public function updateTask(Request $req)
    {
        if($req->input('status')== 'DONE' || $req->input('status') == 'done')
        {
            $taskname = Task::where('id',$req->input('task_id'))->first('task');
            Task::where('id',$req->input('task_id'))->update([
                'status' => $req->input('status')
            ]);
            return response()->json(['task'=>$taskname['task'],
                                    'status' => '1',
                                    'message' => 'Marked task as done' 
            ]);
        }
        elseif($req->input('status')== 'PENDING' || $req->input('status') == 'pending')
        {
            $taskname = Task::where('id',$req->input('task_id'))->first('task');
            Task::where('id',$req->input('task_id'))->update([
                'status' => 'pending'
            ]);
            return response()->json(['task'=>$taskname['task'],
                                    'status' => '1',
                                    'message' => 'Marked task as pending' 
            ]);
        }
        else{
            $taskname = Task::where('id',$req->input('task_id'))->first('task');
            // Task::where('id',$req->input('task_id'))->update([
            //     'status' => 'pending'
            // ]);
            return response()->json(['task'=>$taskname['task'],
                                    'status' => '1',
                                    'message' => 'False status' 
            ]);
        }
        
    }
}
