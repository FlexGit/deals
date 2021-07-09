$(document).ready(function() {
	// Монеты в списке
	var $searchCoin = $('#search-coin-name');
	$searchCoin.autocomplete({
		serviceUrl: $searchCoin.data('source-url'),
		minChars: 1,
		showNoSuggestionNotice: true,
		noSuggestionNotice: 'Ничего не найдено',
		type: 'POST',
		dataType: 'json',
		onSelect: function (suggestion) {
			getCoinList(1, suggestion.value);
		}
	}).keyup(function() {
		if (!$(this).val().length) {
			getCoinList(1,null);
		}
	});

	$(document).on('click', '.pagination a', function(e){
		e.preventDefault();
		getCoinList($(this).attr('href').split('page=')[1], $('#search-coin-name').val());
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

	function getCoinList(page, coinName) {
		var $list = $('.js-coin-list');
		if (!$list.length) return;

		$.ajax({
			type: 'GET',
			url: $list.data('action'),
			data: { page: page, coin: coinName },
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

				$('.js-coin-list').html(D.html);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	}

	$(document).on('click', '.js-delete-coin', function() {
		if (!confirm('Вы уверены, что хотите удалить монету?')) {
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
				toastr.success("", "Монета #" + D.coin_id + " успешно удалена");
				setTimeout(function () {
					window.location.href = '/coins';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	// Сохранение монеты
	$(document).on('submit', '#coin-form', function(e) {
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

				toastr.success("", "Монета #" + D.coin_id + " успешно сохранена");
				setTimeout(function () {
					window.location.href = '/coins';
				}, 1500);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$btn.attr('disabled', false);
				toastr.error("", errorThrown.length ? 'HTTP ' + textStatus + ': ' + errorThrown : 'Ошибка, попробуйте повторить операцию позже');
			}
		});
	});

	getCoinList(1,null);
});