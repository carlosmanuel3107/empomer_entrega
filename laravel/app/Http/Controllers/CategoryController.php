<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Result\Result;

class CategoryController extends Controller
{    
    public function index()
    {   
        $result = new Result();             

        $result->addMessage('[SUCCESS] # categories listed');
        $result->setDescription('categories listed');

        $result->setCode(200);

        $categories = Category::all();

        $result->addData('categories', $categories);

        return $result->getJsonResponse();                
    }


    public function create(Request $request)
    {
        $result = new Result();             

        $result->addMessage('[SUCCESS] # categories created');
        $result->setDescription('categories created');

        $result->setCode(201);
        
        $rules = [            
            'name'=>'required'            
        ];
        $customMessages = [
            'required' => 'El nombre es obligatorio.'            
        ];
        $validatedData = $request->validate($rules, $customMessages);
                
        $category = new Category([            
            'name' => $request->get('name')            
        ]);
        $category->save();
        
        $result->addData('category', $category->id);

        return $result->getJsonResponse();                
    }

    public function show($id)
    {
        $result = new Result();             

        $category = Category::find($id);        

        if ($category === null) {
            $result->addMessage('[FAILED] # category dont show');
            $result->setDescription('category dont show');            
            $result->addData('category', $category);
            $result->setCode(202); 
        } else {
            $result->addMessage('[SUCCESS] # category show');
            $result->setDescription('category show');
            $result->setCode(200); 
        }                               

        return $result->getJsonResponse();
    }

    public function update(Request $request, $id)
    {
        $result = new Result();                             

        $rules = [      
            'name'=>'required'            
        ];
        $customMessages = [
            'required' => 'El nombre es obligatorio.'            
        ];
        
        $validatedData = $request->validate($rules, $customMessages);
                
        $category = Category::find($id);
        if ($category === null) {
            $result->addMessage('[FAILED] # category dont updated');
            $result->setDescription('category dont updated');
            $result->setCode(202);
        } else{
            $category->name =  $request->get('name');
            $category->save();
            $result->addMessage('[SUCCESS] # categories updated');
            $result->setDescription('categories updated');
            $result->addData('category', $category->name);            
            $result->setCode(201);
        }                
        
        return $result->getJsonResponse();
    }

    public function destroy($id)
    {       
        $result = new Result(); 

        $name = ''; 
        $category = Category::find($id);

        if ($category === null) {
            $result->addMessage('[FAILED] # category dont deleted');
            $result->setDescription('category dont deleted');
            $result->setCode(202);
        } else{
            $name = $category->name;
            $category->delete();

            $result->addMessage('[SUCCESS] # category deleted');
            $result->setDescription('category deleted');
            $result->addData('category', $name);
            $result->setCode(201);
        }        
        
        return $result->getJsonResponse();
    }
}
