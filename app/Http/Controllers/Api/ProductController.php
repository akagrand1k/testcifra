<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\ProductRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Cache;


class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'limit' => 'integer|between:5,10',
            'sort' => 'in:id,title,price,quantity',
            'direction' => 'in:asc,desc',
            'search' => 'nullable|string|max:255'
        ]);

        $limit = $request->input('limit', 5);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $productsQuery = $this->productRepository->orderBy($sort, $direction);

        if ($search) {
            $productsQuery = $this->productRepository->searchByTitle($search);
        }

        $products = $productsQuery->paginate($limit);

        return response()->json($products);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productRepository->create($request->validated());

        if (!$product) {
            return response()->json(['message' => 'Не удалось создать продукт.'], 500);
        }

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return response()->json(['message' => 'Продукт не найден.'], 404);
        }

        return response()->json($product);
    }

    public function update(ProductRequest $request, $id)
    {
        $updated = $this->productRepository->update($id, $request->validated());

        if (!$updated) {
            return response()->json(['message' => 'Не удалось обновить продукт.'], 500);
        }

        return response()->json(['message' => 'Продукт успешно обновлен.'], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->productRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Не удалось удалить продукт.'], 500);
        }

        return response()->json(['message' => 'Продукт успешно удален.'], 200);
    }
}
