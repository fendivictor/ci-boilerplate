function blockUI() {
    $.blockUI({
        css: {
            backgroundColor: 'transparent',
            border: 'none'
        },
        message: '<div class="spinner"></div>',
        baseZ: 1500,
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.7,
            cursor: 'wait'
        }
    });
}

function unBlockUI() {
    $.unblockUI();
}

function blockModal() {
    $(".modal-content").block({
        css: {
            backgroundColor: 'transparent',
            border: 'none'
        },
        message: '<div class="spinner"></div>',
        baseZ: 1500,
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.7,
            cursor: 'wait'
        }
    });
}

function unBlockModal() {
    $(".modal-content").unblock();
}

$("#btn-logout").click(function(){
    Swal.fire({
        title: msg.logout.text,
        text: msg.logout.confirm,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: msg.btn.yes,
        cancelButtonText: msg.btn.no
    }).then((result) => {
        if (result.value) {
            var config = {
                url: baseUrl + 'Login/clear_session'
            }

            $.ajax(config)
            .then(function(data) {
                window.location.href = baseUrl;
            })
            .fail(function(){
                Toast.fire({
                    type: 'error',
                    title: msg.fail.save
                });
            });
        }
    });
});

 const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger mr-2'
    },
    buttonsStyling: false
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}