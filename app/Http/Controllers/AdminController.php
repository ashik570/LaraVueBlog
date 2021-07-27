<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class AdminController extends Controller
{
    public function addTag(Request $request){
        // Validation
        $this->validate($request, [
            'tagName' => 'required'
        ]);

        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function editTag(Request $request){
        // Validation
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required'
        ]);

        return Tag::where('id',$request->id)->update([
            'tagName' => $request->tagName
        ]);
    }

    public function deleteTag(Request $request){
        // Validation
        $this->validate($request, [
            'id' => 'required'
        ]);

        return Tag::where('id',$request->id)->delete();
    }

    public function getTag(){
        return Tag::orderBy('id','desc')->get();
    }
}
