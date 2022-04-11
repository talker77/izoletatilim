function createdAt(date) {
    return moment(date).format('DD/MM/Y H:mm:ss');
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
 * istek listesine ekler
 * @param productId
 */
function addToFavorites(productId) {
    // $.post(`/kullanici/favoriler/${productId}`, function (data) {
    //     console.log(data)
    //     if (data.status === true) {
    //         alert("Favorilere Eklendi")
    //     }
    // }).fail((response, error) => {
    //     console.log(response)
    //     if (response.status === 401) {
    //         alert('Favorilere eklemeniz için giriş yapmanız gerek.')
    //     }
    // })

    $.ajax({
        url: `/favoriler/${productId}`,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.status === true) {
                alert("Favorilere Eklendi")
            }
        }, error: function (xhr, status, error) {
            if (xhr.status) {
                alert('Favorilere eklemek için giriş yapmalısın.')
            }
        }
    });
}

function errorMessage(response) {
    if (response.status === 400 || response.status === 422) {
        const data = JSON.parse(response.responseText);
        let message = data.message;
        if (data.errors) {
            Object.keys(data.errors).forEach(key => {
                message = data.errors[key]
            })
        }
        alert(message)
    }
}

function successMessage(message = 'İşlem başarılı şekilde gerçekleşti') {
    toastr.success(message, 'Başarılı !')

}


$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $search = $('#villaSearch');

    $search.autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/search',
                type: 'GET',
                dataType: 'json',
                data: request,
                success: function (data) {
                    response($.map(data, function (value, key) {
                        let label = value.title;
                        let options = {};
                        switch (value.search_type) {
                            case 'district':
                                label = `${value.title}/${value.state.title}`;
                                options.district_id = value.id
                                break;
                            case 'state':
                                label = `${value.title}/${value.country.title}`;
                                options.state_id = value.id
                                break;
                            case 'country':
                                options.country_id = value.id;
                                break
                            case 'location':
                                options.country_id = value.country_id;
                                options.state_id = value.state_id;
                                options.district_id = value.district_id;
                                break
                            default:
                                break;
                        }

                        return {
                            label: label,
                            value: value.title,
                            search_type: value.search_type,
                            options: options
                        };
                    }));
                }
            });
        },
        focus: function (event, ui) {
            $("#hdnCountry,#hdnState,#hdnDistrict").val('')
            $search.val(ui.item.title);
        },
        select: function (event, ui) {
//                    window.location.href = 'https://www.google.com/#q=' + ui.item.uye_adi;
            $("#hdnCountry,#hdnState,#hdnDistrict").val('')
            switch (ui.item.search_type) {
                case 'district':
                    $("#hdnDistrict").val(ui.item.options.district_id)
                    break;
                case 'state':
                    $("#hdnState").val(ui.item.options.state_id)
                    break;
                case 'country':
                    $("#hdnCountry").val(ui.item.options.country_id)
                    break;
                case 'location':
                    $("#hdnCountry").val(ui.item.options.country_id)
                    $("#hdnState").val(ui.item.options.state_id)
                    $("#hdnDistrict").val(ui.item.options.district_id)
                    break;
                default:
                    break;
            }
        }
    }).keydown(function (e) {
        if (e.keyCode === 8) {
            $("#hdnCountry,#hdnState,#hdnDistrict").val('')
        }
    });
    var action;
    $(".number-spinner button").click(function () {
        let btn = $(this);
        let input = btn.closest('.number-spinner').find('input');
        btn.closest('.number-spinner').find('button').prop("disabled", false);

        if (btn.attr('data-dir') == 'up') {
            if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
                input.val(parseInt(input.val()) + 1);
            } else {
                btn.prop("disabled", true);
            }
        } else if (parseInt(input.val()) > 0) {
            if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
                input.val(parseInt(input.val()) - 1);
            } else {
                btn.prop("disabled", true);
            }
        }
    });

    //
    // $search.data('ui-autocomplete-input')._renderItem = function (ul, item) {
    //     console.log(ul)
    //     item.label = item.title
    //     var $li = $('');
    //
    //     $li.html('<a href="#">' +
    //         '<img src="' + item.id + '" />' +
    //         '<span class="username">' + item.title + '</span>' +
    //         '<span class="email">' + item.title + '</span>' +
    //         '</a>');
    //
    //     return $li.appendTo(ul);
    //
    // };
});
