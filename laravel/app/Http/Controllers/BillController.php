<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Detail;
use App\Models\Gift;
use App\Models\Customer;
use App\Result\Result;


class BillController extends Controller
{    

    public function index()
    {                  
        $result = new Result();             

        $result->addMessage('[SUCCESS] # bills listed');
        $result->setDescription('bills listed');

        $result->setCode(200);

        $bills = Bill::with('detail')->get();

        $result->addData('bills', $bills);

        return $result->getJsonResponse();  
    }

    public function customer($id)
    {                  
        $result = new Result();             

        $result->addMessage('[SUCCESS] # bills listed');
        $result->setDescription('bills listed');

        $result->setCode(200);

        $bills = Bill::with('detail')->where('customer_id', $id)->get();

        $result->addData('bills', $bills);

        return $result->getJsonResponse();  
    }

    public function create(Request $request)
    {      
        $result = new Result();             

        $result->addMessage('[SUCCESS] # categories created');
        $result->setDescription('categories created');

        $result->setCode(201);

        $rules = [
            'date_expedition'=>'required|date',
            'customer_id'=>'required|integer|exists:customers,id',
            'description'=>'required',
            'price'=>'required|integer',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'gift_id' => 'required|integer|exists:gifts,id'
        ];                

        $customMessages = [
            'required' => 'Todos los campos deben estar llenos.',
            //'id.unique'=> 'ya existe un cliente resgistrado con este número de cedula.',
            //'name.required' => 'Cuidado!! el campo del nombre no se admite vacío',
        ];
        $validatedData = $request->validate($rules, $customMessages);
                  
        $bill_id = Bill::generate_id();
        
        $bill = new Bill([
            'id' => $bill_id,
            'date_expedition' => $request->get('date_expedition'),
            'customer_id' => $request->get('customer_id')
        ]);

        $detail = new Detail([            
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'bill_id' => $bill_id,
            'gift_id' => $request->get('gift_id')            
        ]);
        
        $bill->save();
        $detail->save();        
        
        $result->addData('bill', $bill->id);

        return $result->getJsonResponse(); 
    }

    
    public function show($id)
    {
        $result = new Result();             

        $bill = Bill::with('detail')->find($id);  

        if ($bill === null) {
            $result->addMessage('[FAILED] # bill dont show');
            $result->setDescription('bill dont show');            
            $result->addData('bill', $bill);
            $result->setCode(202); 
        } else {
            $result->addMessage('[SUCCESS] # bill show');
            $result->setDescription('bill show');
            $result->setCode(200); 
        }                               

        return $result->getJsonResponse();
    }

    public function update(Request $request, $id)
    {
        $result = new Result();  

        $rules = [
            'id' => 'exists:bills,id',
            'date_expedition'=>'required|date',           
            'detail_id'=>'exists:details,id',
            'description'=>'required',
            'price'=>'required|integer',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',                     
        ];                

        $customMessages = [
            'required' => 'Todos los campos deben estar llenos.'
            //'id.unique'=> 'ya existe un cliente resgistrado con este número de cedula.',
            //'name.required' => 'Cuidado!! el campo del nombre no se admite vacío',
        ];
        $validatedData = $request->validate($rules, $customMessages);
        
        $bill = Bill::find($id);
        
        if ($bill === null) {
            $result->addMessage('[FAILED] # bill dont updated');
            $result->setDescription('bill dont updated');
            $result->setCode(202);
        } else{
            $bill->date_expedition=$request->get('date_expedition');
            $bill->save();
            
            $detail = Detail::find($request->get('detail_id'));
            $detail->description=$request->get('description');
            $detail->price=$request->get('price');
            $detail->start_date=$request->get('start_date');
            $detail->end_date=$request->get('end_date');             
            $detail->save();        
            $result->addMessage('[SUCCESS] # bill updated');
            $result->setDescription('bill updated');
            $result->setCode(201);
        }                

        return $result->getJsonResponse();
    }
    
    public function destroy($id)
    {
        $result = new Result(); 

        $bill = Bill::find($id);
       
        if ($bill === null) {
            $result->addMessage('[FAILED] # bill dont deleted');
            $result->setDescription('bill dont deleted');
            $result->setCode(202);
        } else{            
            $bill->delete();
            $result->addMessage('[SUCCESS] # billcategory deleted');
            $result->setDescription('bill deleted');
            $result->addData('bill', $bill->id);
            $result->setCode(201);
        }        
        
        return $result->getJsonResponse();
    }
}