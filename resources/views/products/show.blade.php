@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <p><strong>商品名：</strong> {{ $product->name }}</p>
    <p><strong>説明：</strong> {{ $product->description }}</p>
    <p><strong>価格：</strong> {{ $product->price }} 円</p>
    <p><strong>在庫：</strong> {{ $product->stock }}</p>

    <a href="{{ route('products.edit', $product->id) }}">編集</a>
    <a href="{{ route('products.index') }}">一覧に戻る</a>
</div>
@endsection
