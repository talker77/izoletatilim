$('#serviceTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/services',
        data: {
            country: $("#countryFilter").val(),
            serviceType: $("#serviceTypeFilter").val(),
            type: $("#typeFilter").val(),
            company: $("#company").val(),
            status: getUrlParameter('status'),
        }
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
/**
 * Firmaların rezerv. listelendiği alan
 */
$('#table-appointments').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/services/appointments/' + $("#serviceID").val()
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {
            data: 'service_company', name: 'service_company_id',
            render: function (data, type, row) {
                return data
                    ? `<a href='/admin/company-services/${data.id}/edit/'>${data.title}</a>`
                    : `-`;
            }
        },
        {
            data: 'service_company.company', name: 'service_company_id',
            render: function (data, type, row) {
                return data
                    ? `<a href='/admin/product/company/edit/${data.id}'>${data.title}</a>`
                    : `-`;
            }
        },
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
            data: 'status', name: 'status',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
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

/**
 *  StoreUser ların kendi ekledikleri rezervler.
 */
$('#table-service-store-appointments').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/services/appointments/' + $("#serviceID").val()
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
            data: 'status', name: 'status',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
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
                return `<a href="javascript:showUpdateModal(${data})"><i class='fa fa-edit'></i></a> &nbsp;` +
                    `<a href="javascript:void(0)" class="delete-item" data-id="${data}"><i class='fa fa-trash'></i></a>`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

function showUpdateModal(serviceAppointmentID) {
    $.ajax({
        url: '/admin/services/appointments/detail/' + serviceAppointmentID + '',
        method: 'GET',
        success: function (data) {
            $("#serviceAppointmentUpdateModal").modal()
            $("#serviceAppointmentUpdateModal .detail").html(data)
        },
        error: function (xhr) {
            alert(xhr)
        }
    })

}

/**
 * yerel/uzak Hizmeti siler
 */
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

$('#table-service-store-appointments').on('click', '.delete-item', function () {
    if (confirm('Rezervasyonu silmek istediğine emin misin ? ')) {
        const id = $(this).data('id')
        const self = this;
        $.ajax({
            url: '/admin/services/appointments/' + id + '',
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

function deleteImage(id) {
    if (confirm(' fotoğraf silinecektir onaylıyor musunuz ?')) {
        $.ajax({
            url: '/admin/services/delete-image/' + id + '',
            method: 'DELETE',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status) {
                    $("#productImageCartItem" + id + "").fadeOut(600, function () {
                        this.remove();
                    });
                } else {
                    alert(data);
                }
            }
        })
    }
}

/**
 * Hizmet tipi değiştiğinde alt özelliklerini getir
 */
$('#id_type_id').on('change', function () {
    const type = $(this).val()
    $.ajax({
        url: `/admin/service/attributes/get-attributes-by-type/${type}`,
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            // var sData = $.map(data, function (obj) {
            //     obj.id = obj.id;
            //     obj.text = obj.title;
            //     return obj;
            // });
            $("#attributes > option").remove()
            $(data.results).each(function (index, elem) {
                console.log(elem);
                var option = new Option(elem.title, elem.id, false, false);
                $("#attributes").append(option).trigger('change').select2()
            })
        },
        error: function (xhr) {
            alert(xhr)
        }
    })
});

