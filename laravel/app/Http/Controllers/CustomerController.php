<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Result\Result;

class CustomerController extends Controller
{    
    public function index()
    {
        $result = new Result();


        $result->addMessage('[SUCCESS] # customers listed');
        $result->setDescription('customers listed');

        $result->setCode(200);

        $customers = Customer::all();

        $result->addData('customers', $customers);

        return $result->getJsonResponse();                     
    }

    public function create(Request $request)
    {
        $result = new Result();             

        $result->addMessage('[SUCCESS] # categories created');
        $result->setDescription('categories created');

        $result->setCode(201);

        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'extract'=>'required|integer',
            'direction'=>'required',
            'telephone'=>'required|integer'
        ];
        $customMessages = [
            //'required' => 'Cuidado!! el campo :attribute no se puede dejar vacío',
            'id.unique'=> 'ya existe un cliente resgistrado con este número de cedula.',
            //'name.required' => 'Cuidado!! el campo del nombre no se admite vacío',
        ];
        $validatedData = $request->validate($rules, $customMessages);
                
        $customer = new Customer([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'extract' => $request->get('extract'),
            'direction' => $request->get('direction'),
            'telephone' => $request->get('telephone') 
        ]);
        $customer->save();
        
        $result->addData('customer', $customer);

        return $result->getJsonResponse();
    }
    
    public function show($id)
    {
        $result = new Result();             

        $customer = Customer::find($id);        

        if ($customer === null) {
            $result->addMessage('[FAILED] # customer dont show');
            $result->setDescription('customer dont show');            
            $result->addData('customer', $customer);
            $result->setCode(202); 
        } else {
            $result->addMessage('[SUCCESS] # customer show');
            $result->setDescription('customer show');
            $result->setCode(200); 
        }                               

        return $result->getJsonResponse();
    }

    public function update(Request $request, $id)
    {       
        $result = new Result();  

        $request->validate([
            'id' => 'exists:customers,id',
            'first_name'=>'required',
            'last_name'=>'required',
            'extract'=>'required|integer',
            'direction'=>'required',
            'telephone'=>'required|integer'
        ]);        
        $customer = Customer::find($id);

        if ($customer === null) {
            $result->addMessage('[FAILED] # customer dont updated');
            $result->setDescription('customer dont updated');
            $result->setCode(202);
        } else{
            $customer->first_name =  $request->get('first_name');
            $customer->last_name = $request->get('last_name');
            $customer->extract = $request->get('extract');
            $customer->direction = $request->get('direction');
            $customer->telephone = $request->get('telephone');        
            $customer->save();
            $result->addMessage('[SUCCESS] # customer updated');
            $result->setDescription('customer updated');
            $result->setCode(201);
        } 

        return $result->getJsonResponse();
    }
    
    public function destroy($id)
    {

        $result = new Result(); 

        $name = ''; 

        $customer = Customer::find($id);

        if ($customer === null) {
            $result->addMessage('[FAILED] # customer dont deleted');
            $result->setDescription('customer dont deleted');
            $result->setCode(202);
        } else{
            $name = $customer->name;
            $customer->delete();
            $result->addMessage('[SUCCESS] # customer deleted');
            $result->setDescription('customer deleted');
            $result->addData('customer', $name);
            $result->setCode(201);
        }        
        
        return $result->getJsonResponse();       
    }
}
