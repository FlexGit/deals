<table class="table table-sm table-striped table-hover">
	<thead>
	<tr>
		<th class="col-md-1 text-center border-right" scope="col">#</th>
		<th class="col-md-2 text-center border-right" scope="col">Наименование</th>
		<th class="col-md-1 text-center border-right" scope="col">Страна</th>
		<th class="col-md-1 text-center border-right text-nowrap" scope="col">Год выпуска</th>
		<th class="col-md-1 text-center border-right" scope="col">Металл</th>
		<th class="col-md-1 text-center border-right" scope="col">Номинал</th>
		<th class="col-md-1 text-center border-right" scope="col">Проба</th>
		<th class="col-md-1 text-center border-right" scope="col">Чеканка</th>
		<th class="col-md-1 text-center" scope="col">Действие</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($coins as $index => $coin)
		<tr>
			<th class="text-center border-right" scope="row">{{ $coin['id'] }}</th>
			<td class="border-right">{{ $coin['name'] }}</td>
			<td class="text-center border-right">{{ $coin['data_json']['country'] }}</td>
			<td class="text-center border-right">{{ $coin['data_json']['year'] }}</td>
			<td class="text-center border-right">{{ $coin['data_json']['metal'] }}</td>
			<td class="text-center border-right">{{ $coin['data_json']['denomination'] }}</td>
			<td class="text-center border-right">{{ $coin['data_json']['fineness'] }}</td>
			<td class="text-center border-right">{{ $coin['data_json']['coinage'] }}</td>
			<td class="text-center">
				<div class="d-flex justify-content-around">
					<a href="/coin/{{ $coin['id'] }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="icon-edit" aria-hidden="true"></i></a>
					<a href="javascript:void(0)" data-action-url="/coin/{{ $coin['id'] }}" class="btn btn-danger btn-sm js-delete-coin" role="button" title="Удалить"><i class="icon-remove" aria-hidden="true"></i></a>
				</div>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

<div>
	{!! $coins->links() !!}
</div>