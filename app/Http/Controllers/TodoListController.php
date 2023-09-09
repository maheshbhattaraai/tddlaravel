<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
   public function index(){
        $lists = TodoList::all();
        return response()->json($lists);
   }

   public function show(TodoList $list){
        return response()->json($list);
   }
}
