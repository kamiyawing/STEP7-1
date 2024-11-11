@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>
        <div class="search_box">
          <form action="{{ route('product') }}" method="get">
            <input type="text" placeholder="商品名検索" name="keyword">
              <select name="manufacturer">
                <option value=""selected>メーカー名</option>
                @foreach ($companies->unique('company_name') as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
              </select>
              <button type="submit">検索</button>
          </form>
            <table border="1">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>商品画像</th>
                      <th>商品名</th>
                      <th>価格</th>
                      <th>在庫</th>
                      <th>メーカー名</th>
                      <th><button type="button" onclick="location.href='{{ route('product_register') }}'">新規登録</button></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                  <tr>
                      <td>{{ $product->id }}</td>
                      <td><img src="{{ asset($product->img_path) }}" width="20"></td>
                      <td>{{ $product->product_name }}</td>
                      <td>{{ $product->price }}</td>
                      <td>{{ $product->stock }}</td>
                      <td>{{ $product->company_name }}</td>
                      <td>
                        <div style="display: flex;">
                          <button type="button" onclick="location.href='{{ route('detail', ['id' => $product->id]) }}'">詳細</button>
                          <form action="{{ route('product_delete', ['id' => $product->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                          </form>
                      </td>
                  </tr>
                @endforeach
                </tbody>
            </table>
        </div>

</div>
@endsection