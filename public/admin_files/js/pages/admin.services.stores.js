$('#serviceTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/services'
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
            data: 'image', name: 'image',
            render: function (data) {
                const imagePrefix = $("#imagePrefix").val()
                return data
                    ? `<a target="_blank" href="${imagePrefix}${data}"><i class="fa fa-photo"></i></a>`
                    : ''
            }
        },
        {data: 'point', name: 'point'},
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
                return `<a href='/admin/services/${data}/edit'><i class='fa fa-edit'></i></a> &nbsp;` +
                    `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash'></i></a>`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

$('#serviceTable').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        // $(this).parent().parent().remove()
        const id = $(this).data('id')
        const self = this;
        $.ajax({
            url: '/admin/services/' + id + '',
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
