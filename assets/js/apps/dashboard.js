$(document).ready(function() {
	const type = ['delivery', 'process', 'shipment', 'finish'];
	const config = {
		datatable: {
			delivery: baseUrl + 'ajax/Datatable/dashboard_list?type=sample-on-delivery',
			process: baseUrl + 'ajax/Datatable/dashboard_list?type=sample-on-process',
			shipment: baseUrl + 'ajax/Datatable/dashboard_list?type=sample-on-shipment',
			finish: baseUrl + 'ajax/Datatable/dashboard_list?type=sample-finish'
		},
		counter: { 
			url : {
				delivery: baseUrl + 'ajax/Ajax/counter_dashboard?type=sample-on-delivery',
				process: baseUrl + 'ajax/Ajax/counter_dashboard?type=sample-on-process',
				shipment: baseUrl + 'ajax/Ajax/counter_dashboard?type=sample-on-shipment',
				finish: baseUrl + 'ajax/Ajax/counter_dashboard?type=sample-finish'
			},
			el: {
				delivery: 'counter-sample-on-delivery',
				process: 'counter-sample-on-process',
				shipment: 'counter-sample-on-shipment',
				finish: 'counter-sample-finish'
			}
		}
	}

	for (i in type) {
		let getCounter = $.get(config.counter.url[type[i]]);
		let elTarget = config.counter.el[type[i]];

		$.when(getCounter)
			.done(function(data) {
				let response = JSON.parse(data);

				$(`#${elTarget}`).html(response.jumlah);
			});
	}

	const columnDefinition = {
		process: [
			{targets: 0, data: 'no'},
			{targets: 1, data: 'type'},
			{targets: 2, data: 'brand'},
			{targets: 3, data: 'kontrak'},
			{targets: 4, data: 'item'},
			{targets: 5, data: 'style'},
			{targets: 6, data: 'status'}
		],
		default: [
			{targets: 0, data: 'no'},
			{targets: 1, data: 'type'},
			{targets: 2, data: 'brand'},
			{targets: 3, data: 'kontrak'},
			{targets: 4, data: 'item'},
			{targets: 5, data: 'style'}
		]
	}	

	const dtDelivery = $("#tb-sample-on-delivery").DataTable({
		processing: true,
		serverSide: true,
		order: [[0, 'desc']],
		ajax: {
			url: config.datatable.delivery,
			type: 'post'
		},
		columnDefs: columnDefinition.default
	});

	const dtProcess = $("#tb-sample-on-process").DataTable({
		processing: true,
		serverSide: true,
		order: [[0, 'desc']],
		ajax: {
			url: config.datatable.process,
			type: 'post'
		},
		columnDefs: columnDefinition.process
	});

	const dtShipment = $("#tb-sample-on-shipment").DataTable({
		processing: true,
		serverSide: true,
		order: [[0, 'desc']],
		ajax: {
			url: config.datatable.shipment,
			type: 'post'
		},
		columnDefs: columnDefinition.default
	});

	const dtFinish = $("#tb-sample-finish").DataTable({
		processing: true,
		serverSide: true,
		order: [[0, 'desc']],
		ajax: {
			url: config.datatable.finish,
			type: 'post'
		},
		columnDefs: columnDefinition.default
	});
});