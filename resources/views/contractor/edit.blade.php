@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9">
				<div class="card">
					<form id="contractor-form" method="POST" data-action="{{ route('contractor-list') }}" class="js-contractor-list" action="{{ route('contractor-save') }}" enctype="multipart/form-data">
						@csrf

						<div class="card-header d-flex justify-content-between">
							<span class="lead">{{ $contractor ? __('Контрагент #' . $contractor->id) : __('Новый контрагент') }}</span>
						</div>

						<div class="card-body">
							<div class="contractor-wrapper">
								@include('contractor.data', [
									'contractor' => $contractor,
								])
							</div>
						</div>

						<div class="card-footer d-flex justify-content-end">
							<button type="submit" class="btn btn-success mr-1 js-submit-contractor">
								<i class="icon-save" aria-hidden="true"></i>&nbsp;&nbsp;
								{{ __('Сохранить') }}
							</button>
							@if ($contractor)
								<a href="javascript:void(0)" data-action-url="/contractor/{{ $contractor->id }}" class="btn btn-danger mr-1 js-delete-contractor" role="button"><i class="icon-remove" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Удалить') }}</a>
							@endif
							<a href="{{ route('contractor-index') }}" class="btn btn-light mr-3" role="button"><i class="icon-backward" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Отменить') }}</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
