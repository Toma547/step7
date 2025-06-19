<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //　一覧表示
    public function index(Request $request)
    {
        $query = Product::with('company');

        // キーワード検索（商品名 or メーカー名）
        if($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('product_name','like',"%{$keyword}%")
                 ->orWhereHas('company',function($q2) use ($keyword){
                    $q2->where('company_name','like',"%{$keyword}%");
                 });
            });
        }

        // メーカー検索
        if($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // 価格範囲検索
        if($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // 在庫範囲検索
        if($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }
        if($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        // ソート処理
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'desc');

        // ホワイトリストで安全に制限
        $allowedSortFields = ['id', 'product_name', 'price', 'stock', 'company_id'];
        if(in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortOrder);
        }

    $products = $query->paginate(10)->appends($request->all());

    // Ajaxによるリクエスト時は部分ビューを返す
    if($request->ajax()) {
        $view = view('products.partials.table_body', compact('products'))->render();
        return response()->json(['html' => $view]);
    }

    // 通常表示
    $companies = Company::all();
    return view('products.index', compact('products', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 登録画面表示
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 登録処理
    public function store(StoreProductRequest $request)
    {
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images','public');
            $validated['image_path'] = 'public/' . $path;
        }

        Product::create($validated);

        DB::commit();
        return redirect()->route('products.index')->with('success', '商品を登録しました');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', '商品登録中にエラーが発生しました: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //　詳細表示
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 編集画面表示
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();

        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // 更新処理
    public function update(UpdateProductRequest $request, Product $product)
    {
         $validated = $request->validated();

         DB::beginTransaction();

        try{

        if($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('public/images');
        }

        $product->fill($validated)->save();

        DB::commit();
        return redirect()->route('products.index', $product->id)->with('success', '商品を更新しました');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', '商品更新中にエラーが発生しました: ' . $e->getMessage());
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 削除処理
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $product->delete();

        DB::commit();

        //Ajax対応
        if(request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('products.index')->with('success', '商品を削除しました');
        } catch (\Exception $e) {
            DB::rollBack();

            if(request()->ajax()) {
                return response()->json(['error' => '削除に失敗しました'], 500);
            }

            return back()->with('error', '商品削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
