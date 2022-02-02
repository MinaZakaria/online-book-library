<?php

namespace App\Repositories;

use App\Exceptions\ItemNotFoundException;
use App\Interfaces\BaseRepositoryInterface;

abstract class BaseRepository  implements BaseRepositoryInterface
{
    abstract protected function model();

    public function all()
    {
        return $this->model()::all();
    }

    public function create(array $data)
    {
        return $this->model()::create($data);
    }

    public function find(int $id)
    {
        return $this->model()::find($id);
    }

    public function findOrFail(int $id)
    {
        try{
            return $this->model()::findOrFail($id);
        } catch(\Exception $e) {
            throw new ItemNotFoundException($this->model(), $id);
        }
    }

    public function findOneBy(array $criteria)
    {
        return $this->model()::firstWhere($criteria);
    }

    public function findBy(array $criteria)
    {
        return $this->model()::where($criteria)->get();
    }
}
