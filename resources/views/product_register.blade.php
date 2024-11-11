@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録画面</h1>
        <div class="registerBox">
            <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                @csrf
            <table border="1">
                <tr>
                    <th>商品名</th>
                        <td><input type="text" name="product_name" required></td>
                </tr>
                <tr>
                    <th>メーカー名</th>
                        <td>
                            <select name="company_id" required>
                                <option value="">会社名を選択</option>
                                @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </td>
                </tr>
                <tr>
                    <th>価格</th>
                        <td><input type="number" name="price" required></td>
                </tr>
                <tr>
                    <th>在庫数</th>
                        <td><input type="number" name="stock" required></td>
                </tr>
                <tr>
                    <th>コメント</th>
                        <td><textarea name="comment"></textarea></td>
                </tr>
                <tr>
                    <th>商品画像</th>
                        <td>
                            <input type="file" name="img_path" accept="image/*">
                        </td>
                </tr>
            </table>
            <button type="submit">新規登録</button><button type="button" onclick="location.href='{{ route('product') }}'">戻る</button>
            </form>
        </div>

</div>
@endsection