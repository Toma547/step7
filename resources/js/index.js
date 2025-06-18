

$(document).ready(function () {
    // 商品一覧の初期読み込み or 検索処理
    $('form[action="' + window.location.pathname + '"]').on('submit', function (e) {
        e.preventDefault();
        fetchProducts();
    });

    // ソート機能（カラムヘッダクリック）
    $('.sortable').on('click', function () {
        const sortField = $(this).data('sort');
        const currentOrder = $(this).data('order') || 'asc';
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        $(this).data('order', newOrder);

        $('#sort_field').val(sortField);
        $('#sort_order').val(newOrder);

        fetchProducts();
    });

    // 削除処理（非同期）
    $(document).on('click', '.delete-btn', function () {
        if (!confirm('削除しますか？')) return;

        const url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                fetchProducts();
            },
            error: function () {
                alert('削除に失敗しました。');
            }
        });
    });

    // 一覧取得処理（共通化）
    function fetchProducts() {
        const keyword = $('input[name="keyword"]').val();
        const companyId = $('select[name="company_id"]').val();
        const priceMin = $('input[name="price_min"]').val();
        const priceMax = $('input[name="price_max"]').val();
        const stockMin = $('input[name="stock_min"]').val();
        const stockMax = $('input[name="stock_max"]').val();
        const sortField = $('#sort_field').val();
        const sortOrder = $('#sort_order').val();

        $.ajax({
            url: '/products',
            type: 'GET',
            data: {
                keyword: keyword,
                company_id: companyId,
                price_min: priceMin,
                price_max: priceMax,
                stock_min: stockMin,
                stock_max: stockMax,
                sort_field: sortField,
                sort_order: sortOrder
            },
            success: function (res) {
                $('#product-table-body').html(res.html);
            },
            error: function () {
                alert('一覧の取得に失敗しました。');
            }
        });
    }
});
