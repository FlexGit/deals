$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).on('submit', '#auth-form', function (e) {
		e.preventDefault();

		var $this = $(this);

		$.ajax({
			url: $this.attr('action'),
			type: $this.attr('method'),
			dataType: 'json',
			data: $this.serializeArray(),
			success: function (response) {
				console.log(response);
				if (response.success) {
					location.reload();
				} else {
					alert('Внимание! Доступ в приложение невозможен.\n' + response.reason);
				}
			},
			error: function (jqXHR) {
				var response = $.parseJSON(jqXHR.responseText);
				if(response.message) {
					alert(response.message);
				}
			}
		});
	});

	$('#auth-modal').modal();
});
