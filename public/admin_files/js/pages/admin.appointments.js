$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/appointments'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {
            data: 'service_company_id', name: 'service_company_id',
            render: function (data, type, row) {
                return row['service_company'] && row['service_company']['service']
                    ? `<a  href="/admin/services/${row['service_company']['service_id']}/edit">${row['service_company']['service']['title']}</a>`
                    : '-'
            }
        },
        {
            data: 'service_company_id', name: 'service_company.title',
            render: function (data, type, row) {
                return row['service_company']
                    ? `<a  href="/admin/company-services/${row['service_company_id']}/edit">${row['service_company']['title']}</a>`
                    : '-'
            }
        },
        {
            data: 'price', name: 'price',
            render: function (data, type, row) {
                return  `${row['price']} ₺`
            }
        },
        {
            data: 'start_date', name: 'start_date',
            render: function (data, type, row) {
                return startDate(data)
            }
        },
        {
            data: 'end_date', name: 'end_date',
            render: function (data, type, row) {
                return startDate(data)
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
                return `<a href='/admin/appointment/${data}/edit'><i class='fa fa-edit'></i></a> &nbsp;` +
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
            url: '/admin/appointment/' + id + '',
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

function startDate(date) {
    return moment(date).format('DD/MM/Y');
}
