<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;
class ProductController extends Controller
{

    public function index()
    {
        //
        return response()->json(Product::all());

    }


    /*public function create()
    {
        //
    }
    */


    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);
        $objeto = new Product($request->all());
        try {
            $objeto->save();
            return response()->json([
                'message' => 'Producto creado',
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al crear producto',
                'error' => true
            ], status: 500);
        }

    }


    public function show($id)
    {
       try {
            $product = Product::findOrFail($id);
            return response()->json($product);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'error' => true
            ], status: 404);
        }
    }


    /*public function edit(Product $product)
    {
        //
    }
    */
    public function update(Request $request, Product $product)
    {
        //
        $validated = $request->validate([
            'name'  => 'required|max:100|min:2|unique:product,name,' . $product->id,
            'price' => 'required|numeric|gte:0|lte:100000',
        ]);
        try {
            $result = $product->update($request->all());
            //$product->fill($request->all());
            //$result = $product->save();
            return redirect('product')->with(['message' => 'The product has been updated.']);
        } catch(Exception $e) {
            return back()->withInput()->withErrors(['message' => 'The product has not been updated.']);
        }
    }

    public function destroy(Product $product)
    {
        //
    }
}
