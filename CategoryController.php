<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        $result['category']=Category::all();

        return view('admin/category',$result);
    }

    public function add(Request $request ,$id='')
    {
        
        if($id > 0)
      {
        $arr = Category::where(['id'=>$id])->get();
        $result['name'] = $arr['0']->name;
        $result['slug'] = $arr['0']->slug;
        $result['image'] = $arr['0']->image;
        $result['description'] = $arr['0']->description;
        $result['id']=$arr['0']->id;
      }
      else
      {
        $result['name'] = '';
        $result['slug'] = '';
        $result['image'] = '';
        $result['description'] = '';
        $result['id'] = 0;

      } 
      return view('admin/manage_category',$result);
    }

    // public function manage_category(Request $request ,$id='')
    // {
    //   if($id > 0)
    //   {
    //     $arr = Category::where(['id'=>$id])->get();
    //     $result['name'] = $arr['0']->name;
    //     $result['slug'] = $arr['0']->slug;
    //     $result['image'] = $arr['0']->image;
    //     $result['description'] = $arr['0']->description;
    //     $result['id']=$arr['0']->id;
    //   }
    //   else
    //   {
    //     $result['name'] = '';
    //     $result['slug'] = '';
    //     $result['image'] = '';
    //     $result['description'] = '';
    //     $result['id'] = 0;

    //   } 
    //   return view('admin/category/manage_category',$result); 
    // }
    public function insert(Request $request)
    {
        $request->validate([
            'name'=>'required',
          
            'slug'=>'required|unique:categories,slug,'.$request->input('id'),
            

        ]);
        $model = new Category();
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('admin-assets/category/images',$filename);
            $model->image = $filename;

        if($request->post('id') > 0)
        {
            $model = Category::find($request->post('id'));
            $msg = "Category Update";
        }
        else
        {
            
            $msg = "Category Insert";
        }
         $request->session()->flash('message',$msg);
        }
        
        
        $model->name=$request->input('name');
        $model->slug=$request->input('slug');
        $model->description=$request->input('description');
        $model->save();
        
        return redirect('admin/category')->with('status','Insert successfully');



        


        
    }

    public function delete(Request $request,$id)
    {
        $model = Category::find($id);
        $model->delete();
        $request->session()->flash('message','Category Delete');
        return redirect('admin/category');
    }

   

    
}

