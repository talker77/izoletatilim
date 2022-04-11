function showNotificationContent(notificationID) {
    console.log('click')
    $("#notificationModal").modal('show')
    $.ajax({
        type: 'GET',
        url: `/kullanici/notifications/${notificationID}`,
        // dataType: 'json',
        success: function (data) {
            console.log(data)
            $("#notificationModal .modal-content").html(data)
        }, error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
        }
    })
}



