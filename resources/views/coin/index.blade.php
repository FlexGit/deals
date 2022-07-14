@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-md-between">
						<span class="lead mt-1">{{ __('Монеты') }}</span>
						<div>
							<a href="{{ route('coin-edit') }}" class="btn btn-info" role="button">
								<i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Новая монета
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="filter-coin">Монета</label>
								<input class="form-control" id="filter-coin" type="text" name="filter-coin" value="{{ $filterCoin ?? '' }}" placeholder="Наименование">
							</div>
						</div>
						<table id="coinTable" class="table table-sm table-striped table-hover" data-action="{{ route('coin-list') }}">
							<thead>
							<tr>
								<th class="col-md-1 text-center border-right" scope="col">#</th>
								<th class="col-md-3 text-center border-right" scope="col">Наименование</th>
								<th class="col-md-1 text-center border-right" scope="col">Страна</th>
								<th class="col-md-1 text-center border-right text-nowrap" scope="col">Год выпуска</th>
								<th class="col-md-1 text-center border-right" scope="col">Металл</th>
								<th class="col-md-1 text-center border-right text-nowrap" scope="col">Вес металла</th>
								<th class="col-md-1 text-center border-right" scope="col">Номинал</th>
								<th class="col-md-1 text-center border-right" scope="col">Проба</th>
								<th class="col-md-1 text-center border-right" scope="col">Чеканка</th>
								<th class="col-md-1 text-center" scope="col">Действие</th>
							</tr>
							</thead>
							<tbody class="body">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
