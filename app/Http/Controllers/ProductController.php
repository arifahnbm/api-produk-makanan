<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API Dokumentasi Produk Makanan",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk pengelolaan produk.",
 *     @OA\Contact(
 *         email="arifahnur@example.com"
 *     )
 * )
 */

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk.
     *
     * @OA\Get(
     *     path="/products",
     *     summary="Daftar produk",
     *     description="Mengambil semua data produk.",
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Daftar produk berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Product::all());
    }

    /**
     * Menyimpan produk baru.
     *
     * @OA\Post(
     *     path="/products",
     *     summary="Tambah produk",
     *     description="Menyimpan produk baru ke database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Produk Baru"),
     *             @OA\Property(property="description", type="string", example="Deskripsi produk"),
     *             @OA\Property(property="price", type="number", format="float", example=10000),
     *             @OA\Property(property="stock", type="integer", format="float", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produk berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    /**
     * Menampilkan detail produk.
     *
     * @OA\Get(
     *     path="/products/{id}",
     *     summary="Detail produk",
     *     description="Mengambil detail produk berdasarkan ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID produk"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail produk berhasil diambil"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Product::findOrFail($id));
    }

    /**
     * Mengupdate data produk.
     *
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Update produk",
     *     description="Mengupdate data produk berdasarkan ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID produk"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Produk Baru"),
     *             @OA\Property(property="description", type="string", example="Deskripsi produk"),
     *             @OA\Property(property="price", type="number", format="float", example=12000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil diupdate"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Menghapus produk.
     *
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Hapus produk",
     *     description="Menghapus produk berdasarkan ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID produk"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produk berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produk tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted']);
    }

}
