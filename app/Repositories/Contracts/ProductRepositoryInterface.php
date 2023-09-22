<?php
namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function paginate($limit);
    public function orderBy($column, $direction = 'asc');
    public function searchByTitle($term);
    public function create(array $attributes);
    public function find($id);
    public function update($id, array $attributes);
    public function delete($id);
}
