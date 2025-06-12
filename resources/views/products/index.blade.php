@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>

    <form method="GET" action="{{ route('products.index') }}">
        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">

        <select name="company_id">
            <option value="">メーカー名</option>
            @foreach($companies as $company)
              <option value="{{ $company->id }}"{{ request('company_id') == $company->id ? 'selected' : ''}}>
                 {{ $company->company_name }}
              </option> 
            @endforeach  
        </select>
        <button type="submit">検索</button>
    </form>

    <form action="{{ route('products.create') }}" method="GET" style="display:inline;">
        <button type="submit">新規商品登録</button>
    </form>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    
    <table class="table table-borderred">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th>操作</th>
         </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>
                @if($product->image_path)
                 <img src="{{ asset(str_replace('public/', 'storage/', $product->image_path)) }}" alt="商品画像" width="50">
                  @else
                     画像なし
                  @endif   
            </td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->price }}円</td>
            <td>{{ $product->stock }}本</td>
            <td>{{ $product->company->company_name ?? 'メーカー不明' }}</td>
            <td>
                <form action="{{ route('products.show', $product->id) }}" method="GET" style="display:inline;">
                    <button type="submit">詳細</button>
                </form>

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
