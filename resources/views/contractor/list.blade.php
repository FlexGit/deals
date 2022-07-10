<table class="table table-sm table-striped table-hover">
	<thead>
	<tr>
		<th class="col-md-1 text-center border-right" scope="col">#</th>
		<th class="col-md-2 text-center border-right" scope="col">ФИО</th>
		<th class="col-md-3 text-center border-right" scope="col">Паспортные данные</th>
		<th class="col-md-3 text-center border-right" scope="col">Адрес регистрации</th>
		<th class="col-md-2 text-center" scope="col">Файлы паспорта</th>
		<th class="col-md-1 text-center" scope="col">Действие</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($contractors as $index => $contractor)
		<tr>
			<th class="text-center border-right" scope="row">{{ $contractor['id'] }}</th>
			<td class="border-right">{{ $contractor['name'] }}</td>
			<td class="border-right">
				{{ $contractor['data_json']['passport_series'] }} {{ $contractor['data_json']['passport_number'] }}
				{{ array_key_exists('passport_date', $contractor['data_json']) ? \Carbon\Carbon::createFromTimestamp($contractor['data_json']['passport_date'])->format('d.m.Y') : '' }}
				{!! array_key_exists('passport_office', $contractor['data_json']) ? '<br>' . $contractor['data_json']['passport_office'] : '' !!}
			</td>
			<td class="border-right">
				{{ isset($contractor['data_json']['passport_zipcode']) ? $contractor['data_json']['passport_zipcode'] : '' }}{{ isset($contractor['data_json']['passport_region']) ? ', ' . $contractor['data_json']['passport_region'] : '' }}{{ isset($contractor['data_json']['passport_city']) ? ', ' . $contractor['data_json']['passport_city'] : '' }}{{ isset($contractor['data_json']['passport_street']) ? ', ' . $contractor['data_json']['passport_street'] : '' }}{{ isset($contractor['data_json']['passport_house']) ? ', д. ' . $contractor['data_json']['passport_house'] : '' }}{{ isset($contractor['data_json']['passport_apartment']) ? ', кв. ' . $contractor['data_json']['passport_apartment'] : '' }}
			</td>
			<td class="text-center border-right">
				@if(isset($contractor['data_json']['passport_file_1']) && isset($contractor['data_json']['passport_file_1']['ext']) && isset($contractor['data_json']['passport_file_1']['name']))
					<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $contractor['data_json']['passport_file_1']['ext'] }}/{{ $contractor['data_json']['passport_file_1']['name'] }}">Первая страница</a>
				@endif
				@if(isset($contractor['data_json']['passport_file_2']) && isset($contractor['data_json']['passport_file_2']['ext']) && isset($contractor['data_json']['passport_file_2']['name']))
					<br>
					<a href="javascript:void(0)" class="js-get-passport" data-path="/passport/{{ $contractor['data_json']['passport_file_2']['ext'] }}/{{ $contractor['data_json']['passport_file_2']['name'] }}">Вторая страница</a>
				@endif
			</td>
			<td class="text-center">
				<div class="d-flex justify-content-around">
					<a href="/contractor/{{ $contractor['id'] }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="icon-edit" aria-hidden="true"></i></a>
					<a href="javascript:void(0)" data-action-url="/contractor/{{ $contractor['id'] }}" class="btn btn-danger btn-sm js-delete-contractor" role="button" title="Удалить"><i class="icon-remove" aria-hidden="true"></i></a>
				</div>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

<div>
	{!! $contractors->links() !!}
</div>