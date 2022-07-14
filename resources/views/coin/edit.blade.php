@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<form id="coin-form" method="POST" action="{{ route('coin-save') }}">
						@csrf

						<div class="card-header d-flex justify-content-between">
							<span class="lead">{{ $coin ? __('Монета #' . $coin->id) : __('Новая монета') }}</span>
						</div>

						<div class="card-body">
							<div class="coin-wrapper">
								@include('coin.data', [
									'coin' => $coin,
								])
							</div>
						</div>

						<div class="card-footer d-flex justify-content-end">
							<button type="submit" class="btn btn-success mr-1 js-submit-coin">
								<i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;{{ __('Сохранить') }}
							</button>
							@if ($coin)
								<a href="javascript:void(0)" data-action-url="/coin/{{ $coin->id }}" class="btn btn-danger mr-1 js-delete-coin" role="button">
									<i class="fa-regular fa-trash-can"></i>&nbsp;&nbsp;{{ __('Удалить') }}
								</a>
							@endif
							<a href="{{ route('coin-index') }}" class="btn btn-light mr-3" role="button">
								<i class="fa-solid fa-backward-step"></i>&nbsp;&nbsp;{{ __('Отменить') }}
							</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
