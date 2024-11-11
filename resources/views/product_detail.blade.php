@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報詳細画面</h1>
        <div class="product_detail">
            <table border="1">
                    <tr>
                      <th>ID</th>
                      <td>{{ $detail->id }}</td>
                    </tr>
                      <th>商品画像</th>
                      <td><img src="{{ asset($detail->img_path) }}" width="20"></td>
                    </tr>
                    <tr>
                      <th>商品名</th>
                      <td>{{ $detail->product_name }}</td>
                    </tr>
                    <tr>
                     <th>メーカー名</th>
                     <td>{{ $detail-> company ->company_name }}</td>
                    </tr>
                    <tr>
                      <th>価格</th>
                      <td>{{ $detail->price }}</td>
                    </tr>
                    <tr>
                     <th>在庫</th>
                     <td>{{ $detail->stock }}</td>
                    </tr>
                    <tr>
                      <th>コメント</th>
                      <td>{{ $detail->comment }}</td>
                    </tr>
                    <tr>
                      <th><button type="button" onclick="location.href='{{ route('edit', ['id' => $detail->id]) }}'">編集</button></th>
                      <td><button type="button" onclick="location.href='{{ route('product') }}'">戻る</button></td>
                    </tr>
            </table>
        </div>

</div>
@endsection