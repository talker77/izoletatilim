$('#reportTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/reports'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'type_label', name: 'type_label'},

        {
            data: 'item_id', name: 'item_id',
            render: function (data, type, row) {
                return type == 1 // TYPE_SERVICE
                    ? `<a href="/admin/services/${data}/edit">${data}</a>`
                    : `<a href="/admin/company-services/${data}/edit">${data}</a>`
            }
        },
        {data: 'click', name: 'click'},
        {
            data: 'created_at', name: 'created_at',
            render: function (data, type, row) {
                return createdAt(data)
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
