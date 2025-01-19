        // 検索フォームの送信イベント
        $('#search_form').on('submit', function(event){
            event.preventDefault();
            searchProducts();
        })

        $(document).ready(function() {
          $('#product_List').tablesorter({
            headers: {
              1: { sorter: false },
              6: { sorter: false }
            }
          });
        });
        
        // CSRF トークンを取得
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        // 検索処理関数
        function searchProducts() {
            // 検索キーワードとメーカー名を取得
            let keyword = $("#keyword").val();
            let manufacturer = $("#manufacturer").val();
            let ander_price = $("#ander_price").val();
            let top_price = $("#top_price").val();
            let ander_stock = $("#ander_stock").val();
            let top_stock = $("#top_stock").val();
                // Ajax を使用してサーバーにデータを送信
            $.ajax({
            url: 'search', // 検索処理を行うルート
            method: "GET", // HTTP メソッド
            data: {
                keyword: keyword,
                manufacturer: manufacturer,
                ander_price: ander_price,
                top_price: top_price,
                ander_stock: ander_stock,
                top_stock: top_stock
            },
            dataType: "json",
            }).done(function(response) {
              // 関数「displayProducts」を呼び出し検索結果を HTML に表示
              displayProducts(response);
            }).fail(function() {
                // エラーが発生した場合の処理
                alert("通信に失敗しました")
              });    
        };

        function displayProducts(response) {
                // サーバーから返されたデータを受け取る
                let data = "";
                response.forEach(function(products) {
                    data +=`<tr>
                      <td>${products.id}</td>
                      <td><img src="${products.img_path}" width="20"></td>
                      <td>${products.product_name}</td>
                      <td>${products.price}</td>
                      <td>${products.stock}</td>
                      <td>${products.company.company_name}</td>
                      <td>
                        <div style="display: flex;">
                          <button type="button" onclick="location.href='detail/${products.id}'" class="btn btn-primary">詳細</button>
                          <button type="button" class="btn btn-danger delete-button" data-id="${products.id}">削除</button>
                        </div>
                      </td>
                    </tr>`
                    $("#product_List tbody").html(data);
                    // 削除ボタンクリックイベントの追加
                    addDeleteButtonEventListeners(csrfToken);
                    // tablesorterをupdateして有効にする
                    $('#product_List').trigger("update");
                })
        };

        function addDeleteButtonEventListeners(csrfToken) {
            // 削除ボタンイベントリスナー追加関数
          $('.delete-button').on('click', function() {
              const productId = $(this).data('id');
              if (confirm('本当に削除しますか？')) {
                  $.ajax({
                      url: `product_delete/${productId}`,
                      method: "DELETE",
                      headers: {'X-CSRF-TOKEN': csrfToken
                      },
                      data: {
                        id: productId
                      },                      
                    }).done(function() {
                          alert('削除しました');
                          searchProducts(); // 検索関数を呼び出してテーブルを更新
                    }).fail(function() {
                          alert('削除に失敗しました');
                    });
                }
            })
          };