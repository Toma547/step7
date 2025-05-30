@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>商品名<span style="color: red">*</span>：</label>
            <input type="text" name="product_name" value="{{ old('name', $product->product_name) }}">
        </div>
        <div>
            <label>メーカー名<span style="color: red">*</span>：</label>
            <input name="text" name="company_name" value="{{ old('name', $product->company_name) }}">
        </div>
        <div>
            <label>価格<span style="color: red">*</span>：</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}">
        </div>
        <div>
            <label>在庫数<span style="color: red">*</span>：</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
        </div>
        <div>
            <label>コメント：</label>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label>商品画像：</label>
            <input type="file" name="image">
        </div>
        <button type="submit">更新</button>
        <a href="{{ route('products.show', $product->id) }}">
            <button type="button" style="margin-left: 10px; margin-top: 10px;">戻る</button>
        </a>
    </form>
</div>
@endsection
