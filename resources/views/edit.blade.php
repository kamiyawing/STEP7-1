@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報編集画面</h1>
        <div class="edit_box">
          <form action="{{ route('update', ['id' => $edit->id]) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
            <table border="1">
                    <tr>
                      <th>ID</th>
                      <td>{{ $edit->id }}</td>
                    </tr>
                    <tr>
                      <th>商品名</th>
                      <td><input type="text" name="product_name" value="{{ $edit->product_name }}"></td>
                    </tr>
                    <tr>
                     <th>メーカー名</th>
                     <td><select name="company_id">
                        @foreach ($companies as $company)
                          @if ($company-> company_name === $edit-> company -> company_name)
                            <option value="{{ $company->id }}" selected>{{ $company->company_name }}</option>
                          @else 
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                          @endif
                        @endforeach
                         </select>
                     </td>
                    </tr>
                    <tr>
                      <th>価格</th>
                      <td><input type="text" name="price" value="{{ $edit->price }}"></td>
                    </tr>
                    <tr>
                     <th>在庫</th>
                     <td><input type="text" name="stock" value="{{ $edit->stock }}"></td>
                    </tr>
                    <tr>
                      <th>コメント</th>
                      <td><textarea name="comment">{{ $edit->comment }}</textarea></td>
                    </tr>
                    <tr>
                      <th>商品画像</th>
                        <td><input type="file" name="img_path" accept="image/*">
                        </td>
                    </tr>
                    <tr>
                      <th><button type="submit">更新</button></th>
                      <td><button type="button" onclick="location.href='{{ route('detail', ['id' => $edit->id]) }}'">戻る</button></td>
                    </tr>
            </table>
          </form>
        </div>

</div>
@endsection