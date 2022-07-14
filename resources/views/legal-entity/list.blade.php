<table class="table table-sm table-striped table-hover">
	<thead>
	<tr>
		{{--<th class="col-md-1 text-center border-right" scope="col">#</th>--}}
		<th class="col-md-1 text-center align-middle border-right" scope="col">Наименование</th>
		<th class="col-md-1 text-center align-middle  border-right" scope="col">ИНН</th>
		<th class="col-md-1 text-center align-middle  border-right" scope="col">КПП</th>
		<th class="col-md-1 text-center align-middle  border-right" scope="col">ОГРН</th>
		<th class="col-md-2 text-center align-middle  border-right" scope="col">Банк</th>
		<th class="col-md-1 text-center align-middle  border-right" scope="col">Р/С</th>
		<th class="col-md-1 text-center align-middle  border-right" scope="col">К/С</th>
		<th class="col-md-3 text-center align-middle  border-right" scope="col">Адрес</th>
		<th class="col-md-1 text-center" scope="col">Действие</th>
	</tr>
	</thead>
	<tbody>
		@if($legalEntities->count())
			@foreach ($legalEntities as $index => $legalEntity)
				<tr>
					{{--<td class="text-center border-right" scope="row">{{ $legalEntity->id }}</td>--}}
					<td class="border-right align-middle  text-nowrap">{{ $legalEntity->name }}</td>
					<td class="border-right align-middle text-center">{{ $legalEntity->inn }}</td>
					<td class="border-right align-middle text-center">{{ $legalEntity->kpp }}</td>
					<td class="border-right align-middle text-center">{{ $legalEntity->ogrn }}</td>
					<td class="border-right align-middle">{{ $legalEntity->bank }}</td>
					<td class="border-right align-middle text-center">{{ $legalEntity->rs }}</td>
					<td class="border-right align-middle text-center">{{ $legalEntity->ks }}</td>
					<td class="border-right align-middle ">{{ $legalEntity->address }}</td>
					<td class="text-center align-middle">
						<div class="d-flex justify-content-center">
							<a href="/legal-entity/{{ $legalEntity->id }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="fa-regular fa-pen-to-square"></i></a>
							&nbsp;
							<a href="javascript:void(0)" data-action-url="/legal-entity/{{ $legalEntity->id }}" class="btn btn-danger btn-sm js-delete-legal-entity" role="button" title="Удалить"><i class="fa-regular fa-trash-can"></i></a>
						</div>
					</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="3" class="text-center" scope="row">Ничего не найдено</td>
			</tr>
		@endif
	</tbody>
</table>
