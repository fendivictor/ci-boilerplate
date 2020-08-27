$(() => {
	const dtTable = $("#dt-table").DataTable({
		processing: true,
		serverSide: true,
		order: [[0, 'desc']],
		ajax: {
			url: baseUrl + 'ajax/Datatable/dt_notification',
			type: 'post'
		},
		searching: false,
		order: [[8, 'desc']],
		columnDefs: [
			{targets: 0, data: 'no', width: 80},
			{targets: 1, data: 'type', width: 100, 'className': 'text-center'},
			{targets: 2, data: 'brand', width: 100, 'className': 'text-center'},
			{targets: 3, data: 'kontrak', width: 100, 'className': 'text-center'},
			{targets: 4, data: 'item', width: 100, 'className': 'text-center'},
			{targets: 5, data: 'style', width: 120, 'className': 'text-center'},
			{targets: 6, data: 'field', width: 120, 'className': 'text-center'},
			{targets: 7, data: 'value', width: 120, 'className': 'text-center'},
			{targets: 8, data: 'update', width: 120, 'className': 'text-center'}
		]
	});

	$("#btn-tampil").click(function() {
		let keyword	= $('#keyword').val();
		dtTable.ajax.url(baseUrl + 'ajax/Datatable/dt_notification?keyword=' + keyword).load();
	});
});