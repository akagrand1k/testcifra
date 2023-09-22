<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function paginate($limit)
    {
        return $this->model->paginate($limit);
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->model->orderBy($column, $direction);
    }


    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $attributes)
    {
        $product = $this->find($id);
        $product->update($attributes);
        return $product;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function searchByTitle($term)
    {
        return $this->model->where('title', 'LIKE', '%' . $term . '%');
    }
}
