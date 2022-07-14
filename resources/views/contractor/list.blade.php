@foreach ($contractors as $contractor)
	<tr class="odd" data-id="{{ $contractor->id }}">
		<td class="text-center align-middle border-right">
			{{ $contractor->id }}
		</td>
		<td class="align-middle border-right">
			{{ $contractor->name }}
		</td>
		<td class="align-middle">
			<div class="d-flex justify-content-center">
				<a href="/contractor/{{ $contractor->id }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="fa-regular fa-pen-to-square"></i></a>
				&nbsp;
				<a href="javascript:void(0)" data-action-url="/contractor/{{ $contractor->id }}" class="btn btn-danger btn-sm js-delete-contractor" role="button" title="Удалить"><i class="fa-regular fa-trash-can"></i></a>
				&nbsp;
				<a href="{{ route('passport-edit', ['id' => $contractor->id]) }}" class="btn btn-success btn-sm" role="button" title="Новая версия паспорта"><i class="fa-regular fa-address-card"></i></a>
			</div>
		</td>
		<td>
			@if($contractor->passports->count())
				<table class="table table-sm table-striped table-hover">
					<thead>
						<tr class="bg-white">
							<th rowspan="2" class="text-center align-middle border-right">Серия и номер</th>
							<th rowspan="2" class="text-center align-middle border-right">Дата выдачи</th>
							<th rowspan="2" class="text-center align-middle border-right">Кем выдан</th>
							<th colspan="2" class="text-center align-middle border-right">Создано</th>
							<th colspan="2" class="text-center align-middle border-right">Изменено</th>
							<th rowspan="2" class="text-center align-middle border-right"></th>
						</tr>
						<tr class="bg-white">
							<th class="text-center border-right">Когда</th>
							<th class="text-center border-right">Кем</th>
							<th class="text-center border-right">Когда</th>
							<th class="text-center border-right">Кем</th>
						</tr>
					</thead>
					@foreach ($contractor->passports as $passport)
						<tr class="bg-white">
							<td class="border-right">
								{{ $passport->series }} {{ $passport->number }}
							</td>
							<td class="text-center border-right">
								{{ $passport->issue_date ? $passport->issue_date->format('d.m.Y') : '-' }}
							</td>
							<td class="text-center border-right">
								{{ $passport->issue_office ?? '-' }}
							</td>
							<td class="text-center text-nowrap border-right">
								{{ $passport->created_at->format('Y-m-d H:i:s') }}
							</td>
							<td class="text-center border-right">
								{{ $passport->createdBy->name }}
							</td>
							<td class="text-center text-nowrap border-right">
								{{ $passport->updated_at->format('Y-m-d H:i:s') }}
							</td>
							<td class="text-center border-right">
								{{ $passport->updatedBy->name }}
							</td>
							<td class="text-center">
								<div class="d-flex justify-content-center">
									<a href="/contractor/{{ $contractor->id }}/passport/{{ $passport->id }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="fa-regular fa-pen-to-square"></i></a>
									&nbsp;
									<a href="javascript:void(0)" data-action-url="/contractor/{{ $contractor->id }}/passport/{{ $passport->id }}" class="btn btn-danger btn-sm js-delete-passport" role="button" title="Удалить"><i class="fa-regular fa-trash-can"></i></a>
								</div>
							</td>
						</tr>
					@endforeach
				</table>
			@endif
		</td>
	</tr>
@endforeach
