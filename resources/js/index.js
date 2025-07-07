import $ from 'jquery';

$(function () {
    console.log('index.js 読み込み成功');

    // 商品一覧の初期読み込み or 検索処理
    const $form = $('#searchForm');
    const $productTableBody = $('#product-table-body');
    
    // 検索フォーム送信（非同期）
    $form.on('submit', function (e) {
        e.preventDefault();
        fetchProducts();
    });

    // ソート機能（カラムヘッダクリック）
    $(document).on('click', '.sortable', function () {
        const $header = $(this);
        const sortField = $header.data('sort');
        const currentOrder = $header.data('order') || 'asc';
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        
        $('.sortable').data('order', ''); //他カラムのソート状態をリセット
        $header.data('order', newOrder);

        $('#sort_field').val(sortField);
        $('#sort_order').val(newOrder);

        fetchProducts();
    });

    // 削除処理（非同期）
    $(document).on('click', '.delete-btn', function () {
        if (!confirm('削除しますか？')) return;

        const url = $(this).data('url');
        const $row = $(this).closest('tr');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $row.fadeOut(300, function () { $(this).remove(); });
            },
            error: function () {
                alert('削除に失敗しました。');
            }
        });
    });

    // 一覧取得処理（共通化）
    function fetchProducts() {
        const params = {
            keyword: $('input[name="keyword"]').val(),
            company_id: $('select[name="company_id"]').val(),
            min_price: $('input[name="min_price"]').val(),
            max_price:  $('input[name="max_price"]').val(),
            min_stock: $('input[name="min_stock"]').val(),
            max_stock: $('input[name="max_stock"]').val(),
            sort_field: $('#sort_field').val(),
            sort_order: $('#sort_order').val(),
        };

        $.ajax({
            url: '/products',
            type: 'GET',
            data: params,
            success: function (res) {
                $('#product-table-body').html(res.html);
                updateSortIcons(); // ソートアイコンを更新
            },
            error: function (xhr) {
                console.error(xhr.responseText); //エラー内容表示
                alert('一覧の取得に失敗しました。');
            }
        });
    }

    // ソートアイコン表示更新
    function updateSortIcons() {
        $('.sortable').each(function () {
            const $header = $(this);
            const order = $header.data('order');
            $header.find('.sort-icon').remove(); // 一度全削除

            if (order) {
                const icon = order === 'asc' ? '▲' : '▼';
                $header.append('<span class="sort-icon">' + icon + '</span>');
            }
        })
    }
});
