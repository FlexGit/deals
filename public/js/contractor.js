$(document).ready(function() {
	// Файлы контрагента
	$(document).on('change', '.custom-file-input', function() {
		$(this).next('.custom-file-label').text(this.files[0].name);
	});

	$(document).on('click', '.js-get-passport', function() {
		window.open($(this).data('path'), '_blank').focus();
	});

	function getContractorList(loadMore) {
		var $table = $('#contractorTable'),
			$tbody = $table.find('tbody.body');

		var $tr = $('tr.odd[data-id]:last'),
			id = (loadMore && $tr.length) ? $tr.data('id') : 0;

		$.ajax({
			type: 'GET',
			url: $table.data('action'),
			data: {
				"filter-contractor": $('#filter-contractor').val(),
				"id": id,
			},
			dataType: 'json',
			async: true,
			cache: false,
			global: false,
			success: function(D) {
				console.log(D);
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Ошибка, попробуйте повторить операцию позже');
					return;
				}

				if (D.html) {
					if (loadMore) {
						$tbody.append(D.html);
					} else {
						$tbody.html(D.html);
					}
					$(window).data('ajaxready', true);
				} else {
					if (!id) {
						$tbody.html('<tr><td colspan="30" class="text-center">Ничего не найдено</td></tr>');
					}
				}
			}
		});
	}

	$(document).on('keyup', '#filter-contractor', function() {
		getContractorList(false);
	});

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
				toastr.success("", "Контрагент #" + D.name + " успешно удален");
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

	$(document).on('click', '.js-delete-passport', function() {
		if (!confirm('Вы уверены, что хотите удалить версию паспорта?')) {
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
				toastr.success("", "Версия паспорта " + D.series + " " + D.number + " успешно удалена");
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

				toastr.success("", "Контрагент #" + D.name + " успешно сохранен");
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

	// Сохранение паспорта
	$(document).on('submit', '#passport-form', function(e) {
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

				toastr.success("", "Версия паспорта " + D.series + " " + D.number + " успешно сохранена");
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

	getContractorList(false);

	$(window).on('scroll', function() {
		if ($(window).data('ajaxready') === false) return;

		var $tr = $('tr.odd[data-id]:last');
		if (!$tr.length) return;

		if ($tr.isInViewport()) {
			$(window).data('ajaxready', false);
			getContractorList(true);
		}
	});
});