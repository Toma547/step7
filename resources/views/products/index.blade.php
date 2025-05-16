@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>

    <form method="GET" action="{{ route('products.index') }}">
        <input type="text" name="keyword" placeholder="検索..." value="{{ request('keyword') }}">
        <button type="submit">検索</button>
    </form>

    <a href="{{ route('products.create') }}">新規商品登録</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    
    <table class="table table-borderred">
        <thead class="table-light">
        <tr>
            <th>名前</th>
            <th>価格</th>
            <th>在庫</th>
            <th>操作</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></td>
            <td>{{ $product->price }}円</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}">編集</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('削除しますか？')">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $products->links() }}
</div>
@endsection