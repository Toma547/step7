@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <h1>商品一覧</h1>

    <!-- 検索フォーム -->
    <form id="searchForm">
        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">

        <select name="company_id">
            <option value="">メーカー名</option>
            @foreach($companies as $company)
              <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : ''}}>
                 {{ $company->company_name }}
              </option> 
            @endforeach  
        </select>

        <label>価格：</label>
        <input type="number" name="min_price" placeholder="最小">
        <input type="number" name="max_price" placeholder="最大">

        <label>在庫数：</label>
        <input type="number" name="min_stock" placeholder="最小">
        <input type="number" name="max_stock" placeholder="最大">

        <button type="submit">検索</button>
    </form>

    <form action="{{ route('products.create') }}" method="GET" style="display:inline;">
        <button type="submit">新規商品登録</button>
    </form>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    
    <!-- ソート保持用 hidden -->
     <input type="hidden" id="sort_field" value="id">
     <input type="hidden" id="sort_order" value="desc">
     
     <!-- 商品一覧テーブル -->
     <table class="table table-borderred">
        <thead class="table-light">
        <tr>
            <th class="sortable" data-sort="id">ID</th>
            <th>商品画像</th>
            <th class="sortable" data-sort="product_name">商品名</th>
            <th class="sortable" data-sort="price">価格</th>
            <th class="sortable" data-sort="stock">在庫数</th>
            <th class="sortable" data-sort="company_id">メーカー名</th>
            <th>操作</th>
         </tr>
        </thead>
        <tbody id="product-table-body">
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $products->firstItem() +$index }}</td>
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

                <button class="purchase-btn" data-product-id="{{ $product->id }}" data-quantity="1">購入</button>

            </td>
        </tr>
        @endforeach
    </table>

    {{ $products->links() }}
</div>
@endsection
