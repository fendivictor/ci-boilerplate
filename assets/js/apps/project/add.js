$(document).ready(function() {
	$("#form-data").submit(function(e) {
		e.preventDefault();
		let formData = new FormData($(this)[0]);

		swalWithBootstrapButtons.fire({
		  	title: msg.confirmation,
		  	text: msg.confirm.save,
		  	showCancelButton: true,
		  	confirmButtonText: msg.btn.yes,
		  	cancelButtonText: msg.btn.no,
		  	reverseButtons: true
		}).then((result) => {
		  	if (result.value) {
		  		let config = {
					url: baseUrl + 'ajax/Ajax/add_project',
					data: formData,
					type: 'post',
					dataType: 'json',
					processData: false,
					contentType: false
				}

				blockUI();

				$.ajax(config)
					.done(function(data) {
						unBlockUI();
						(data.status == 1) ? Swal.fire('', data.message, 'success').then(function(){ window.location.href = baseUrl + 'Project/list' }) : Swal.fire('', data.message, 'error');
					})
					.fail(function(e) {
						unBlockUI();
						toastr.error(msg.fail.save);
					});
		  	}
		});

		return false;
	});

	$("#tec-plan-kirim").datepicker({
		format: 'dd/mm/yyyy',
		uiLibrary: 'bootstrap4'
	});

	$("#pattern-plan-kirim").datepicker({
		format: 'dd/mm/yyyy',
		uiLibrary: 'bootstrap4'
	});

	$("#fabric-plan-kirim").datepicker({
		format: 'dd/mm/yyyy',
		uiLibrary: 'bootstrap4'
	});

	$("#aksesories-plan-kirim").datepicker({
		format: 'dd/mm/yyyy',
		uiLibrary: 'bootstrap4'
	});

	$("#due-date").datepicker({
		format: 'dd/mm/yyyy',
		uiLibrary: 'bootstrap4'
	});
});