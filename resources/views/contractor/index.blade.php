@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-md-between">
						<span class="lead mt-1">{{ __('Контрагенты') }}</span>
						<div>
							<a href="{{ route('contractor-edit') }}" class="btn btn-info" role="button"><i class="icon-plus" aria-hidden="true"></i>&nbsp;&nbsp;Новый контрагент</a>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row d-flex justify-content-start">
							<span class="col-md-1 font-weight-bold pt-2">Поиск: </span>
							<div class="col-md-4">
								<input id="search-contractor-name" type="text" class="form-control" name="search-contractor-name" data-source-url="{{ route('contractor-search') }}" placeholder="ФИО">
							</div>
						</div>
						<div class="js-contractor-list"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
