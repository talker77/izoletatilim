$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/service-attributes'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {
            data: 'type', name: 'type_id',
            render: function (data, type, row) {
                return data ? data.title : "-"
            }
        },
        {data: 'icon', name: 'icon'},
        {data: 'order', name: 'order'},
        {
            data: 'show_menu', name: 'show_menu',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'status', name: 'status',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/service/attributes/${data}/edit'><i class='fa fa-edit'></i></a> &nbsp;` +
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
            url: '/admin/service/attributes/' + id + '',
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

function deleteService(id) {
    if (confirm('Silmek istediğine emin misin ? ')) {
        $.ajax({
            url: '/admin/services/' + id + '',
            dataType: 'json',
            method: 'DELETE',
            success: function (data) {
                $(this).parent().remove();
                $(this).parent('td').parent('tr').fadeOut(600, function () {
                    this.remove();
                });
            }
        })
    }
}
