@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-md-between">
						<span class="lead mt-1">{{ __('Последние сделки') }}</span>
						<div>
							<a href="{{ route('deal-edit') }}" class="btn btn-info" role="button">
								<i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Новая сделка
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-3">
								<label for="filter-contractor">Контрагент</label>
								<input class="form-control" id="filter-contractor" type="text" name="filter-contractor" value="{{ $filterContractor ?? '' }}" placeholder="ФИО">
							</div>
							<div class="form-group col-md-2">
								<label for="filter-period">Дата сделки</label>
								<select class="form-control" id="filter-period" name="filter-period">
									<option value="" @if(!$filterPeriod) selected @endif>---</option>
									<option value="day" @if($filterPeriod == 'day') selected @endif>День</option>
									<option value="week" @if($filterPeriod == 'week') selected @endif>Неделя</option>
									<option value="month" @if($filterPeriod == 'month') selected @endif>Месяц</option>
									<option value="month_3" @if($filterPeriod == 'month_3') selected @endif>3 месяца</option>
									<option value="month_6" @if($filterPeriod == 'month_6') selected @endif>6 месяцев</option>
									<option value="year" @if($filterPeriod == 'year') selected @endif>Год</option>
									<option value="other" @if($filterPeriod == 'other') selected @endif>Произвольный период</option>
								</select>
							</div>
							<div class="filter-period-other-container form-group col-md-3 @if($filterPeriod != 'other') hidden @endif">
								<label for="filter-period-from">Произвольный период</label>
								<div class="d-flex">
									<input type="date" class="form-control" id="filter-period-from" name="filter-period-from" value="{{ $filterPeriodFrom ?? '' }}">
									&nbsp;
									<input type="date" class="form-control" id="filter-period-to" name="filter-period-to" value="{{ $filterPeriodTo ?? '' }}">
								</div>
							</div>
							<div class="form-group col-md-2">
								<label for="filter-deal-type">Тип сделки</label>
								<select class="form-control" id="filter-deal-type" name="filter-deal-type">
									<option value="">---</option>
									<option value="buy" @if($filterDealType == 'buy') selected @endif>Покупка</option>
									<option value="sell" @if($filterDealType == 'sell') selected @endif>Продажа</option>
								</select>
							</div>
						</div>
						<table id="dealTable" class="table table-sm table-striped table-hover" data-action="{{ route('deal-list') }}">
							<thead>
							<tr>
								<th class="text-center border-right" scope="col">#</th>
								<th class="text-center border-right" scope="col">Контрагент</th>
								<th class="text-center border-right" scope="col">Тип сделки</th>
								<th class="text-center border-right" scope="col">Дата</th>
								<th class="text-center border-right" scope="col">Монеты</th>
								<th class="text-center border-right" scope="col">Документы</th>
								<th class="text-center" scope="col">Действие</th>
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
