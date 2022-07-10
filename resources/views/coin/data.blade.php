<div class="row coin-container">
	<input type="hidden" id="coin-id" name="coin-id" value="{{ $coin ? $coin->id : '' }}">

	<div class="col-md-12">
		<div class="form-group row">
			<div class="col-md-8">
				<label class="font-weight-bold">Наименование</label>
				<input id="coin-name" type="text" class="form-control" name="coin-name" value="{{ $coin ? $coin->name : '' }}" placeholder="Наименование" required>
			</div>

			<div class="col-md-4">
				<label class="font-weight-bold">Страна</label>
				<input id="coin-country" type="text" class="form-control js-coin-country" name="coin-country" value="{{ ($coin && array_key_exists('country', $coin->data_json)) ? $coin->data_json['country'] : '' }}" placeholder="Страна">
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-2">
				<label class="font-weight-bold">Год выпуска</label>
				<input id="coin-year" type="text" class="form-control" name="coin-year" value="{{ ($coin && array_key_exists('year', $coin->data_json)) ? $coin->data_json['year'] : '' }}" placeholder="Год выпуска">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Металл</label>
				<input id="coin-metal" type="text" class="form-control js-coin-metal" name="coin-metal" value="{{ ($coin && array_key_exists('metal', $coin->data_json)) ? $coin->data_json['metal'] : '' }}" placeholder="Металл">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Вес металла</label>
				<input id="coin-metal-weight" type="text" class="form-control js-coin-metal-weight" name="coin-metal-weight" value="{{ ($coin && array_key_exists('metalWeight', $coin->data_json)) ? $coin->data_json['metalWeight'] : '' }}" placeholder="Вес металла">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Номинал</label>
				<input id="coin-denomination" type="text" class="form-control" name="coin-denomination" value="{{ ($coin && array_key_exists('denomination', $coin->data_json)) ? $coin->data_json['denomination'] : '' }}" placeholder="Номинал">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Проба</label>
				<input id="coin-fineness" type="text" class="form-control js-coin-fineness" name="coin-fineness" value="{{ ($coin && array_key_exists('fineness', $coin->data_json)) ? $coin->data_json['fineness'] : '' }}" placeholder="Проба">
			</div>

			<div class="col-md-2">
				<label class="font-weight-bold">Чеканка</label>
				<input id="coin-coinage" type="text" class="form-control js-coin-coinage" name="coin-coinage" value="{{ ($coin && array_key_exists('coinage', $coin->data_json)) ? $coin->data_json['coinage'] : '' }}" placeholder="Чеканка">
			</div>
		</div>
	</div>
</div>