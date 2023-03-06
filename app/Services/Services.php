<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class Services {


    const MSG_NOT_FOUND      = 'Registro não encontrado';
    const MSG_CREATE_SUCCESS = 'Registro criado com sucesso';
    const MSG_UPDATE_SUCCESS = 'Registro atualizado com sucesso';
    const MSG_DELETE_SUCCESS = 'Registro excluído com sucesso';
    const MSG_CREATE_ERROR   = 'Não foi possível cadastrar';
    const MSG_UPDATE_ERROR   = 'Não foi possível atualizar';
    const MSG_DELETE_ERROR   = 'Não foi possível excluir';

    protected $model;

    protected $error = false;
    protected $message;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function new($attr=null) {
        return new $this->model($attr);
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function find($id) {
        $plan = $this->model->find($id);

        if(empty($plan)) {
            return false;
        }

        return $plan;
    }

    public function save(Model $item, $data) {

        $item->fill($data);

        if($item->save()) {
            return true;
        }

        return false;
    }

    public function destroy($plan) {

        if(!is_object($plan)) {
            $plan = $this->find($plan);
            if(!$plan) {
                return;
            }
        }

        return $plan->delete();

    }

    

    public function list($enabled=null) {

        if($enabled !== null) {
            return $this->model->where('enabled', $enabled)->orderBy('id','desc')->get();
        }

        return $this->model->orderBy('id','desc')->get();
    }

    public function listEnabled() {
        return $this->model->where('enabled', 1)->orderBy('id','desc')->get();
    }

    public function listOrderByCreatedAt($enabled=null) {

        if($enabled !== null) {
            return $this->model->where('enabled', $enabled);
        }

        return $this->model->orderBy('created_at','desc')->get();
    }

    public function listOrderBy($field=null, $order='asc', $enabled=null) {

        if($enabled !== null) {
            return $this->model->where('enabled', $enabled);
        }

        return $this->model->orderBy($field,$order)->get();
    }

}