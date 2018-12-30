<?php

namespace App\Repositories;

class BaseRepository implements BaseInterface
{
    /**
     * @var $model
     */

    public $currentModel;
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getSorted()
    {
        return $this->model->orderBy('order','ASC')->get();
    }


    public function attachMany($relation,$attributes) {
        
        if($this->currentModel === null) {
            return false;
        }
        // dd($this->currentModel->menuTypes()->get());
        $this->currentModel->$relation()->attach($attributes);
    }

    public function detachMany($relation) {
        if($this->currentModel === null) {
            return false;
        }

        $this->currentModel->$relation()->detach();
    }

    public function getWhere($search,$like)
    {
        return $this->model->where($search,$like);
    }

    /**
     * Get task by id.
     * @param $id
     * @return mixed
     */
    public function getById($id=null)
    {
        if(empty($id)){
            return $this->model->first();
        }
        return $this->model->find((int)$id);
    }

    /**
     * create new history
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $this->currentModel = $this->model->create($attributes);
        return $this;
    }

    /**
     * Update a task.
     *
     * @param integer $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(array $attributes)
    {

        if($this->currentModel === null) {
            return false;
        }

        $this->currentModel->fill($attributes)->save();

        return $this;
    }

    /**
     * Delete a task.
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        return $this->currentModel === null ? false :$this->currentModel->delete();
    }

    public function setModel($model) {
        $this->currentModel = is_numeric($model) ? $this->model->where('id',$model) : false;

        return $this;
    }


    public function destroy() {
        return $this->currentModel !== null ? $this->currentModel->delete() : false;
    }

    public function redirect() {
        return redirect();
    }
}
