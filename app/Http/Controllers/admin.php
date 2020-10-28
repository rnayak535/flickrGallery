<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\app_category;
use Validator;

class admin extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

   public function index(){
        $data=array();
        $data["category"] = app_category::orderBy('id','ASC')->get()->toArray();
        return view('admin.dashboard', $data);
   }

   public function galleryCategory(){
        $data=array();
        $data["category"] = app_category::orderBy('id','ASC')->get()->toArray();
        return view('admin.galleryCategory', $data);
   }

   public function addNewCategory(Request $request){
    
    $validator = Validator::make($request->all(), ['name'=>'required']);
        if($validator->passes()){
            $oCategory = new app_category();
            $oCategory->name = $request->name;
            $oCategory->status = '1';
            $oCategory->save();
            $array = array('status'=>'true', 'message'=>'Category Added Successfully', 'reloadUrl'=>url('admin/gallery_category'));
        }
        else{
            $array = array('status'=>'false', 'message'=>$validator->errors()->all(), 'reloadUrl'=>url('admin/gallery_category'));
        } 
    echo json_encode($array);
   }

   public function deleteCategory(Request $request){
       $category = app_category::where('id',$request->categoryId)->get()->first();
       $category->delete();
       $array = array('status'=>'true', 'message'=>'Category Deleted Successfully', 'reloadUrl'=>url('admin/gallery_category'));
       echo json_encode($array);
   }

   public function editCategory(Request $request){

        $validator = Validator::make($request->all(), ['name'=>'required']);

        if($validator->passes()){
            $oCategory = app_category::where('id',$request->EditcategoryId)->get()->first();
            $oCategory->name = $request->name;
            $oCategory->update();
            $array = array('status'=>'true', 'message'=>'Category Updated successfully', 'reloadUrl'=>url('admin/gallery_category'));
        }else{
            $array = array('status'=>'false', 'message'=>$validator->error()->all(), 'reloadUrl'=>url('admin/gallery_category'));
        }
        echo json_encode($array);
   }
}