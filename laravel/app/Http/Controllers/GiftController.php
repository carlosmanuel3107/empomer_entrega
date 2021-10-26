<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Category;
use App\Result\Result;

class GiftController extends Controller
{    
    public function index()
    {
        $result = new Result();             

        $result->addMessage('[SUCCESS] # gifts listed');
        $result->setDescription('gifts listed');

        $result->setCode(200);

        $gifts = Gift::all();
        //$gifts = Gift::with('category');

        $result->addData('gifts', $gifts);

        return $result->getJsonResponse();     
    }
        
    public function create(Request $request)
    {       
        $result = new Result();             

        $result->addMessage('[SUCCESS] # gifts created');
        $result->setDescription('gifts created');

        $result->setCode(201);

        $rules = [
            'name'=>'required',                        
            'price'=>'required|integer',            
            'category_id' => 'required|integer'
        ];                

        $customMessages = [
            'required' => 'Todos los campos deben estar llenos.',
            //'id.unique'=> 'ya existe un cliente resgistrado con este número de cedula.',
            //'name.required' => 'Cuidado!! el campo del nombre no se admite vacío',
        ];
        $validatedData = $request->validate($rules, $customMessages);                          
        
        $gift = new Gift([            
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'category_id' => $request->get('category_id'),
        ]);  
        $gift->save();        
                
        $result->addData('gift', $gift->id);

        return $result->getJsonResponse();  
    }
    
    public function show($id)
    {
        $result = new Result();             

        $gift = Gift::find($id);        

        if ($gift === null) {
            $result->addMessage('[FAILED] # gift dont show');
            $result->setDescription('gift dont show');            
            $result->addData('gift', $gift);
            $result->setCode(202); 
        } else {
            $result->addMessage('[SUCCESS] # gift show');
            $result->setDescription('gift show');
            $result->setCode(200); 
        }                               

        return $result->getJsonResponse();
    }        
    
    public function update(Request $request, $id)
    {
        $result = new Result();

        $rules = [
            'id'=>'required|integer|exists:gifts,id',
            'name'=>'required',                        
            'price'=>'required|integer',            
            'category_id' => 'required|integer|exists:categories,id'
        ];                

        $customMessages = [
            'required' => 'Todos los campos deben estar llenos.',
            //'id.unique'=> 'ya existe un cliente resgistrado con este número de cedula.',
            //'name.required' => 'Cuidado!! el campo del nombre no se admite vacío',
        ];
        $validatedData = $request->validate($rules, $customMessages);                          
        
        
        $gift = Gift::find($id);                        
        
        if ($gift === null) {
            $result->addMessage('[FAILED] # gift dont updated');
            $result->setDescription('gift dont updated');
            $result->setCode(202);
        } else{
            $gift->name = $request->get('name');
            $gift->price = $request->get('price');
            $gift->category_id = $request->get('category_id');
            $gift->save();
            $result->addMessage('[SUCCESS] # gift updated');
            $result->setDescription('gift updated');
            $result->addData('gift', $request->get('name'));
            $result->setCode(201);
        }                
        
        return $result->getJsonResponse();
    }
    
    public function destroy($id)
    {
        $result = new Result(); 

        $name = ''; 
        $gift = Gift::find($id);

        if ($gift === null) {
            $result->addMessage('[FAILED] # gift dont deleted');
            $result->setDescription('gift dont deleted');
            $result->setCode(202);
        } else{
            $gift = Gift::find($id);
            $name = $gift->name;
            $gift->delete();

            $result->addMessage('[SUCCESS] # gift deleted');
            $result->setDescription('gift deleted');
            $result->addData('gift', $name);
            $result->setCode(201);
        }    

        return $result->getJsonResponse();
    }
}