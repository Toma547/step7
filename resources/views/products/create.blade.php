@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新規商品登録画面</h1>

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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>商品名<span style="color: red">*</span>：</label>
            <input type="text" name="product_name" value="{{ old('product_name') }}">
            @error('product_name')
               <div class="text-danger">{{ $message }}</div>
            @enderror   
        </div>

        <div>
            <label>メーカー名<span style="color: red">*</span>：</label>
            <select name="company_id">
                <option value="">-- 選択してください --</option>
                @foreach ($companies as $company)
                   <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : ''}}>
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
            <input type="number" name="price" value="{{ old('price') }}">
            @error('price')
               <div class="text-danger">{{ $message }}</div>
            @enderror   
        </div>

        <div>
            <label>在庫数<span style="color: red">*</span>：</label>
            <input type="number" name="stock" value="{{ old('stock') }}">
            @error('stock')
                <div class="text-danger">{{ $message }}</div>
            @enderror    
        </div>

        <div>
            <label>コメント：</label>
            <textarea name="comment">{{ old('comment', $product->comment ?? '') }}</textarea>
            @error('comment')
              <div class="text-danger">{{ $message }}</div>
            @enderror    
        </div>

        <div>
            <label>商品画像：</label>
            <input type="file" name="image">
            @error('image')
              <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div style="margin-top: 10px;">
            <button type="submit">新規登録</button>
            <a href="{{ route('products.index') }}">
            <button type="button" style="margin-left: 10px;">戻る</button>
            </a>
        </div>      
    </form>
</div>
@endsection
