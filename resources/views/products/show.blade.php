@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <p><strong>ID：</strong> {{ $product->id }}</p>
    <p><strong>商品画像：</strong>
           @if($product->image_path)
            <img src="{{ asset(str_replace('public/', 'storage/', $product->image_path)) }}" alt="商品画像" style="max-width: 300px;">
        @else
            画像なし
        @endif
    </p>
    <p><strong>商品名：</strong> {{ $product->product_name }}</p>
    <p><strong>メーカー：</strong> {{ $product->company->company_name ?? 'メーカー不明' }}</p>
    <p><strong>価格：</strong> {{ $product->price }} 円</p>
    <p><strong>在庫数：</strong> {{ $product->stock }}本</p>
    <p><strong>コメント：</strong> {{ $product->description }}</p>

    <a href="{{ route('products.edit', $product->id) }}">
        <button type="submit">編集</button>
    </a>
    <a href="{{ route('products.index') }}">
        <button type="button" style="margin-left: 10px; margin-top: 10px;">戻る</button>
    </a>
</div>
@endsection

