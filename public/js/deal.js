$(document).ready(function() {
	// Контрагенты в карточке сделки
	var $contractor = $('#contractor-name');
	$contractor.autocomplete({
		serviceUrl: $contractor.data('source-url'),
		minChars: 1,
		showNoSuggestionNotice: true,
		noSuggestionNotice: 'Ничего не найдено',
		type: 'POST',
		dataType: 'json',
		onSelect: function (suggestion) {
			//console.log(suggestion.data);

			var $passport = $('#passport-id');
			$passport.val('').html('');

			$.each(suggestion.data.passports, function (i, item) {
				$passport.append($('<option>', {
					value: item.id,
					text : item.series + ' ' + item.number + ' от ' + item.issue_date + ' [создал ' + item.created_by.name + ' ' + moment(item.created_at).format('YYYY-MM-DD') + ', изменил ' + item.updated_by.name + ' ' + moment(item.updated_at).format('YYYY-MM-DD') + ']',
				}));
			});

			$passport.val(suggestion.data.lastPassport.id);

			$('#contractor-id').val(suggestion.id);
			$('#passport-series').val(suggestion.data.lastPassport.series);
			$('#passport-number').val(suggestion.data.lastPassport.number);
			$('#passport-date').val(suggestion.data.lastPassport.issue_date);
			$('#passport-office').val(suggestion.data.lastPassport.issue_office);
			$('#passport-zipcode').val(suggestion.data.lastPassport.zipcode);
			$('#passport-region').val(suggestion.data.lastPassport.region);
			$('#passport-city').val(suggestion.data.lastPassport.city);
			$('#passport-street').val(suggestion.data.lastPassport.street);
			$('#passport-house').val(suggestion.data.lastPassport.house);
			$('#passport-apartment').val(suggestion.data.lastPassport.apartment);
			if (suggestion.data.lastPassport.data_json.passport_file_1) {
				$('#passport-file-1').closest('.form-group').find('.preview-file').html('<a href="javascript:void(0)" class="js-get-file" data-path="/passport/' + suggestion.data.lastPassport.data_json.passport_file_1.ext + '/' + suggestion.data.lastPassport.data_json.passport_file_1.name +'">Открыть файл</a>');
			}
			if (suggestion.data.lastPassport.data_json.passport_file_2) {
				$('#passport-file-2').closest('.form-group').find('.preview-file').html('<a href="javascript:void(0)" class="js-get-file" data-path="/passport/' + suggestion.data.lastPassport.data_json.passport_file_2.ext + '/' + suggestion.data.lastPassport.data_json.passport_file_2.name + '">Открыть файл</a>');
			}
		}
	}).keyup(function() {
		if (!$(this).val().length) {
			$('#contractor-id, #passport-series, #passport-number, #passport-date, #passport-office, #passport-address, #passport-file-1, #passport-file-2').val('');
			$('#passport-file-1, #passport-file-2').closest('.form-group').find('.preview-file').html('');
			$('#passport-file-1').next('.custom-file-label').text('Первая страница паспорта');
			$('#passport-file-2').next('.custom-file-label').text('Вторая страница паспорта');
		}
	});

	$(document).on('change', '#passport-id', function() {
		var passportId = $(this).val();
		if (!passportId) return;

		$.ajax({
			type: 'GET',
			url: '/contractor/' + $('#contractor-id').val() + '/passport/' + $(this).val() + '/get',
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

				$('#passport-series').val(D.passport.series);
				$('#passport-number').val(D.passport.number);
				$('#passport-date').val(D.passport.issue_date);
				$('#passport-office').val(D.passport.issue_office);
				$('#passport-zipcode').val(D.passport.zipcode);
				$('#passport-region').val(D.passport.region);
				$('#passport-city').val(D.passport.city);
				$('#passport-street').val(D.passport.street);
				$('#passport-house').val(D.passport.house);
				$('#passport-apartment').val(D.passport.apartment);
				if (D.passport.data_json.passport_file_1) {
					$('#passport-file-1').next('label').text(D.passport.data_json.passport_file_1.name + '.' + D.passport.data_json.passport_file_1.ext);
					$('#passport-file-1').closest('.passport-container').find('.preview-file').html('<a href="javascript:void(0)" class="js-get-file" data-path="/contractor/' + D.passport.contractor_id + '/passport/' + D.passport.data_json.passport_file_1.ext + '/' + D.passport.data_json.passport_file_1.name +'">Открыть файл</a>');
				}
				if (D.passport.data_json.passport_file_2) {
					$('#passport-file-2').next('label').text(D.passport.data_json.passport_file_2.name + '.' + D.passport.data_json.passport_file_2.ext);
					$('#passport-file-2').closest('.passport-container').find('.preview-file').html('<a href="javascript:void(0)" class="js-get-file" data-path="/contractor/' + D.passport.contractor_id + '/passport/' + D.passport.data_json.passport_file_2.ext + '/' + D.passport.data_json.passport_file_2.name + '">Открыть файл</a>');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	$(document).on('change', '#filter-period, #filter-period-from, #filter-period-to, #filter-deal-type', function() {
		getDealList(false);
	});

	$(document).on('keyup', '#filter-contractor', function() {
		getDealList(false);
	});

	$(document).on('change', '#filter-period', function() {
		var $container = $('.filter-period-other-container');

		if ($(this).val() === 'other') {
			$container.removeClass('hidden');
		} else {
			$container.addClass('hidden');
		}
	});

	// Монеты
	$(document).on('focus', '.js-coin-name', function() {
		if ($(this).autocomplete() !== undefined ) return;

		$(this).autocomplete({
			serviceUrl: $(this).data('source-url'),
			minChars: 1,
			showNoSuggestionNotice: true,
			noSuggestionNotice: 'Ничего не найдено',
			type: 'POST',
			dataType: 'json',
			onSelect: function (suggestion) {
				var $coinContainer = $(this).closest('.coin-container');

				$coinContainer.find('.js-coin-id').val(suggestion.id);
				$coinContainer.find('.js-coin-country').val(suggestion.data.country);
				$coinContainer.find('.js-coin-year').val(suggestion.data.year);
				$coinContainer.find('.js-coin-metal').val(suggestion.data.metal);
				$coinContainer.find('.js-coin-denomination').val(suggestion.data.denomination);
				$coinContainer.find('.js-coin-fineness').val(suggestion.data.fineness);
				$coinContainer.find('.js-coin-coinage').val(suggestion.data.coinage);
			}
		}).keyup(function() {
			var $coinContainer = $(this).closest('.coin-container');

			if (!$(this).val().length) {
				$coinContainer.find('input').each(function() {
					$(this).val('');
				});
			}
		});
	});

	// Металлы
	var metals = [
		{ value: 'Золото' },
		{ value: 'Серебро' },
		{ value: 'Платина' }
	];
	$(document).on('focus', '.js-coin-metal', function() {
		if ($(this).autocomplete() !== undefined) return;

		$(this).autocomplete({
			lookup: metals,
			minChars: 0,
			showNoSuggestionNotice: true,
			noSuggestionNotice: 'Ничего не найдено',
			onSelect: function (suggestion) {
				var $coinContainer = $(this).closest('.coin-container');

				$coinContainer.find('.js-coin-metal').val(suggestion.value);
			}
		});
	});

	// Страны
	var countries = [
		{ value: 'Россия' },
		{ value: 'Австралия' },
		{ value: 'Австрия' },
		{ value: 'Армения' },
		{ value: 'Беларусь' },
		{ value: 'Великобритания' },
		{ value: 'Израиль' },
		{ value: 'Казахстан' },
		{ value: 'Камерун' },
		{ value: 'Канада' },
		{ value: 'Китай' },
		{ value: 'Либерия' },
		{ value: 'Мексика' },
		{ value: 'Ниуэ' },
		{ value: 'Острова Кука' },
		{ value: 'США' },
		{ value: 'ЮАР' }
	];
	$(document).on('focus', '.js-coin-country', function() {
		if ($(this).autocomplete() !== undefined) return;

		$(this).autocomplete({
			lookup: countries,
			minChars: 0,
			showNoSuggestionNotice: true,
			noSuggestionNotice: 'Ничего не найдено',
			onSelect: function (suggestion) {
				var $coinContainer = $(this).closest('.coin-container');

				$coinContainer.find('.js-coin-country').val(suggestion.value);
			}
		});
	});

	// Пробы
	var finenesses = [
		{ value: '900' },
		{ value: '916.7' },
		{ value: '917' },
		{ value: '999' },
		{ value: '9995' },
		{ value: '9999' },
		{ value: '99999' },
		{ value: '925' }
	];
	$(document).on('focus', '.js-coin-fineness', function() {
		if ($(this).autocomplete() !== undefined) return;

		$(this).autocomplete({
			lookup: finenesses,
			minChars: 0,
			showNoSuggestionNotice: true,
			noSuggestionNotice: 'Ничего не найдено',
			onSelect: function (suggestion) {
				var $coinContainer = $(this).closest('.coin-container');

				$coinContainer.find('.js-coin-fineness').val(suggestion.value);
			}
		});
	});

	// Чеканка
	var coinage = [
		{ value: 'Austrian Mint' },
		{ value: 'British Royal Mint' },
		{ value: 'Canadian Royal Mint' },
		{ value: 'CIT' },
		{ value: 'LEV Germany' },
		{ value: 'Mayer Mint' },
		{ value: 'Mennica Polska' },
		{ value: 'Mint of Poland' },
		{ value: 'PAMP SA' },
		{ value: 'Perth Mint' },
		{ value: 'Royal Mint' },
		{ value: 'Royal Mint UK' },
		{ value: 'South African Mint' },
		{ value: 'Star of David' },
		{ value: 'The Perth Mint' },
		{ value: 'US Mint' },
		{ value: 'US West Point Mint' },
		{ value: 'Valcambi Swiss' },
		{ value: 'Б.Х. Майерс Кунстпрегеанштальт' },
		{ value: 'Казахстанский монетный двор' },
		{ value: 'Китайский Монетный Двор' },
		{ value: 'Королевский монетный двор Нидерландов' },
		{ value: 'Литовский монетный двор' },
		{ value: 'ММД' },
		{ value: 'Монетный двор Мехико' },
		{ value: 'Монетный двор Финляндии' },
		{ value: 'Польский монетный двор' },
		{ value: 'СПМД' },
		{ value: 'СПМД / ММД' },
		{ value: 'СССР' },
		{ value: 'Шанхайский Монетный Двор' },
		{ value: 'Швейцария' },
		{ value: 'Швейцарский монетный двор' },
		{ value: 'Южноафриканский монетный двор' }
	];
	$(document).on('focus', '.js-coin-coinage', function() {
		if ($(this).autocomplete() !== undefined) return;

		$(this).autocomplete({
			lookup: coinage,
			minChars: 0,
			showNoSuggestionNotice: true,
			noSuggestionNotice: 'Ничего не найдено',
			onSelect: function (suggestion) {
				var $coinContainer = $(this).closest('.coin-container');

				$coinContainer.find('.js-coin-coinage').val(suggestion.value);
			}
		});
	});

	// Веса металлов
	var metalWeights = [
		{ value: '1.55' },
		{ value: '3.11' },
		{ value: '3.89' },
		{ value: '7.2' },
		{ value: '7.32' },
		{ value: '7.74' },
		{ value: '7.78' },
		{ value: '7.89' },
		{ value: '9.99' },
		{ value: '15.55' },
		{ value: '20.35' },
		{ value: '23.30' },
		{ value: '26.16' },
		{ value: '28.28' },
		{ value: '28.77' },
		{ value: '30.0' },
		{ value: '31.1' },
		{ value: '31.3' },
		{ value: '37.5' },
		{ value: '62.2' },
		{ value: '84.84' },
		{ value: '93.3' },
		{ value: '124.4' },
		{ value: '155.5' },
		{ value: '311' },
		{ value: '1000' },
		{ value: '3000' },
		{ value: '5000' },
	];
	$(document).on('focus', '.js-coin-metal-weight', function() {
		if ($(this).autocomplete() !== undefined) return;

		$(this).autocomplete({
			lookup: metalWeights,
			minChars: 0,
			showNoSuggestionNotice: true,
			noSuggestionNotice: 'Ничего не найдено',
			onSelect: function (suggestion) {
				var $coinContainer = $(this).closest('.coin-container');

				$coinContainer.find('.js-coin-metal-weight').val(suggestion.value);
			}
		});
	});

	// Файлы контрагента
	$(document).on('change', '.custom-file-input', function() {
		$(this).next('.custom-file-label').text(this.files[0].name);
	});

	$(document).on('click', '.js-get-passport, .js-get-file', function() {
		window.open($(this).data('path'), '_blank').focus();
	});

	// Сохранение сделки
	$(document).on('submit', '#deal-form', function(e) {
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

				toastr.success("", "Сделка #" + D.deal_id + " успешно сохранена");
				//console.log(D);
				setTimeout(function () {
					window.location.href = '/';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? 'HTTP ' + textStatus + ': ' + errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	$(document).on('click', '.js-delete-deal', function() {
		if (!confirm('Вы уверены, что хотите удалить сделку?')) {
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
				toastr.success("", "Сделка #" + D.deal_id + " успешно удалена");
				setTimeout(function () {
					window.location.href = '/';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	$(document).on('click', '.js-delete-file', function() {
		if (!confirm('Вы уверены, что хотите удалить файл?')) {
			return;
		}

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
				if (D.status !== 'success') {
					toastr.error("", D.reason ? D.reason : 'Ошибка, попробуйте повторить операцию позже');
					return;
				}
				toastr.success("", "Файл успешно удален");
				setTimeout(function () {
					window.location.href = '/deal/' + D.deal_id;
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	$(document).on('click', '.js-extend-coin-link', function() {
		var $icon = $(this).find('i'),
			$coinContainer = $(this).closest('.coin-container');

		if($icon.hasClass('fa-angle-down')) {
			$icon.removeClass('fa-angle-down').addClass('fa-angle-up');
			$coinContainer.find('.js-extend-coin').each(function() {
				$(this).removeClass('d-none');
			});
		} else {
			$icon.removeClass('fa-angle-up').addClass('fa-angle-down');
			$coinContainer.find('.js-extend-coin').each(function() {
				$(this).addClass('d-none');
			});
		}
	});

	$(document).on('click', '.js-add-coin', function() {
		var $coinContainer = $(this).closest('.coins').find('.coin-container:last'),
			coinNumber = $coinContainer.find('.coin-number').text();

		$clonedCoinContainer = $coinContainer.clone().insertAfter('.coin-container:last');
		$clonedCoinContainer.find('input').each(function() {
			$(this).val('');
		});
		$clonedCoinContainer.find('.coin-number').text(++ coinNumber);
		$clonedCoinContainer.find('.js-delete-coin').show();
		$clonedCoinContainer.find('.js-coin-name').focus();
	});

	$(document).on('click', '.js-delete-coin', function() {
		var $coinContainer = $(this).closest('.coin-container');

		if ($coinContainer.find('.js-coin-name').val().length && !confirm('Вы уверены, что хотите удалить монету?')) {
			return;
		}
		if ($('.coin-container').length === 1) {
			toastr.error("", 'Ошибка, хотя бы одна монета обязательна для заполнения');
			return;
		}

		$coinContainer.remove();

		coinNumberRecalc();
	});

	$(document).on('keyup mouseup', '.js-coin-quantity, .js-coin-price', function() {
		var $coinContainer = $(this).closest('.coin-container'),
			quantity = $coinContainer.find('.js-coin-quantity').val(),
			price = $coinContainer.find('.js-coin-price').val(),
			sum = quantity * price;

		$coinContainer.find('.js-coin-sum').val(sum ? sum : '');
	});

	/*$(document).on('keyup', '#passport-series, #passport-number, #passport-date, #passport-office, #passport-file-1, #passport-file-2, #passport-zipcode, #passport-region, #passport-city, #passport-street, #passport-house, #passport-apartment', function() {
		if ($('#contractor-id').val().length) {
			$('label[for="is-new-passport-version"]').closest('.row').removeClass('hidden');
		}
	});*/

	function getDealList(loadMore) {
		var $table = $('#dealTable'),
			$tbody = $table.find('tbody.body');

		var $tr = $('tr.odd[data-id]:last'),
			id = (loadMore && $tr.length) ? $tr.data('id') : 0;

		$.ajax({
			type: 'GET',
			url: $table.data('action'),
			data: {
				"filter-contractor": $('#filter-contractor').val(),
				"filter-period": $('#filter-period').val(),
				"filter-period-from": $('#filter-period-from').val(),
				"filter-period-to": $('#filter-period-to').val(),
				"filter-deal-type": $('#filter-deal-type').val(),
				"id": id,
			},
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

	function coinNumberRecalc() {
		var coinNumber = 0;

		$('.coin-container').each(function() {
			$(this).find('.coin-number').text(++ coinNumber);
		});
	}

	getDealList(false);

	$(window).on('scroll', function() {
		if ($(window).data('ajaxready') === false) return;

		var $tr = $('tr.odd[data-id]:last');
		if (!$tr.length) return;

		if ($tr.isInViewport()) {
			$(window).data('ajaxready', false);
			getDealList(true);
		}
	});
});
