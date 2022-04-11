$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/locations'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {
            data: 'type_id', name: 'type_id',
            render: function (data, type, row) {
                return row['type'] ? row['type']['title'] : '-'
            }
        },
        {data: 'country.title', name: 'country_id'},
        {
            data: 'state_id', name: 'state_id',
            render: function (data, type, row) {
                return row['state'] ? row['state']['title'] : '-'
            }
        },
        {
            data: 'district_id', name: 'district_id',
            render: function (data, type, row) {
                return row['district'] ? row['district']['title'] : '-'
            }
        },
        {
            data: 'status', name: 'status',
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
                return `<a href='/admin/locations/${data}/edit'><i class='fa fa-edit'></i></a> &nbsp;` +
                    `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash'></i></a>`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

$('#table').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        // $(this).parent().parent().remove()
        const id = $(this).data('id')
        const self = this;
        $.ajax({
            url: '/admin/locations/' + id + '',
            dataType: 'json',
            method: 'DELETE',
            success: function (data) {
                $(self).parent().parent().css('background-color', 'red')
                    .fadeOut(600, function () {
                        this.remove();
                    });
            },
            error: function (xhr) {
                alert(xhr)
            }
        })
    }
});
