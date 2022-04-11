$('#service-comments').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/kullanici/tables/comments/',
        data: {
            'serviceId': getParameterByName('serviceId')
        }
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {
            data: 'service_id', name: 'service.title',
            render: function (data, type, row) {
                return row['service']
                    ? `<a href="/kullanici/services/${data}/edit">${row['service']['title']}</a>`
                    : '-'
            }
        },
        {
            data: 'user.name', name: 'user.name',
            render: function (data, type, row) {
                return row['user']
                    ? row['user']['name'] + row['user']['surname']
                    : ''
            }
        },
        {
            data: 'point', name: 'point'
        },
        {
            data: 'message', name: 'message',
            render: function (data, type, row) {
                return (data).toString().substr(0, 255)
            }
        },
        {
            data: 'updated_at', name: 'updated_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});
