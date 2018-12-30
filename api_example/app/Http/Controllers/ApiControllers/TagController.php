<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    private $repository;
    private $status = 400;
    private $response = false;

    public function __construct(TagRepository $repository) {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {  
    	$validator = Validator::make($request->all(), [
           'sort' => ["nullable", "regex:(article_count|created_at)"], 
           'order' => ["nullable", "regex:(asc|desc)"],  
        ]);
        
        if ($validator->fails()) {
        	return response()->json($this->status);
        }

		if($this->response = $this->repository->show($request->all()))
        	$this->status = 200;

        return response()->json($this->response, $this->status);
    }

    public function articlesByTag(Request $request,$id)
    {  
    	$validator = Validator::make($request->all(), [
           'sort' => ["nullable", "regex:(view_count|comments_count|created_at)"], 
           'order' => ["nullable", "regex:(asc|desc)"],  
           'limit' => 'nullable|numeric',
           'paginate' => 'nullable|numeric',
           'page' => 'nullable|numeric',
        ]);
        
        if ($validator->fails()) {
        	return response()->json($this->status);
        }
        
        if(is_numeric($id))
			if($this->response = $this->repository->setModel($id)->articlesByTag($request->all()))
	    		$this->status = 200;
	    	else 
	    		$this->status = 404;
	    
        return response()->json($this->response, $this->status);
    }
}
