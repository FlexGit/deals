$(document).ready(function() {
	// Контрагенты в списке
	var $searchContractor = $('#search-contractor-name');
	$searchContractor.autocomplete({
		serviceUrl: $searchContractor.data('source-url'),
		minChars: 1,
		showNoSuggestionNotice: true,
		noSuggestionNotice: 'Ничего не найдено',
		type: 'POST',
		dataType: 'json',
		onSelect: function (suggestion) {
			getContractorList(1, suggestion.value);
		}
	}).keyup(function() {
		if (!$(this).val().length) {
			getContractorList(1,null);
		}
	});

	// Файлы контрагента
	$(document).on('change', '.custom-file-input', function() {
		$(this).next('.custom-file-label').text(this.files[0].name);
	});

	$(document).on('click', '.js-get-file', function() {
		window.open($(this).data('path'), '_blank').focus();
	});

	$(document).on('click', '.pagination a', function(e){
		e.preventDefault();
		getContractorList($(this).attr('href').split('page=')[1], $('#search-contractor-name').val());
	});

	function getContractorList(page, contractorName) {
		$.ajax({
			type: 'GET',
			url: '/contractor-list/',
			data: { page: page, contractor: contractorName },
			dataType: 'json',
			async: true,
			cache: false,
			global: false,
			success: function(D) {
				//console.log(D);
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Ошибка, попробуйте повторить операцию позже');
					return;
				}

				$('.js-contractor-list').html(D.html);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	}

	$(document).on('click', '.js-delete-contractor', function() {
		if (!confirm('Вы уверены, что хотите удалить контрагента?')) {
			return;
		}

		var $btn = $(this);

		$btn.attr('disabled', true);

		$.ajax({
			type: 'DELETE',
			url: $(this).data('action-url'),
			dataType: 'json',
			async: true,
			cache: false,
			global: false,
			processData: false,
			contentType: false,
			success: function(D) {
				$btn.attr('disabled', false);
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Ошибка, попробуйте повторить операцию позже');
					return;
				}
				toastr.success("", "Контрагент #" + D.contractor_id + " успешно удален");
				setTimeout(function () {
					window.location.href = '/contractors';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	// Сохранение контрагента
	$(document).on('submit', '#contractor-form', function(e) {
		e.preventDefault();

		var $form = $(this),
			$btn = $form.find('button[type="submit"]');

		$btn.attr('disabled', true);

		$.ajax({
			type: 'POST',
			url: $form.attr('action'),
			data: new FormData(this),
			dataType: 'json',
			async: true,
			cache: false,
			global: false,
			processData: false,
			contentType: false,
			success: function(D) {
				$btn.attr('disabled', false);
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Ошибка, попробуйте повторить операцию позже');
					return;
				}

				toastr.success("", "Контрагент #" + D.contractor_id + " успешно сохранен");
				setTimeout(function () {
					window.location.href = '/contractors';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? 'HTTP ' + textStatus + ': ' + errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	getContractorList(1,null);
});