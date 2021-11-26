<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $contractor ? $contractor->id : '' }}">

<div class="form-group row">
	<label for="contractor-name" class="col-md-3 col-form-label text-md-right font-weight-bold">{{ __('Контрагент') }}</label>

	<div class="col-md-9">
		<input id="contractor-name" type="text" class="form-control" name="contractor-name" value="{{ $contractor ? $contractor->name : '' }}" placeholder="ФИО" required>
	</div>
</div>

<div class="form-group row">
	<label for="passport-series" class="col-md-3 col-form-label text-md-right font-weight-bold">{{ __('Паспорт') }}</label>

	<div class="col-md-2">
		<input id="passport-series" type="text" class="form-control" name="passport-series" value="{{ ($contractor && array_key_exists('passport_series', $contractor->data_json)) ? $contractor->data_json['passport_series'] : '' }}" placeholder="Серия" required>
	</div>

	<div class="col-md-3">
		<input id="passport-number" type="text" class="form-control" name="passport-number" value="{{ ($contractor && array_key_exists('passport_number', $contractor->data_json)) ? $contractor->data_json['passport_number'] : '' }}" placeholder="Номер" required>
	</div>

	<div class="col-md-4">
		<input id="passport-date" type="date" class="form-control datepicker" name="passport-date" value="{{ ($contractor && array_key_exists('passport_date', $contractor->data_json)) ? \Carbon\Carbon::createFromTimestamp($contractor->data_json['passport_date'])->format('Y-m-d') : '' }}" placeholder="Дата выдачи" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>

	<div class="col-md-9">
		<input id="passport-office" type="text" class="form-control" name="passport-office" value="{{ ($contractor && array_key_exists('passport_office', $contractor->data_json)) ? $contractor->data_json['passport_office'] : '' }}" placeholder="Кем выдан, код подразделения" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>

	<div class="col-md-9">
		<input id="passport-address" type="text" class="form-control" name="passport-address" value="{{ ($contractor && array_key_exists('passport_address', $contractor->data_json)) ? $contractor->data_json['passport_address'] : '' }}" placeholder="Адрес регистрации" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-3 text-md-right pt-1">
		<div class="preview-file">
			@if ($contractor && array_key_exists('passport_file_1', $contractor->data_json))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $contractor->data_json['passport_file_1']['ext'] }}/{{ $contractor->data_json['passport_file_1']['name'] }}">Открыть файл</a>
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
			@if ($contractor && array_key_exists('passport_file_2', $contractor->data_json))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $contractor->data_json['passport_file_2']['ext'] }}/{{ $contractor->data_json['passport_file_2']['name'] }}">Открыть файл</a>
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
