@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新規商品登録</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div>
            <label>商品名：</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>説明：</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <label>価格：</label>
            <input type="number" name="price" value="{{ old('price') }}">
        </div>
        <div>
            <label>在庫数：</label>
            <input type="number" name="stock" value="{{ old('stock') }}">
        </div>
        <button type="submit">登録</button>
    </form>
</div>
@endsection