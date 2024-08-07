<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    //buscar task por id
    public function find($id){
        return Task::findOrFail($id);
    }

    //listar todas las task
    public function all(){
        return Task::all();
    }
    


    //eliminar task
    public function delete($id){
        $task = Task::findOrFail($id);
        $task->delete();
        return $task;
    }
}
