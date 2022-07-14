<div class="row coin-container">
	<input class="js-coin-id" type="hidden" name="coin-id[]" value="{{ ($coin && isset($coin['id'])) ? $coin['id'] : '' }}">

	<div class="col-md-12">
		<div class="row form-group">
			<div class="col-md-2 col-form-label d-flex justify-content-start">
				<div>
					[ <a href="javascript:void(0);" class="js-delete-coin" role="button" tabindex="-1"><i class="fa-solid fa-xmark"></i></a> ]
				</div>
				<div style="margin-left: 10px;">
					<span>{{ __('Монета #') }}</span><span class="coin-number">{{ ($index + 1) }}</span>
				</div>
			</div>

			<div class="col-md-6">
				<label class="font-weight-bold">Наименование</label>
				<input type="text" class="form-control js-coin-name" name="coin-name[]" value="{{ ($coin && isset($coin['name'])) ? $coin['name'] : '' }}" data-source-url="{{ route('coin-search') }}" placeholder="Наименование" required>
			</div>

			<div class="col-md-4">
				<label class="font-weight-bold">Страна</label>
				<input type="text" class="form-control js-coin-country" name="coin-country[]" value="{{ ($coin && isset($coin['country'])) ? $coin['country'] : '' }}" placeholder="Страна">
			</div>
		</div>

		<div class="form-group row js-extend-coin d-none">
			<div class="col-md-2">
				<label class="font-weight-bold">Год выпуска</label>
				<input type="text" class="form-control js-coin-year" name="coin-year[]" value="{{ ($coin && isset($coin['year'])) ? $coin['year'] : '' }}" placeholder="Год выпуска">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Металл</label>
				<input type="text" class="form-control js-coin-metal" name="coin-metal[]" value="{{ ($coin && isset($coin['metal'])) ? $coin['metal'] : '' }}" placeholder="Металл">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Вес металла</label>
				<input type="text" class="form-control js-coin-metal-weight" name="coin-metal-weight[]" value="{{ ($coin && isset($coin['metalWeight'])) ? $coin['metalWeight'] : '' }}" placeholder="Вес металла">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Номинал</label>
				<input type="text" class="form-control js-coin-denomination" name="coin-denomination[]" value="{{ ($coin && isset($coin['denomination'])) ? $coin['denomination'] : '' }}" placeholder="Номинал">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Проба</label>
				<input type="text" class="form-control js-coin-fineness" name="coin-fineness[]" value="{{ ($coin && isset($coin['fineness'])) ? $coin['fineness'] : '' }}" placeholder="Проба">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Чеканка</label>
				<input type="text" class="form-control js-coin-coinage" name="coin-coinage[]" value="{{ ($coin && isset($coin['coinage'])) ? $coin['coinage'] : '' }}" placeholder="Чеканка">
			</div>
		</div>

		<div class="form-group row mb-0">
			<div class="col-md-2">
			</div>
			<div class="col-md-3">
				<label class="font-weight-bold">Количество</label>
				<input type="number" class="form-control text-right js-coin-quantity" name="coin-quantity[]" value="{{ ($coin && isset($coin['quantity'])) ? $coin['quantity'] : '' }}" min="0" placeholder="0" required>
			</div>

			<div class="col-md-3">
				<label class="font-weight-bold">Цена</label>
				<input type="text" class="form-control text-right js-coin-price" name="coin-price[]" value="{{ ($coin && isset($coin['price'])) ? $coin['price'] : '' }}" pattern="\d*" placeholder="0" required>
			</div>

			<div class="col-md-4">
				<label class="font-weight-bold">Сумма</label>
				<input type="text" class="form-control text-right js-coin-sum" name="coin-sum[]" value="{{ ($coin && isset($coin['quantity']) && isset($coin['price'])) ? ($coin['quantity'] * $coin['price']) : '' }}" pattern="\d*" placeholder="0" required readonly>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 text-center">
				<a href="javascript:void(0)" class="js-extend-coin-link" role="button" tabindex="-1">{{--<span>Развернуть</span>&nbsp;&nbsp;--}}<i class="fa-solid fa-angle-down"></i></a>
			</div>
		</div>

		<hr>
	</div>
</div>
