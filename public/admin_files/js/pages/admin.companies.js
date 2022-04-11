$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/companies'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {data: 'user.email', name: 'user.email'},
        {
            data: 'user', name: 'user.name',
            render: function (data, type, row) {
                return row['user'] ? row['user']['name'] : '-'
            }
        },
        {data: 'user.phone', name: 'user.phone'},
        {
            data: 'user.is_active', name: 'user.is_active',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'user.is_admin', name: 'user.is_admin',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/product/company/edit/${data}'><i class='fa fa-edit'></i></a> &nbsp;` +
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
        console.log(id);
        const self = this;
        $.ajax({
            url: `/admin/product/company/${id}/delete`,
            dataType: 'json',
            method: 'DELETE',
            success: function (data) {
                $(self).parent().parent().css('background-color', 'red')
                    .fadeOut(600, function () {
                        this.remove();
                    });
            },
            error: function (xhr) {
                alert(xhr.responseJSON.message)
            }
        })
    }
});
