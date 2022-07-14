$(document).ready(function() {
	$(document).on('click', '.pagination a', function(e){
		e.preventDefault();
		getLegalEntityList($(this).attr('href').split('page=')[1]);
	});

	function getLegalEntityList(page) {
		var $list = $('.js-legal-entity-list');
		if (!$list.length) return;

		$.ajax({
			type: 'GET',
			url: $list.data('action'),
			data: { page: page},
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

				$list.html(D.html);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	}

	$(document).on('click', '.js-delete-legal-entity', function() {
		if (!confirm('Вы уверены, что хотите удалить юридическое лицо?')) {
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
				toastr.success("", "Юридическое лицо #" + D.legal_entity_name + " успешно удалено");
				setTimeout(function () {
					window.location.href = '/legal-entities';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	// Сохранение монеты
	$(document).on('submit', '#legal-entity-form', function(e) {
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

				toastr.success("", "Юридическое лицо #" + D.legal_entity_name + " успешно сохранено");
				setTimeout(function () {
					window.location.href = '/legal-entities';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? 'HTTP ' + textStatus + ': ' + errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	getLegalEntityList(1);
});