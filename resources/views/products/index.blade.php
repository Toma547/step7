@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <h1>商品一覧</h1>

    <!-- 検索フォーム -->
    <form id="searchForm" action="{{ route('products.index') }}" method="GET">
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
        <input type="number" name="min_price" placeholder="最小" value="{{ request('min_price') }}">
        <input type="number" name="max_price" placeholder="最大" value="{{ request('max_price') }}">

        <label>在庫数：</label>
        <input type="number" name="min_stock" placeholder="最小" value="{{ request('min_stock') }}">
        <input type="number" name="max_stock" placeholder="最大" value="{{ request('max_stock') }}">

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
           @include('products.partials.table_body')
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection
