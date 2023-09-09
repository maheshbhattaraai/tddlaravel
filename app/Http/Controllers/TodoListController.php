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

   public function store(Request $request){

     $this->validate($request,[
          'name'=>'required|string|max:200',
     ]);
     $result = TodoList::create(['name'=>$request->name]);
     return response()->json($result,201);
   }
}
