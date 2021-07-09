<div class="row coin-container">
	<input class="js-coin-id" type="hidden" name="coin-id[]" value="{{ ($coin && $coin['id']) ? $coin['id'] : '' }}">

	<div class="col-md-12">
		<div class="form-group row">
			<div class="col-md-3 col-form-label d-flex justify-content-start">
				<div>
					[<a href="javascript:void(0);" class="js-delete-coin" role="button" tabindex="-1"><i class="icon-remove" aria-hidden="true"></i></a>]
				</div>
				<div style="margin-left: 10px;">
					<span class="font-weight-bold">{{ __('Монета #') }}</span><span class="font-weight-bold coin-number">{{ ($index + 1) }}</span>
				</div>
			</div>

			<div class="col-md-9">
				<input type="text" class="form-control js-coin-name" name="coin-name[]" value="{{ ($coin && $coin['name']) ? $coin['name'] : '' }}" data-source-url="{{ route('coin-search') }}" placeholder="Наименование" required>
			</div>
		</div>

		<div class="form-group row js-extend-coin d-none">
			<div class="col-md-4">
				<input type="text" class="form-control js-coin-country" name="coin-country[]" value="{{ ($coin && $coin['country']) ? $coin['country'] : '' }}" placeholder="Страна">
			</div>

			<div class="col-md-4">
				<input type="text" class="form-control js-coin-year" name="coin-year[]" value="{{ ($coin && $coin['year']) ? $coin['year'] : '' }}" pattern="\d*" placeholder="Год выпуска">
			</div>

			<div class="col-md-4">
				<input type="text" class="form-control js-coin-metal" name="coin-metal[]" value="{{ ($coin && $coin['metal']) ? $coin['metal'] : '' }}" placeholder="Металл">
			</div>
		</div>

		<div class="form-group row js-extend-coin d-none">
			<div class="col-md-4">
				<input type="text" class="form-control js-coin-denomination" name="coin-denomination[]" value="{{ ($coin && $coin['denomination']) ? $coin['denomination'] : '' }}" placeholder="Номинал">
			</div>

			<div class="col-md-4">
				<input type="text" class="form-control js-coin-fineness" name="coin-fineness[]" value="{{ ($coin && $coin['fineness']) ? $coin['fineness'] : '' }}" pattern="\d*" placeholder="Проба">
			</div>

			<div class="col-md-4">
				<input type="text" class="form-control js-coin-coinage" name="coin-coinage[]" value="{{ ($coin && $coin['coinage']) ? $coin['coinage'] : '' }}" placeholder="Чеканка">
			</div>
		</div>

		<div class="form-group row mb-0">
			<div class="col-md-4">
				<input type="number" class="form-control js-coin-quantity" name="coin-quantity[]" value="{{ ($coin && $coin['quantity']) ? $coin['quantity'] : '' }}" min="0" placeholder="Кол-во" required>
			</div>

			<div class="col-md-4">
				<input type="text" class="form-control js-coin-price" name="coin-price[]" value="{{ ($coin && $coin['price']) ? $coin['price'] : '' }}" pattern="\d*" placeholder="Цена" required>
			</div>

			<div class="col-md-4">
				<input type="text" class="form-control js-coin-sum" name="coin-sum[]" value="{{ ($coin && $coin['quantity'] && $coin['price']) ? ($coin['quantity'] * $coin['price']) : '' }}" pattern="\d*" placeholder="Сумма" required readonly>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 text-center">
				<a href="javascript:void(0)" class="js-extend-coin-link" role="button" tabindex="-1">{{--<span>Развернуть</span>&nbsp;&nbsp;--}}<i class="icon-angle-down" aria-hidden="true"></i></a>
			</div>
		</div>

		<hr>
	</div>
</div>
