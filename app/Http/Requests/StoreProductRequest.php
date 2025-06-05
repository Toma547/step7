<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'comment' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください。',
            'company_id.required' => '会社を選択してください。',
            'company_id.exists' => '選択された会社が無効です。',
            'price.required' => '価格を入力してください。',
            'price.integer' => '価格は整数で入力してください。',
            'stock.required' => '在庫数を入力してください。',
            'stock.integer' => '在庫数は整数で入力してください。',
            'image.image' => '画像ファイルを選択してください。',
        ];
    }
}
