@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>
        <div class="search_box">
          <label for="search_form">検索欄：</label>
          <form method="get" action="{{ route('search') }}" id="search_form">
            <input type="text" placeholder="商品名検索" name="keyword" id="keyword">
            <select name="manufacturer" id="manufacturer">
                <option value=""selected>メーカー名</option>
                @foreach ($companies->unique('company_name') as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select><br>
            <lavel for="ander_price">価格：</lavel>
            <input type="number" placeholder="最低値" name="ander_price" id="ander_price">
            <lavel for="top_price">～</lavel>
            <input type="number" placeholder="最大値" name="top_price" id="top_price"><br>
            <lavel for="ander_stock">在庫数：</lavel>
            <input type="number" placeholder="最低値" name="ander_stock" id="ander_stock">
            <lavel for="top_stock">～</lavel>
            <input type="number" placeholder="最大値" name="top_stock" id="top_stock">
            <button type="submit" class="btn btn-success" id="search">検索</button>
          </form>
            <table class="table table-striped table align-middle" id="product_List">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>商品画像</th>
                      <th>商品名</th>
                      <th>価格</th>
                      <th>在庫</th>
                      <th>メーカー名</th>
                      <th><button type="button" onclick="location.href='{{ route('product_register') }}'" class="btn btn-info">新規登録</button></th>
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
                      <td>{{ $product-> company-> company_name }}</td>
                      <td>
                        <div style="display: flex;">
                          <button type="button" onclick="location.href='{{ route('detail', ['id' => $product->id]) }}'" class="btn btn-primary">詳細</button>
                          <form action="{{ route('product_delete', ['id' => $product->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                          </form>
                        </div>
                      </td>
                  </tr>
                @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection