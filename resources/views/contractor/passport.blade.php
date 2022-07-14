<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $passport ? $passport->contractor_id : '' }}">
<input type="hidden" id="passport-id" name="passport-id" value="{{ $passport ? $passport->id : '' }}">

<div class="form-group row">
	<div class="col-md-2">
		<label class="font-weight-bold">Серия паспорта</label>
		<input id="passport-series" type="text" class="form-control" name="passport-series" value="{{ $passport ? $passport->series : '' }}" placeholder="Серия" required>
	</div>

	<div class="col-md-2">
		<label class="font-weight-bold">Номер паспорта</label>
		<input id="passport-number" type="text" class="form-control" name="passport-number" value="{{ $passport ? $passport->number : '' }}" placeholder="Номер" required>
	</div>

	<div class="col-md-2">
		<label class="font-weight-bold">Дата выдачи</label>
		<input id="passport-date" type="date" class="form-control datepicker" name="passport-date" value="{{ ($passport && $passport->issue_date) ? $passport->issue_date->format('Y-m-d') : '' }}" placeholder="Дата выдачи" required>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Кем выдан, код подразделения</label>
		<input id="passport-office" type="text" class="form-control" name="passport-office" value="{{ $passport ? $passport->issue_office : '' }}" placeholder="Кем выдан, код подразделения" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-2">
		<label class="font-weight-bold">Почтовый индекс</label>
		<input id="passport-zipcode" type="text" class="form-control" name="passport-zipcode" value="{{ $passport ? $passport->zipcode : '' }}" placeholder="Почтовый индекс" required>
	</div>

	<div class="col-md-4">
		<label class="font-weight-bold">Регион</label>
		<input id="passport-region" type="text" class="form-control" name="passport-region" value="{{ $passport ? $passport->region : '' }}" placeholder="Регион" required>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Населенный пункт</label>
		<input id="passport-city" type="text" class="form-control" name="passport-city" value="{{ $passport ? $passport->city : '' }}" placeholder="Населенный пункт" required>
	</div>
</div>

<div class="form-group row">
	<div class="col-md-6">
		<label class="font-weight-bold">Улица</label>
		<input id="passport-street" type="text" class="form-control" name="passport-street" value="{{ $passport ? $passport->city : '' }}" placeholder="Улица" required>
	</div>

	<div class="col-md-3">
		<label class="font-weight-bold">Дом</label>
		<input id="passport-house" type="text" class="form-control" name="passport-house" value="{{ $passport ? $passport->house : '' }}" placeholder="Дом" required>
	</div>

	<div class="col-md-3">
		<label class="font-weight-bold">Квартира</label>
		<input id="passport-apartment" type="text" class="form-control" name="passport-apartment" value="{{ $passport ? $passport->apartment : '' }}" placeholder="Квартира">
	</div>
</div>

<div class="form-group row">
	<div class="col-md-6">
		<label class="font-weight-bold">Первая страница паспорта</label>
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-1" name="passport-file-1" accept="image/*">
			<label class="custom-file-label" for="passport-file-1">
				@if ($passport && isset($passport->data_json['passport_file_1']))
					{{ $passport->data_json['passport_file_1']['name'] }}.{{ $passport->data_json['passport_file_1']['ext'] }}
				@else
					Первая страница паспорта
				@endif
			</label>
		</div>
		<div class="preview-file">
			@if ($passport && isset($passport->data_json['passport_file_1']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/contractor/{{ $passport->contractor_id }}/passport/{{ $passport->data_json['passport_file_1']['ext'] }}/{{ $passport->data_json['passport_file_1']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>

	<div class="col-md-6">
		<label class="font-weight-bold">Вторая страница паспорта</label>
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="passport-file-2" name="passport-file-2" accept="image/*">
			<label class="custom-file-label" for="passport-file-2">
				@if ($passport && isset($passport->data_json['passport_file_2']))
					{{ $passport->data_json['passport_file_2']['name'] }}.{{ $passport->data_json['passport_file_2']['ext'] }}
				@else
					Вторая страница паспорта
				@endif
			</label>
		</div>
		<div class="preview-file">
			@if ($passport && isset($passport->data_json['passport_file_2']))
				<a href="javascript:void(0)" class="js-get-passport" data-path="/contractor/{{ $passport->contractor_id }}/passport/{{ $passport->data_json['passport_file_2']['ext'] }}/{{ $passport->data_json['passport_file_2']['name'] }}">Открыть файл</a>
			@endif
		</div>
	</div>
</div>
