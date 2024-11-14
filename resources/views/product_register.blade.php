@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録画面</h1>
        <div class="registerBox">
            <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                @csrf
            <table class="table table-striped">
                <tr>
                    <th>商品名</th>
                        <td><input type="text" name="product_name" class="@error('product_name') is-invalid @enderror" value="{{ old('product_name') }}">
                            @error('product_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </td>

                </tr>
                <tr>
                    <th>メーカー名</th>
                        <td>
                            <select name="company_id" class="@error('company_id') is-invalid @enderror">
                                <option value="">会社名を選択</option>
                                @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </td>
                </tr>
                <tr>
                    <th>価格</th>
                    <td><input type="number" name="price" value="{{ old('price') }}" class="@error('price') is-invalid @enderror">
                        @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>在庫数</th>
                    <td><input type="number" name="stock" value="{{ old('stock') }}" class="@error('stock') is-invalid @enderror">
                        @error('stock')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>コメント</th>
                        <td><textarea name="comment" value="{{ old('comment') }}"></textarea></td>
                </tr>
                <tr>
                    <th>商品画像</th>
                        <td>
                            <input type="file" name="img_path" accept="image/*">
                        </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-primary">新規登録</button>
            <button type="button" onclick="location.href='{{ route('product') }}'" class="btn btn-warning">戻る</button>
            </form>
        </div>

</div>
@endsection