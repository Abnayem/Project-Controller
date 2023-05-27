<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
     public function index()
    {
        $result['color']=Color::all();

        return view('admin/color',$result);
    }

    public function add(Request $request ,$id='')
    {
        
        if($id > 0)
      {
        $arr = Color::where(['id'=>$id])->get();
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
      return view('admin/manage_color',$result);
    }

    
    public function insert(Request $request)
    {
        $request->validate([
            'name'=>'required',
          
            'slug'=>'required|unique:categories,slug,'.$request->input('id'),
            

        ]);
        $model = new Color();
        

        if($request->post('id') > 0)
        {
            $model = Color::find($request->post('id'));
            $msg = "Color Update";
        }
        else
        {
            
            $msg = "Color Insert";
        }
         
        
        
        
        $model->name=$request->input('name');
        $model->slug=$request->input('slug');
        $request->session()->flash('message',$msg);
        $model->status= 1;
        $model->save();
        
        return redirect('admin/color');



        


        
    }

    public function delete(Request $request,$id)
    {
        $model = Color::find($id);
        $model->delete();
        $request->session()->flash('message','Color Delete');
        return redirect('admin/color');
    }
    public function status(Request $request,$status,$id)
    {
        $model = Color::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','color Status Updated');
        return redirect('admin/color');
    }
}
