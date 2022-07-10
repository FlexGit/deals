<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $contractor ? $contractor->id : '' }}">

<div class="form-group row">
	<div class="col-md-12">
		<label class="font-weight-bold">ФИО</label>
		<input id="contractor-name" type="text" class="form-control" name="contractor-name" value="{{ $contractor ? $contractor->name : '' }}" placeholder="ФИО" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-2">
		<label class="font-weight-bold">Серия паспорта</label>
		<input id="passport-series" type="text" class="form-control" name="passport-series" value="{{ ($contractor && array_key_exists('passport_series', $contractor->data_json)) ? $contractor->data_json['passport_series'] : '' }}" placeholder="Серия" required>
	</div>

	<div class="col-md-2">
		<label class="font-weight-bold">Номер паспорта</label>
		<input id="passport-number" type="text" class="form-control" name="passport-number" value="{{ ($contractor && array_key_exists('passport_number', $contractor->data_json)) ? $contractor->data_json['passport_number'] : '' }}" placeholder="Номер" required>
	</div>

	<div class="col-md-2">
		<label class="font-weight-bold">Дата выдачи</label>
		<input id="passport-date" type="date" class="form-control datepicker" name="passport-date" value="{{ ($contractor && array_key_exists('passport_date', $contractor->data_json)) ? \Carbon\Carbon::createFromTimestamp($contractor->data_json['passport_date'])->format('Y-m-d') : '' }}" placeholder="Дата выдачи" required>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Кем выдан, код подразделения</label>
		<input id="passport-office" type="text" class="form-control" name="passport-office" value="{{ ($contractor && array_key_exists('passport_office', $contractor->data_json)) ? $contractor->data_json['passport_office'] : '' }}" placeholder="Кем выдан, код подразделения" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-6">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-1" name="passport-file-1" accept="image/*">
			<label class="custom-file-label" for="passport-file-1">Первая страница паспорта</label>
		</div>
		<div class="preview-file">
			@if ($contractor && isset($contractor->data_json['passport_file_1']) && isset($contractor->data_json['passport_file_1']['ext']) && isset($contractor->data_json['passport_file_1']['name']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $contractor->data_json['passport_file_1']['ext'] }}/{{ $contractor->data_json['passport_file_1']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>

	<div class="col-md-6">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-2" name="passport-file-2" accept="image/*">
			<label class="custom-file-label" for="passport-file-2">Вторая страница паспорта</label>
		</div>
		<div class="preview-file">
			@if ($contractor && isset($contractor->data_json['passport_file_2']) && isset($contractor->data_json['passport_file_2']['ext']) && isset($contractor->data_json['passport_file_2']['name']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $contractor->data_json['passport_file_2']['ext'] }}/{{ $contractor->data_json['passport_file_2']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-2">
		<label class="font-weight-bold">Почтовый индекс</label>
		<input id="passport-zipcode" type="text" class="form-control" name="passport-zipcode" value="{{ ($contractor && array_key_exists('passport_zipcode', $contractor->data_json)) ? $contractor->data_json['passport_zipcode'] : '' }}" placeholder="Почтовый индекс" required>
	</div>

	<div class="col-md-4">
		<label class="font-weight-bold">Регион</label>
		<input id="passport-region" type="text" class="form-control" name="passport-region" value="{{ ($contractor && array_key_exists('passport_region', $contractor->data_json)) ? $contractor->data_json['passport_region'] : '' }}" placeholder="Регион" required>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Населенный пункт</label>
		<input id="passport-city" type="text" class="form-control" name="passport-city" value="{{ ($contractor && array_key_exists('passport_city', $contractor->data_json)) ? $contractor->data_json['passport_city'] : '' }}" placeholder="Населенный пункт" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-6">
		<label class="font-weight-bold">Улица</label>
		<input id="passport-street" type="text" class="form-control" name="passport-street" value="{{ ($contractor && array_key_exists('passport_street', $contractor->data_json)) ? $contractor->data_json['passport_street'] : '' }}" placeholder="Улица" required>
	</div>

	<div class="col-md-3">
		<label class="font-weight-bold">Дом</label>
		<input id="passport-house" type="text" class="form-control" name="passport-house" value="{{ ($contractor && array_key_exists('passport_house', $contractor->data_json)) ? $contractor->data_json['passport_house'] : '' }}" placeholder="Дом" required>
	</div>

	<div class="col-md-3">
		<label class="font-weight-bold">Квартира</label>
		<input id="passport-apartment" type="text" class="form-control" name="passport-apartment" value="{{ ($contractor && array_key_exists('passport_apartment', $contractor->data_json)) ? $contractor->data_json['passport_apartment'] : '' }}" placeholder="Квартира" required>
	</div>
</div>
