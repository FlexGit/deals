@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-md-between">
						<span class="lead mt-1">{{ __('Последние сделки') }}</span>
						<div>
							<a href="{{ route('deal-edit') }}" class="btn btn-info" role="button"><i class="icon-plus" aria-hidden="true"></i>&nbsp;&nbsp;Новая сделка</a>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row d-flex justify-content-start">
							<span class="col-md-1 font-weight-bold pt-2">Поиск: </span>
							<div class="col-md-4">
								<input id="search-contractor-name" type="text" class="form-control" name="search-contractor-name" data-source-url="{{ route('contractor-search') }}" placeholder="ФИО">
							</div>
						</div>
						<table class="table table-sm table-striped table-hover js-deal-list" data-action="{{ route('deal-list') }}">
							<thead>
							<tr>
								<th class="col-md-1 text-center border-right" scope="col">#</th>
								<th class="col-md-3 text-center border-right" scope="col">Контрагент</th>
								<th class="col-md-1 text-center border-right" scope="col">Тип сделки</th>
								<th class="col-md-1 text-center border-right" scope="col">Дата</th>
								<th class="col-md-2 text-center border-right" scope="col">Сумма, руб</th>
								<th class="col-md-2 text-center border-right" scope="col">Документы</th>
								<th class="col-md-1 text-center" scope="col">Действие</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
