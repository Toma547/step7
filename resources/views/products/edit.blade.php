@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    {{-- エラーメッセージ一覧表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>商品名<span style="color: red">*</span>：</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}">
            @error('product_name')
               <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>メーカー名<span style="color: red">*</span>：</label>
            <select name="company_id">
                <option value="">-- 選択してください --</option>
                @foreach ($companies as $company)
                   <option value="{{ $company->id }}"
                    {{ old('company_id', $product->company_id) == $company->id ? 'selected' : ''}}>
                    {{ $company->company_name}}         
                   </option>
                @endforeach   
            </select>
            @error('company_id')
              <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>価格<span style="color: red">*</span>：</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
               <div class="text-danger">{{ $message }}</div>
            @enderror 
        </div>

        <div>
            <label>在庫数<span style="color: red">*</span>：</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
            @error('stock')
              <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>コメント：</label>
            <textarea name="comment">{{ old('comment', $product->comment ?? '') }}</textarea>
            @error('description')
               <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>商品画像：</label>
            @if($product->image_path)
                <div>
                    <img src="{{ asset(str_replace('public/', 'storage/', $product->image_path)) }}" alt="商品画像" style="max-width:  150px;">
                </div>
            @endif    
            <input type="file" name="image">
            @error('image')
              <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">更新</button>
            <a href="{{ route('products.show', $product->id) }}">
                <button type="button" style="margin-left: 10px;">戻る</button>
            </a>
        </div>
    </form>
</div>
@endsection

