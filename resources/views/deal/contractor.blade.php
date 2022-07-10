<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $deal ? $deal->contractor_id : '' }}">

<div class="form-group row">
	<div class="col-md-4">
		<label class="font-weight-bold">ФИО</label>
		<input id="contractor-name" type="text" class="form-control" name="contractor-name" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('name', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['name'] : '' }}" data-source-url="{{ route('contractor-search') }}" placeholder="ФИО" required>
	</div>
	<div class="col-md-8">
		<label for="passport-id" class="font-weight-bold">Версия паспортных данных</label>
		<select id="passport-id" class="form-control">
			{{--<option></option>--}}
			@if($deal && $deal->passport)
				<option value="{{ $deal->passport->id }}" selected>от {{ $deal->passport->created_at }}</option>
			@endif
		</select>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-2">
		<label class="font-weight-bold">Серия паспорта</label>
		<input id="passport-series" type="text" class="form-control" name="passport-series" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_series', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_series'] : '' }}" placeholder="Серия" required>
	</div>

	<div class="col-md-2">
		<label class="font-weight-bold">Номер паспорта</label>
		<input id="passport-number" type="text" class="form-control" name="passport-number" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_number', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_number'] : '' }}" placeholder="Номер" required>
	</div>

	<div class="col-md-2">
		<label class="font-weight-bold">Дата выдачи</label>
		<input id="passport-date" type="date" class="form-control datepicker" name="passport-date" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_date', $deal->data_json['contractor'])) ? \Carbon\Carbon::createFromTimestamp($deal->data_json['contractor']['passport_date'])->format('Y-m-d') : '' }}" placeholder="Дата выдачи" required>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Кем выдан, код подразделения</label>
		<input id="passport-office" type="text" class="form-control" name="passport-office" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_office', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_office'] : '' }}" placeholder="Кем выдан, код подразделения" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-6">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-1" name="passport-file-1" accept="image/*">
			<label class="custom-file-label" for="passport-file-1">Первая страница паспорта</label>
		</div>
		<div class="preview-file">
			@if ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_file_1', $deal->data_json['contractor']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $deal->data_json['contractor']['passport_file_1']['ext'] }}/{{ $deal->data_json['contractor']['passport_file_1']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>

	<div class="col-md-6">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-2" name="passport-file-2" accept="image/*">
			<label class="custom-file-label" for="passport-file-2">Вторая страница паспорта</label>
		</div>
		<div class="preview-file">
			@if ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_file_2', $deal->data_json['contractor']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $deal->data_json['contractor']['passport_file_2']['ext'] }}/{{ $deal->data_json['contractor']['passport_file_2']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-2">
		<label class="font-weight-bold">Почтовый индекс</label>
		<input id="passport-zipcode" type="text" class="form-control" name="passport-zipcode" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_zipcode', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_zipcode'] : '' }}" placeholder="Почтовый индекс" required>
	</div>

	<div class="col-md-4">
		<label class="font-weight-bold">Регион</label>
		<input id="passport-region" type="text" class="form-control" name="passport-region" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_region', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_region'] : '' }}" placeholder="Регион" required>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Населенный пункт</label>
		<input id="passport-city" type="text" class="form-control" name="passport-city" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_city', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_city'] : '' }}" placeholder="Населенный пункт" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-6">
		<label class="font-weight-bold">Улица</label>
		<input id="passport-street" type="text" class="form-control" name="passport-street" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_street', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_street'] : '' }}" placeholder="Улица" required>
	</div>

	<div class="col-md-3">
		<label class="font-weight-bold">Дом</label>
		<input id="passport-house" type="text" class="form-control" name="passport-house" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_house', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_house'] : '' }}" placeholder="Дом" required>
	</div>

	<div class="col-md-3">
		<label class="font-weight-bold">Квартира</label>
		<input id="passport-apartment" type="text" class="form-control" name="passport-apartment" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_appartment', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_appartment'] : '' }}" placeholder="Квартира" required>
	</div>
</div>

<div class="form-group row hidden">
	<div class="col-md-12 vertical-align-middle">
		<label for="is-new-passport-version" class="font-weight-bold">В каком виде сохранить измененные паспортные данные?</label>
		<div>
			<div class="custom-control custom-radio custom-control-inline" style="margin-top: 0.5rem;">
				<input type="radio" class="custom-control-input" id="current-passport-version" name="is-new-passport-version" value="false" checked>
				<label class="custom-control-label" for="current-passport-version">В текущую версию</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline" style="margin-top: 0.5rem;">
				<input type="radio" class="custom-control-input" id="new-passport-version" name="is-new-passport-version" value="true">
				<label class="custom-control-label" for="new-passport-version">Создать новую версию</label>
			</div>
		</div>
	</div>
</div>
