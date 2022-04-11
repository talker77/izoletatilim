// $.validator.setDefaults({
//     submitHandler: function () {
//         alert("submitted!");
//     }
// });

$(document).ready(function () {

    $("#paymentForm").validate({
        rules: {
            cardNumber: {
                required: true,
                minlength: 19
            },
            holderName: {
                required: true,
                minlength: 4
            },
            cvv: {
                required: true,
                minlength: 3,
                maxlength: 3
            },
            checkoutTerms: "required",
            distanceSellingContract: "required",
            cardExpireDateMonth: "required",
            cardExpireDateYear: "required",
            // invoice address
            title: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            phone: {
                required: true,
                maxlength: 20
            },
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            surname: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            state_id: {
                required: true
            },
            district_id: {
                required: true
            },
            address: {
                minlength: 6,
                maxlength: 255,
                required: true
            },
            email: {
                email: true,
                maxlength: 50,
                required: true
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            element.addClass('error-border')
            // Add the `help-block` class to the error element
            error.addClass("has-error");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("div"));
            } else {
                error.insertAfter(element);
            }

        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-5").addClass("has-error").removeClass("has-success");
            $(element).addClass("error-border").removeClass("success-border");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("success-border").removeClass("has-error").removeClass('error-border');
        }
    });
});


function getInstallmentDetails(totalPrice) {
    let creditCartNumber = $("#kartno").val();
    let listedInstallmentCount = $("#iyzico_installment tbody tr").length;
    creditCartNumber = creditCartNumber.replace(/\-/g, '');
    if (creditCartNumber.length === 16) {
        $.ajax({
            type: 'GET',
            url: '/odeme/taksit-getir',
            dataType: 'json',
            data: {
                totalPrice: totalPrice,
                creditCartNumber: creditCartNumber
            }, success: function (data) {
                $("#taksitContainer").show();
                $("#iyzico_installment tbody").children('tr').remove()
                $(".spBankName").text('- ' + data.installmentDetails[0].bankName);
                $.each(data.installmentDetails[0].installmentPrices, function (i, item) {
                    $tr = $('<tr>').append(
                        $('<td>').html('<span> <input type="radio" class="secili_taksit" name="secilen_taksit" value=' + item.installmentNumber + '></span>'),
                        $('<td>').text("₺" + item.installmentPrice),
                        $('<td>').text(item.installmentNumber),
                        $('<td>').text("₺" + item.totalPrice),
                    );
                    $("#iyzico_installment").append($tr);
                });
                $("#iyzico_installment input[type='radio']").eq(0).click();
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
            }
        })
    }
    if (creditCartNumber.length === 0) {
        $("#iyzico_installment tbody").children('tr').remove()
    }

}

$(document).on('change', '.secili_taksit', function () {
    console.log('changed')
    console.log($(this).val())
    $("#taksit_sayisi").val($(this).val())
})



