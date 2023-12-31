<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $deal ? $deal->contractor_id : '' }}">

<div class="form-group row">
	<div class="col-md-6">
		<label class="font-weight-bold">ФИО</label>
		<input id="contractor-name" type="text" class="form-control" name="contractor-name" value="{{ ($deal && isset($deal->data_json['contractor']['name'])) ? $deal->data_json['contractor']['name'] : '' }}" data-source-url="{{ route('contractor-search') }}" placeholder="ФИО" required>
	</div>
	<div class="col-md-6">
		<label for="passport-id" class="font-weight-bold">Версия паспортных данных</label>
		<select id="passport-id" name="passport-id" class="form-control">
			<option></option>
			@if($contractor)
				@foreach($contractor->passports as $passportItem)
					<option value="{{ $passportItem->id }}" @if($passport && $passportItem->id == $passport->id) selected @endif>{{ $passportItem->series }} {{ $passportItem->number }} от {{ $passportItem->issue_date ? $passportItem->issue_date->format('d.m.Y') : '-' }} [создал {{ $passportItem->createdBy->name }} {{ $passportItem->created_at->format('Y-m-d H:i:s') }}@if($passportItem->created_at != $passportItem->updated_at), изменил {{ $passportItem->updatedBy->name }} {{ $passportItem->updated_at->format('Y-m-d H:i:s') }}@endif]</option>
				@endforeach
			@endif
		</select>
	</div>
</div>

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
		<input id="passport-date" type="date" class="form-control datepicker" name="passport-date" value="{{ $passport ? $passport->issue_date->format('Y-m-d') : '' }}" placeholder="Дата выдачи" required>
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
	<div class="passport-container col-md-6">
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

	<div class="passport-container col-md-6">
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

<div class="form-group row">
	<div class="col-md-12 vertical-align-middle">
		<label for="is-new-passport-version" class="font-weight-bold">В каком виде сохранить паспортные данные?</label>
		<div>
			<div class="custom-control custom-radio custom-control-inline" style="margin-top: 0.5rem;">
				<input type="radio" class="custom-control-input" id="current-passport-version" name="is-new-passport-version" value="0" checked>
				<label class="custom-control-label" for="current-passport-version">В текущую версию</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline" style="margin-top: 0.5rem;">
				<input type="radio" class="custom-control-input" id="new-passport-version" name="is-new-passport-version" value="1">
				<label class="custom-control-label" for="new-passport-version">Создать новую версию</label>
			</div>
		</div>
	</div>
</div>
