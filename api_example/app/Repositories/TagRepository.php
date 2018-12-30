<?php

namespace App\Repositories;
use App\Models\Tag;

class TagRepository extends BaseRepository
{
    private $paginate = null;
    private $page = 1;
    private $limit = 10;
    private $sort = 'article_count';
    private $order = 'desc'; 

    public function __construct(Tag $model){
        parent::__construct($model);
    }
    
    public function show($attributes) 
    { 
        $sort = $this->isExist($attributes,'sort');
        $order = $this->isExist($attributes,'order');
        
        $data = $this->model
        ->withCount('article')
        ->orderBy($sort,$order)
        ->orderBy('article_count',$order)
        ->get();

        return $data;
    }

    public function articlesByTag($attributes) {
        $sort = $this->isExist($attributes,'sort');
        $order = $this->isExist($attributes,'order');
        $paginate =$this->isExist($attributes,'paginate');
        $page =$this->isExist($attributes,'page');
        $limit =$this->isExist($attributes,'limit');
       
        if($this->currentModel && $this->currentModel->count() > 0){
            $data = $this->currentModel
            ->with(['article'=>function($q) use ($sort,$order,$limit,$paginate,$page){
                $q->withCount('comments')
                ->with('tags')
                ->orderBy('comments_count',$order)
                ->orderBy('created_at',$order)
                ->limit($limit)
                ->when($paginate,function($q) use ($page){
                    return $q->paginate($page);
                }, function ($query){
                    return $query->get();
                });
            }])->first();
        }else 
            return false;

        return ($data)? $data->article:false;
    }

    private function isExist($attributes,$type){
        return (isset($attributes[$type]) && $attr_sort = $attributes[$type])? $attr_sort:$this->$type;
    }
}