$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function errorMessage(response) {
    if (response.status === 400) {
        const data = JSON.parse(response.responseText);
        alert(data.message)
    } else if (response.status === 500) {
        const data = JSON.parse(response.responseText);
        alert(data.message)
    }
}

function createdAt(date) {
    return moment(date).format('DD/MM/Y H:mm:ss');
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(document).ready(function () {
    const pendingOrderCount = $("#pendingOrderCount").val()
    const pendingRefundRequests = $("#pendingRefundRequests").val()
    const label_pendingServices = $("#servicePendingApprovalCount").val()
    if (pendingOrderCount != "0") {
        $("#label_pendingOrderCount").append(`<span class="pull-right-container"><small class="label pull-right bg-green" title="Bekleyen siparişler">${pendingOrderCount}</small></span>`);
    }
    if (pendingRefundRequests != "0") {
        $("#label_pendingRefundRequests").append(`<span class="pull-right-container"><small class="label pull-right bg-red" title="İade talebi oluşturulanlar">${pendingRefundRequests}</small></span>`);
    }
    if (label_pendingServices != "0") {
        $("#label_pendingServices").append(`<span class="pull-right-container"><small class="label pull-right bg-orange" title="Bekleyen Servisler">${label_pendingServices}</small></span>`);
    }

})

// SITE SEARCH END
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

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

