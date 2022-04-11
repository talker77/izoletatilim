$('#service-reservations').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/kullanici/tables/reservations/',
        data: {
            'serviceId': getParameterByName('serviceId'),
            'status': getParameterByName('status'),
        }
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {
            data: 'start_date', name: 'start_date',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'end_date', name: 'end_date',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'price', name: 'price',
            render: function (data, type, row) {
                return `${data} ₺`
            }
        },
        {
            data: 'total_price', name: 'total_price',
            render: function (data, type, row) {
                return `${data} ₺`
            }
        },
        {
            data: 'service_id', name: 'service.title',
            render: function (data, type, row) {
                return row['service']
                    ? (
                        $("#hdnUserRoleID").val() == 2 // 2 = Role::STORE
                            ? `<a href="/kullanici/services/${data}/edit">${row['service']['title']}</a>`
                            : `<a href="${row['service']['slug']}">${row['service']['title']}</a>`
                    )
                    : '-'
            }
        },
        {
            data: 'user_id', name: 'user_id',
            render: function (data, type, row) {
                return row ['user']
                    ? `${row['user']['name']}` + (row['user']['username'] ? row['user']['surname'] : '')
                    : data
            },
            visible: $("#hdnUserRoleID").val() == 2
        },
        {
            data: 'status_text', name: 'status'
        },
        {
            data: 'updated_at', name: 'updated_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href="/kullanici/reservations/${data}"><i class='fa fa-edit'></i></a> &nbsp;`;
            },
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

/**
 * rezervasyon güncelleme modal gösterir
 * @param serviceAppointmentID
 */
function showUpdateModal(serviceAppointmentID) {
    $.ajax({
        url: '/kullanici/services-appointments/detail/' + serviceAppointmentID + '',
        method: 'POST',
        success: function (data) {
            $("#serviceAppointmentUpdateModal").modal()
            $("#serviceAppointmentUpdateModal .detail").html(data)
        },
        error: function (xhr) {
            alert(xhr)
        }
    })

}
