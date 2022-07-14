@foreach($coins as $coin)
	<tr class="odd" data-id="{{ $coin->id }}">
		<th class="text-center border-right" scope="row">{{ $coin->id }}</th>
		<td class="border-right">{{ $coin->name }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['country']) ? $coin->data_json['country'] : '' }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['year']) ? $coin->data_json['year'] : '' }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['metal']) ? $coin->data_json['metal'] : '' }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['metalWeight']) ? $coin->data_json['metalWeight'] : '' }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['denomination']) ? $coin->data_json['denomination'] : '' }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['fineness']) ? $coin->data_json['fineness'] : '' }}</td>
		<td class="text-center border-right">{{ isset($coin->data_json['coinage']) ? $coin->data_json['coinage'] : '' }}</td>
		<td class="text-center">
			<div class="d-flex justify-content-center">
				<a href="/coin/{{ $coin->id }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="fa-regular fa-pen-to-square"></i></a>
				&nbsp;
				<a href="javascript:void(0)" data-action-url="/coin/{{ $coin->id }}" class="btn btn-danger btn-sm js-delete-coin" role="button" title="Удалить"><i class="fa-regular fa-trash-can"></i></a>
			</div>
		</td>
	</tr>
@endforeach
