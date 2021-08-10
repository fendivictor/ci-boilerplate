$.widget.bridge('uibutton', $.ui.button)
const baseUrl = "<?= base_url(); ?>";
const currentMonth = "<?= date('m') ?>";
const msg = {
    fail: {
        save: "<?= lang('ajax_msg_save_fail') ?>",
        update: "<?= lang('ajax_msg_update_fail') ?>",
        delete: "<?= lang('ajax_msg_delete_fail') ?>",
        load: "<?= lang('ajax_msg_load_fail') ?>"
    },
    confirmation: "<?= lang('confirm'); ?>",
    confirm: {
        save: "<?= lang('confirm_save'); ?>",
        update: "<?= lang('confirm_update'); ?>",
        delete: "<?= lang('confirm_delete'); ?>"
    },
    btn: {
        yes: "<?= lang('btn_yes') ?>",
        no: "<?= lang('btn_no') ?>"
    }, 
    logout: {
        text: "<?= lang('menu_logout'); ?>",
        confirm: "<?= lang('confirm_logout'); ?>"
    }
}

const defaultDeleteConfirmation = {
    title: msg.confirmation,
    text: msg.confirm.delete,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: msg.btn.yes,
    cancelButtonText: msg.btn.no
};

function blockUI() {
    $.blockUI({
        css: {
            backgroundColor: 'transparent',
            border: 'none'
        },
        message: '<div class="loader"></div>',
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
        message: '<div class="loader"></div>',
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

$(document).ajaxStart(function() {
    blockUI(); 
});

$(document).ajaxStop(function() {
    unBlockUI(); 
});

function ajaxSubmitConfig(url, formData) {
    return {
        url: `${url}`,
        type: "post",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
    };
}

function ajaxSubmitData(url, formData, onSuccess) {
    let config = ajaxSubmitConfig(url, formData);

    $.ajax(config)
        .done(function(data) {
            onSuccess(data);
        })
        .fail(function(err) {
            toastr.error(msg.fail.save);
        })
}

async function createDropdown(element, url, placeholder, selected) {
    await fetch(url, {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
        .then(function(result) {
            return result.json();
        })
        .then(function(data) {
            if (data) {
                $(element).find("option").remove();
                data.forEach(function(val, i) {
                    $(element).append(`<option value="${val.id}">${val.text}</option>`);
                });
            }

            $(element).select2({
                placeholder: placeholder
            });

            $(element).val(null).trigger('change');
        })
        .catch(function(err) {
            toastr.error(msg.fail.load);
        });

    if (selected) {
        $(element).val(selected).trigger("change");
    }
}

$(function() {
    $(".num-only").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, dont do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
})
