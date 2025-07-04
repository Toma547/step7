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

