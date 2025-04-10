<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function index(): View
    {
        $tasks = Task::paginate(10);

        return view('welcome', compact('tasks'));
    }

}
