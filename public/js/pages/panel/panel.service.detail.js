function countryOnChange(self) {
    $.ajax({
        url: '/locations/get-states-by-country/' + self.value + '',
        success: function (data) {
            bindStates(data);
        }
    })
}

function citySelectOnChange(self) {
    $.ajax({
        url: '/locations/getTownsByCityId/' + self.value + '',
        success: function (data) {
            bindDistricts(data);
        }
    })
}


function bindStates(cities) {
    $("#id_state_id option").not(':eq(0)').remove();
    $(cities).each(function (index, element) {
        $("#id_state_id").append('<option value="' + element.id + '">' + element.title + '</option>')
    })
}


function bindDistricts(items) {
    $("#id_district_id option").not(':eq(0)').remove();
    $(items).each(function (index, element) {
        $("#id_district_id").append('<option value="' + element.id + '">' + element.title + '</option>')
    })
}

function deleteImage(id) {
    if (confirm(' fotoğraf silinecektir onaylıyor musunuz ?')) {
        $.ajax({
            url: '/kullanici/services/delete-image/' + id + '',
            method: 'DELETE',
            dataType: 'json',
            success: function (data) {
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
$('#serviceType').on('change', function () {
    const type = $(this).val()
    $.ajax({
        url: `/kullanici/services/get-attributes-by-type/${type}`,
        dataType: 'json',
        method: 'GET',
        success: function (data) {
            // var sData = $.map(data, function (obj) {
            //     obj.id = obj.id;
            //     obj.text = obj.title;
            //     return obj;
            // });
            $("#attributeContainer").html('')
            $(data.results).each(function (index, elem) {
                var checkbox =
                    `<div class="col-md-2">
                        <label>
                                <input type="checkbox" value="${elem.id}"
                                       name="attributes[]"> ${elem.title}
                        </label>
                    </div>`;
                $("#attributeContainer").append(checkbox)
            })
        },
        error: function (xhr) {
            alert(xhr)
        }
    })
});

/**
 *  StoreUser ların kendi ekledikleri rezervler.
 */
const table = $('#table-service-store-appointments').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/kullanici/tables/appointments/' + $("#serviceID").val()
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

/**
 * PUT -   rezervasyon moodal ile bilgileri güncelleme
 */
$(document).on('click', '.btn-update-appointment', function () {
    const appointmentId = $(this).data('id')
    var values = $("#modalUpdate").serialize();

    $.ajax({
        url: '/kullanici/services-appointments/' + appointmentId + '',
        method: 'PUT',
        data: values,
        success: function (data) {
            $("#serviceAppointmentUpdateModal").modal('hide')
            successMessage()
            console.log(table);
            table.ajax.reload(null, false)
        },
        error: function (xhr) {
            errorMessage(xhr)
        }
    })
})

/**
 * POST -   rezervasyon appointment create event
 */
$(document).on('click', '.btn-create-appointment', function () {
    var values = $("#createServiceAppointmentForm").serialize();
    const serviceID = $(this).data('service-id')
    $.ajax({
        url: '/kullanici/services-appointments/store/' + serviceID,
        method: 'POST',
        data: values,
        success: function (data) {
            $("#createServiceModal").modal('hide')
            successMessage()
            table.ajax.reload(null, false)
        },
        error: function (xhr) {
            errorMessage(xhr)
        }
    })
})
