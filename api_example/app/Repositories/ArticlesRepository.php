<?php

namespace App\Repositories;
use App\Models\Article;

class ArticlesRepository extends BaseRepository
{
    private $paginate = null;
    private $page = 1;
    private $limit = 10;
    private $sort = 'created_at';
    private $order = 'desc'; 
    
    public function __construct(Article $model){
        parent::__construct($model);
    }
    
    public function show($attributes) 
    { 
        $sort = $this->isExist($attributes,'sort');
        $order = $this->isExist($attributes,'order');
        $paginate =$this->isExist($attributes,'paginate');
        $page =$this->isExist($attributes,'page');
        $limit =$this->isExist($attributes,'limit');
       
        $data = $this->model
        ->withCount('comments')
        ->with('tags')
        ->orderBy('comments_count',$order)
        ->orderBy($sort,$order)
        ->limit($limit)
        ->when($paginate,function($q) use ($page){
            return $q->paginate($page);
        }, function ($query){
            return $query->get();
        });

        return $data;
    }

    public function comments($attributes) {
        $sort = $this->isExist($attributes,'sort');
        $order = $this->isExist($attributes,'order');

        if($this->currentModel && $this->currentModel->count() > 0)
            $data = $this->currentModel
            ->with(['comments'=>function($q) use ($sort,$order){
                $q->orderBy($sort,$order);
            }])
            ->first();
        else 
            return false;

        return ($data)? $data->comments:false;
    }

    private function isExist($attributes,$type){
        return (isset($attributes[$type]) && $attr_sort = $attributes[$type])? $attr_sort:$this->$type;
    }
}