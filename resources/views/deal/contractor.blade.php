<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $deal ? $deal->contractor_id : '' }}">

<div class="form-group row">
	<label for="contractor-name" class="col-md-3 col-form-label text-md-right font-weight-bold">{{ __('Контрагент') }}</label>

	<div class="col-md-9">
		<input id="contractor-name" type="text" class="form-control" name="contractor-name" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('name', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['name'] : '' }}" data-source-url="{{ route('contractor-search') }}" placeholder="ФИО" required>
	</div>
</div>

<div class="form-group row">
	<label for="passport-series" class="col-md-3 col-form-label text-md-right font-weight-bold">{{ __('Паспорт') }}</label>

	<div class="col-md-2">
		<input id="passport-series" type="text" class="form-control" name="passport-series" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_series', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_series'] : '' }}" placeholder="Серия" required>
	</div>

	<div class="col-md-3">
		<input id="passport-number" type="text" class="form-control" name="passport-number" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_number', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_number'] : '' }}" placeholder="Номер" required>
	</div>

	<div class="col-md-4">
		<input id="passport-date" type="date" class="form-control datepicker" name="passport-date" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_date', $deal->data_json['contractor'])) ? \Carbon\Carbon::createFromTimestamp($deal->data_json['contractor']['passport_date'])->format('Y-m-d') : '' }}" placeholder="Дата выдачи" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>

	<div class="col-md-9">
		<input id="passport-office" type="text" class="form-control" name="passport-office" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_office', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_office'] : '' }}" placeholder="Кем выдан, код подразделения" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>

	<div class="col-md-9">
		<input id="passport-address" type="text" class="form-control" name="passport-address" value="{{ ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_address', $deal->data_json['contractor'])) ? $deal->data_json['contractor']['passport_address'] : '' }}" placeholder="Адрес регистрации" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-3 text-md-right pt-1">
		<div class="preview-file">
			@if ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_file_1', $deal->data_json['contractor']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $deal->data_json['contractor']['passport_file_1']['ext'] }}/{{ $deal->data_json['contractor']['passport_file_1']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>
	<div class="col-md-9">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-1" name="passport-file-1" accept="image/*">
			<label class="custom-file-label" for="passport-file-1">Первая страница паспорта</label>
		</div>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-3 text-md-right pt-1">
		<div class="preview-file">
			@if ($deal && array_key_exists('contractor', $deal->data_json) && array_key_exists('passport_file_2', $deal->data_json['contractor']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $deal->data_json['contractor']['passport_file_2']['ext'] }}/{{ $deal->data_json['contractor']['passport_file_2']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>
	<div class="col-md-9">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-2" name="passport-file-2" accept="image/*">
			<label class="custom-file-label" for="passport-file-2">Вторая страница паспорта</label>
		</div>
	</div>
</div>
