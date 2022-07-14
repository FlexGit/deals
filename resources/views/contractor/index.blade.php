@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-md-between">
						<span class="lead mt-1">{{ __('Контрагенты') }}</span>
						<div>
							<a href="{{ route('contractor-edit') }}" class="btn btn-info" role="button"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Новый контрагент</a>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="filter-contractor">Контрагент</label>
								<input class="form-control" id="filter-contractor" type="text" name="filter-contractor" value="{{ $filterContractor ?? '' }}" placeholder="ФИО">
							</div>
						</div>
						<table id="contractorTable" class="table table-sm table-striped table-hover" data-action="{{ route('contractor-list') }}">
							<thead>
							<tr>
								<th class="text-center border-right" scope="col">#</th>
								<th class="text-center border-right" scope="col" colspan="2">ФИО</th>
								<th class="text-center border-right" scope="col">Паспортные данные</th>
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
