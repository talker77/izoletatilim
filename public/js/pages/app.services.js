/**
 sayfalama işlemi yapar
 */
$(document).ready(function () {
    // fillMinPrices()

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "villa-filter?page=" + page,
            data: {
                query: () => getParameterByName('query'),
                startDate: () => getParameterByName('startDate') || '',
                endDate: () => getParameterByName('endDate') || '',
                order: () => $("#orderby").val() || getParameterByName('order') || 'created_at',
                sort: () => $("#orderby option:selected").data('sort') || getParameterByName('sort') || 'desc',
                minPrice: () => $("#hdnMinPrice").val() || 0,
                maxPrice: () => $("#hdnMaxPrice").val() || 0,
                attributes: () => $("#hdnSelectedAttributes").val(),
                point: () => $("#hdnFilterPoint").val() || getParameterByName('point') || '',
                state: () => getParameterByName('state') || '',
                country: () => getParameterByName('country') || '',
                district: () => getParameterByName('district') || '',
                type: () => getParameterByName('type') || '',
                person: () => $("#personSelect").val() || getParameterByName('person') || '',
            },
            success: function (data) {
                $('.resultCount').text(data.count);
                $('#villaContainer').html(data.html);
                // fillMinPrices()
            }
        });
    }


    /***
     *kategori sıralama
     */
    $("#orderby,#personSelect").on('change', function () {
        fetch_data(1)
    });


    $("#attributeFilter a").on('click', function (event) {
        event.preventDefault();
        getSelectedAttributes()

    })

    function getSelectedAttributes() {
        const selectedAttributes = [];
        setTimeout(function () {
            var selectedAt = $.map($("#attributeFilter li.active a"), function (option) {
                return parseFloat($(option).data('id'));
            })
            $("#hdnSelectedAttributes").val(selectedAt)
            fetch_data(1)
        }, 50)

    }


    /**
     *  Price Range slider
     */
    tjq(document).ready(function () {
        tjq("#price-range").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [getParameterByName('minPrice') || $("#hdnCanFilterMinPrice").val(), getParameterByName('maxPrice') || $("#hdnCanFilterMaxPrice").val()],
            slide: function (event, ui) {
                tjq(".min-price-label").html("₺ " + ui.values[0]);
                tjq(".max-price-label").html("₺ " + ui.values[1]);
            },
            stop: function (event, ui) {
                $("#hdnMinPrice").val(ui.values[0])
                $("#hdnMaxPrice").val(ui.values[1])
                fetch_data(1)

            }
        });
        tjq(".min-price-label").html("₺ " + tjq("#price-range").slider("values", 0));
        tjq(".max-price-label").html("₺ " + tjq("#price-range").slider("values", 1));

        tjq("#rating").slider({
            range: "min",
            value: getParameterByName('point') || 0,
            min: 0,
            max: 5,
            slide: function (event, ui) {

            },
            stop: function (event, ui) {
                $("#hdnFilterPoint").val(ui.value * 2)
                fetch_data(1)
            }
        });
    });


    function fillMinPrices() {
        $(".service-item").each(function (index, elem) {
            // console.log(elem)
            let appointmentPrices = $(elem).find('.appointment-prices')
            let prices = [];
            $(appointmentPrices).find('.min-price').each(function (aIndex, aElem) {
                const price = parseFloat($(aElem).text())
                if (!isNaN(price)) {
                    prices.push(price)
                }

            })
            const minPrice = Math.min.apply(null, prices);
            let i = prices.indexOf(Math.min.apply(null, prices));
            let redirectTo = $(appointmentPrices[i]).find('.redirect-to').text()
            let companyName = $(appointmentPrices[i]).find('.company-name').text()
            $(elem).find(".min_price").text(minPrice)
            $(elem).find(".main_redirect").attr('href', redirectTo)
            $(elem).find(".company_name").text(companyName)
        })
    }

    /**
     *  Service Detail Date Inputs
     */
    $('#sandbox-container .input-group.date').datepicker({
        // maxViewMode: 0,
        startDate: '-0d',
        clearBtn: true,
        language: "tr",
        todayHighlight: true,
        updateViewDate: false,
        autoHide: true,
        autoClose: true,
        format : "dd-mm-yyyy"
    }).on('changeMonth', function (e) {
        var month = e.date.getMonth() + 1;
        getReservedDaysOfMonth($("#serviceID").val(), month, "#sandbox-container .input-group.date");
    }).on('changeDate', function(){
        $(this).datepicker('hide');
    });

    /**
     * Service Detail date input onfocus
     */
    $('#sandbox-container .input-group.date').click(function () {
        getReservedDaysOfMonth($("#serviceID").val(), new Date().getMonth() + 1)
    })

    /**
     * Service get reservations dates by Month
     * @param {number} serviceId hizmet slug
     * @param {*} month month js tarafında n-1 oluyor laravel tarafında 1-12 arası bu yüzden +1 ile gönderiniz.
     * @param {*} selector jquery selector
     */

    function getReservedDaysOfMonth(serviceId, month = (new Date().getMonth() + 1), selector = '#sandbox-container .input-group.date') {
        $.ajax({
            url: `/service/reservations/${serviceId}/get-reserved-days`,
            method: 'POST',
            data: {
                month: month
            },
            success: function (data) {
                $(selector).datepicker('setDatesDisabled', data.reservedDaysArray)
            }
        });
    }

});

/**
 *  Hizmet Fiyat/Bilgi vd. detayları getirir.
 */
function getServiceDetail(serviceId) {
    $.ajax({
        url: "/service/tabs/" + serviceId,
        method: 'GET',
        data: {
            startDate: getParameterByName('startDate'),
            endDate: getParameterByName('endDate'),
        },
        success: function (data) {
            $(`#serviceListItem-${serviceId}`).html(data)
        }
    });
}

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

/**
 * Hizmet detayda tarih kontrol
 */
$("#startDate,#endDate").on('change', function () {
    $("#reservationMessageBox").html('').hide()
    $.ajax({
        url: "/service/check-appointment/" + $("#serviceID").val(),
        method: 'POST',
        data: {
            start_date: $("#startDate").val(),
            end_date: $("#endDate").val(),
        },
        success: function (data) {
            $("#priceContainer").removeClass('hidden')
            $("#reservationBtn").removeClass('btn-appointment-error').text('Rezervasyon Talebi')
            const appointment = data.data.appointment;
            $("#date-filter .price-text,#perDayPrice").text(appointment.price)
            $("#dayCount").text(data.data.dayCount)
            $("#totalDayPrice").text(parseFloat(data.data.subTotal).toFixed(2))
            $(".total-price-value").text(parseFloat(data.data.subTotal).toFixed(2) + "₺")
            $("#hdnReservationStatus").val(1)
        },
        error: function (xhr) {
            $("#priceContainer").addClass('hidden')
            if (xhr.status == 400) {
                $("#reservationMessageBox").show().text(xhr.responseJSON.message)
            }
            if (xhr.status == 422) {
                var response = JSON.parse(xhr.responseText);
                var errorString = '';
                $.each(response.errors, function (key, value) {
                    errorString += '' + value + '</br></br></br>';
                });
                $("#reservationMessageBox").show().html(errorString)
            }
            $("#hdnReservationStatus").val(0)
            $("#date-filter .price-text,#perDayPrice,#totalDayPrice,.total-price-value").text("-")
            $("#reservationBtn").addClass('btn-appointment-error').text('Uygun Rezervasyon Bulunamadı')
        }
    });
})
