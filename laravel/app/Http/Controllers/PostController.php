<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Result\Result;

class PostController extends Controller
{
    public function index()
    {   
        $result = new Result();             

        $result->addMessage('[SUCCESS] # posts listed');
        $result->setDescription('posts listed');

        $result->setCode(200);

        $posts = Post::all();

        $result->addData('posts', $posts);

        return $result->getJsonResponse();                
    }


    public function create(Request $request)
    {
        $result = new Result();             

        $result->addMessage('[SUCCESS] # post created');
        $result->setDescription('post created');

        $result->setCode(201);
        
        $rules = [            
            'title'=>'required',
            'subject'=>'required',
            'writer'=>'required',
            'message'=>'required',
            'date'=>'required'
        ];

        $customMessages = [
            'required' => 'Todos los campos son abligatorios.'            
        ];
        $validatedData = $request->validate($rules, $customMessages);
                
        $post = new Post([            
            'title' => $request->get('title'),
            'subject' => $request->get('subject'),
            'writer' => $request->get('writer'),
            'message' => $request->get('message'),
            'date' => $request->get('date')         
        ]);
        $post->save();
        
        $result->addData('post', $post);

        return $result->getJsonResponse();                
    }

    public function show($id)
    {
        $result = new Result();             

        $post = post::find($id);        

        if ($post === null) {
            $result->addMessage('[FAILED] # post dont show');
            $result->setDescription('post dont show');            
            $result->addData('post', $post);
            $result->setCode(202); 
        } else {
            $result->addMessage('[SUCCESS] # post show');
            $result->setDescription('post show');
            $result->setCode(200); 
        }                               

        return $result->getJsonResponse();
    }

    public function update(Request $request, $id)
    {
        $result = new Result();                             

        $rules = [      
            'title'=>'required',
            'subject'=>'required',
            'writer'=>'required',
            'message'=>'required',
            'date'=>'required'           
        ];
        $customMessages = [
            'required' => 'Todos los campos son obligatorios.'            
        ];
        
        $validatedData = $request->validate($rules, $customMessages);
                
        $post = Post::find($id);
        if ($post === null) {
            $result->addMessage('[FAILED] # post dont updated');
            $result->setDescription('post dont updated');
            $result->setCode(202);
        } else{
            $post->title = $request->get('title');
            $post->subject = $request->get('subject');
            $post->writer = $request->get('writer');
            $post->message = $request->get('message');
            $post->date = $request->get('date');
            $post->save();
            $result->addMessage('[SUCCESS] # post updated');
            $result->setDescription('post updated');
            $result->setCode(201);
        }                
        
        return $result->getJsonResponse();
    }

    public function destroy($id)
    {       
        $result = new Result(); 

        $name = ''; 
        $post = Post::find($id);

        if ($post === null) {
            $result->addMessage('[FAILED] # post dont deleted');
            $result->setDescription('post dont deleted');
            $result->setCode(202);
        } else{
            $title = $post->title;
            $post->delete();

            $result->addMessage('[SUCCESS] # caposttegory deleted');
            $result->setDescription('post deleted');
            $result->addData('post', $title);
            $result->setCode(201);
        }        
        
        return $result->getJsonResponse();
    }
}
