@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報編集画面</h1>
        <div class="edit_box">
          <form action="{{ route('update', ['id' => $edit->id]) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
            <table class="table table-striped">
              <tr>
                <th>ID</th>
                <td>{{ $edit->id }}</td>
              </tr>
              <tr>
                <th>商品名</th>
                <td>
                  <input type="text" name="product_name" value="{{ $edit->product_name }}" class="@error('product_name') is-invalid @enderror">
                  @error('product_name')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </td>
              </tr>
              <tr>
                <th>メーカー名</th>
                <td>
                  <select name="company_id" class="@error('company_id') is-invalid @enderror">
                  @foreach ($companies as $company)
                    @if ($company-> company_name === $edit-> company -> company_name)
                      <option value="{{ $company->id }}" selected>{{ $company->company_name }}</option>
                    @else 
                      <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endif
                  @endforeach
                  </select>
                  @error('company_id')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </td>
              </tr>
              <tr>
                <th>価格</th>
                <td>
                  <input type="number" name="price" value="{{ $edit->price }}" class="@error('price') is-invalid @enderror">
                  @error('price')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </td>
              </tr>
              <tr>
                <th>在庫</th>
                <td>
                  <input type="number" name="stock" value="{{ $edit->stock }}" class="@error('stock') is-invalid @enderror">
                  @error('stock')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </td>
              </tr>
                <tr>
                  <th>コメント</th>
                  <td><textarea name="comment">{{ $edit->comment }}</textarea></td>
                </tr>
                <tr>
                  <th>商品画像</th>
                  <td><input type="file" name="img_path" accept="image/*"></td>
                </tr>
            </table>
            <div>
              <button type="submit" class="btn btn-primary">更新</button>
              <button type="button" onclick="location.href='{{ route('detail', ['id' => $edit->id]) }}'" class="btn btn-warning">戻る</button>
            </div>
          </form>
        </div>
</div>
@endsection