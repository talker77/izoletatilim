/**
 * yorumlar
 */
$('#transactions').DataTable({
    processing: true,
    serverSide: true,
    bFilter : false,
    ajax: {
        url: '/kullanici/tables/package-transactions/',
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {
            data: 'package_id', name: 'package_id',
            render: function (data, type, row) {
                return row['package']
                    ? row['package']['title'] + `(${row['package'].price}) ₺`
                    : '-'
            }
        },
        {
            data: 'started_at', name: 'started_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'expired_at', name: 'expired_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'price', name: 'price',
            render: function (data, type, row) {
                return data + " ₺";
            }
        },
        {
            data: 'created_at', name: 'created_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});
