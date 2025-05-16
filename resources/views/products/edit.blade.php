@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>商品名：</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}">
        </div>
        <div>
            <label>説明：</label>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label>価格：</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}">
        </div>
        <div>
            <label>在庫数：</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
        </div>
        <button type="submit">更新</button>
    </form>
</div>
@endsection
