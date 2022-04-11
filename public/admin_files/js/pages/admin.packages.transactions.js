$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/package-transactions'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {
            data: 'user_id', name: 'user_id',
            render: function (data, type, row) {
                return row['user']
                    ? `<a  href="/admin/user/${row['user']['id']}/edit">${row['user']['name']}</a>`
                    : '-'
            }
        },
        {
            data: 'user_id', name: 'user_id',
            render: function (data, type, row) {
                return row['user']
                    ? `<a  href="/admin/user/${row['user']['id']}/edit">${row['user']['email']}</a>`
                    : '-'
            }
        },
        {
            data: 'package_id', name: 'package_id',
            render: function (data, type, row) {
                return row['package']
                    ? `<a  href="/admin/packages/${row['package']}/edit">${row['package']['title']}</a>`
                    : '-'
            }
        },
        {
            data: 'started_at', name: 'started_at',
            render: function (data, type, row) {
                return startDate(data)
            }
        },
        {
            data: 'expired_at', name: 'expired_at',
            render: function (data, type, row) {
                return startDate(data)
            }
        },
        {
            data: 'price', name: 'price',
            render: function (data, type, row) {
                return  `${row['price']} ₺`
            }
        },

        {
            data: 'is_payment', name: 'is_payment',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'updated_at', name: 'updated_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'created_at', name: 'created_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/package-transactions/${data}'><i class='fa fa-edit'></i></a> &nbsp;`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

function startDate(date) {
    return moment(date).format('DD/MM/Y');
}
