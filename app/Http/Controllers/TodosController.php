<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Facades\Session;

class TodosController extends Controller
{
    /**
     * Index method.
     * This method returns all the todos
     * saved in the database
     *
     * @return void
     */
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view("todos")->with("todos", $todos);
    }

    public function save(Request $request)
    {
        // dd($request->all()); //die dump the request to view it on the browser more like echoing the result
        $todo = new Todo;
        $todo->todo = $request->task; //equate it to the column name
        $todo->save(); //call save on the todo instance
        Session::flash("success", "Task Added!");
        return redirect()->back(); //used to redirect the user back to the referring page don't omit the return keyword
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $todo = Todo::find($request->task_id);
        $todo->todo = $request->task;
        $todo->save();
        Session::flash("success", "Task Updated!");
        return redirect()->back();
    }

    public function delete($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        Session::flash("success", "Task Deleted!");
        return redirect()->back();
    }

    public function filter($filter)
    {
        // dd($filter);
        $todos = [];
        switch ($filter) {
            case "all":
                $todos = Todo::orderBy('created_at', 'desc')->get();
                break;
            case "active":
                $todos = DB::table('todos')->where('completed', 0)->orderBy('created_at', 'desc')->get();
                break;

            case "completed":
                $todos = DB::table('todos')->where('completed', 1)->orderBy('created_at', 'desc')->get();
                break;
        }
        Session::flash("success", "Showing only " . $filter . " tasks");
        return view("todos")->with("todos", $todos);
    }

    function completed($id)
    {
        $todo = Todo::find($id);
        $todo->completed = 1;
        $todo->save();
        Session::flash("success", "Task Completed!");
        return redirect()->back();
    }
}