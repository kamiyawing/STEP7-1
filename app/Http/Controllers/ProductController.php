<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request) {
      $keyword = $request->input('keyword');
      $manufacturer = $request->input('manufacturer');
        // Modelにてジュースの商品データを取得済みのためインスタンス生成
      $productModel = new Product();
      $products = $productModel->getList();
        // 商品名を検索
      if (!empty($keyword)) {
        $products = $products->where('product_name', 'like', '%' . $keyword . '%');
        }
          // メーカー名絞り込み
      if (!empty($manufacturer)) {
        $products = $products->where('company_id', $manufacturer);
        }
      $products = $products->get();
        // 検索フォーム用に企業情報を取得
      $companyModel = new Company();
      $companies = $companyModel->getList()
      ->get();
        // $manufacturerを空設定し、初期値に設定した「メーカー名」が$manufacturerに入らないようにする
      $manufacturer = '';
        // 商品データとビューをレンダリング
      return view('products', compact('products', 'companies', 'manufacturer'));
      }

    public function product_register() {
      $companyModel = new Company();
      $companies = $companyModel->getList()
      ->get();
      return view('product_register', compact('companies'));
      }

    public function detail($id) {
      $productModel = new Product();
      $detail = $productModel->find($id);
      return view('product_detail', compact('detail'));
      }

    public function edit($id) {
      $productModel = new Product();
      $edit = $productModel ->find($id);
      $companyModel = new Company();
      $companies = $companyModel->getList()
      ->get();
      return view('edit', compact('edit', 'companies'));
      }
    
    protected function store(Request $Request) {
      $Request->validate([
      'product_name' => 'required|string',
      'company_id' => 'required|exists:companies,id', //exists:テーブル名,idで、companiesテーブルのidカラムにフィールドの値が存在することを確認
      'price' => 'required|numeric',
      'stock' => 'required|numeric',
      'comment' => 'nullable|string',
      'img_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', //mimes:で指定された拡張子か確認
      ]);
      if ($Request->hasFile('img_path')) {
        //画像ファイルの取得
      $image = $Request->file('img_path');
        //画像ファイルのファイル名を取得
      $file_name = $image->getClientOriginalName();
        // ファイル名に日付を追加
      $file_name = date('YmdHis') . '_' . $file_name;
        //storage/app/public/imageフォルダ内に、取得したファイル名で保存
      $image ->storeAs('public/image/', $file_name);
        //データベース登録用に、ファイルパスを作成
      $image_path = 'storage/image/' . $file_name;
      } else {
        $image_path = null;
      }
        //トランザクション
      DB::beginTransaction();
      try{
        $model = new Product();
        $model->store($Request , $image_path);
        DB::commit();
      }catch(\Exception $e){
        DB::rollBack();
      }
        //任意のViewにリダイレクト
      return redirect()->route('product_register');
    }

    protected function update(Request $Request, $id) {
      $Request->validate([
      'product_name' => 'required|string',
      'company_id' => 'required|exists:companies,id', //exists:テーブル名,idで、companiesテーブルのidカラムにフィールドの値が存在することを確認
      'price' => 'required|numeric',
      'stock' => 'required|numeric',
      'comment' => 'nullable|string',
      'img_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', //mimes:で指定された拡張子か確認
      ]);
      $model = new Product();
      $product = $model->find($id);
        // 画像ファイルがアップロードされ、既にデータが登録済みの場合
      if ($Request->hasFile('img_path') && $product->img_path) {
          // 既存の画像ファイルを削除
        Storage::delete('public/image/'. basename($product->img_path));
          //画像ファイルの取得
        $image = $Request->file('img_path');
          //画像ファイルのファイル名を取得
        $file_name = $image->getClientOriginalName();
          // ファイル名に日付を追加
        $file_name = date('YmdHis') . '_' . $file_name;
          //storage/app/public/imageフォルダ内に、取得したファイル名で保存
        $image ->storeAs('public/image/', $file_name);
          //データベース登録用に、ファイルパスを作成
        $image_path = 'storage/image/' . $file_name;
        // 画像ファイルがアップロードされ、データが未登録の場合
      } elseif ($Request->hasFile('img_path') && !$product->img_path) {
          //画像ファイルの取得
        $image = $Request->file('img_path');
          //画像ファイルのファイル名を取得
        $file_name = $image->getClientOriginalName();
          // ファイル名に日付を追加
        $file_name = date('YmdHis') . '_' . $file_name;
          //storage/app/public/imageフォルダ内に、取得したファイル名で保存
        $image ->storeAs('public/image/', $file_name);
          //データベース登録用に、ファイルパスを作成
        $image_path = 'storage/image/' . $file_name;
        // 画像ファイルがアップロードされず、データが存在した場合場合
      } elseif (!$Request->hasFile('img_path') && $product->img_path) {
          // 既存の画像ファイルを削除
          Storage::delete('public/image/'. basename($product->img_path));
          $image_path = null;
        // 画像ファイルがアップロードされず、データも存在しない場合　※何もしない 
      } else {
        $image_path = null;
      }
        //トランザクション
      DB::beginTransaction();
      try{
        $model->updateProduct($id , $Request , $image_path);
        DB::commit();
      }catch(\Exception $e){
        DB::rollBack();
      }
        //任意のViewにリダイレクト
      return redirect()->route('edit', ['id' => $Request->id]);
    }

    public function product_delete($id) {
      $model = new Product();
      $product = $model->find($id);
      if ($product->img_path) {
        Storage::delete('public/image/'. basename($product->img_path));
      }
        $product->delete();
        return redirect()->route('product');
    }
}
