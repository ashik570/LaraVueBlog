<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;

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

    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'),$picName);
        return $picName;
    }

    public function deleteImage(Request $request){
        $fileName = $request->imageName;
        $filePath = public_path().'/uploads/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return 'done';
    }

    public function addCategory(Request $request){
        // Validation
        $this->validate($request, [
            'categoryName' => 'required',
            'categoryIconImage' => 'required'
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'categoryIconImage' => $request->categoryIconImage
        ]);
    }

    public function getCategory(){
        return Category::orderBy('id','desc')->get();
    }

    public function editCategory(Request $request){
        $this->validate($request, [
            'categoryName' => 'required',
            'categoryIconImage' => 'required'
        ]);

        return Category::where('id',$request->id)->update([
            'categoryName' => $request->categoryName,
            'categoryIconImage' => $request->categoryIconImage
        ]);
    }
}
