@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<form id="legal-entity-form" method="POST" action="{{ route('legal-entity-save') }}">
						@csrf

						<div class="card-header d-flex justify-content-between">
							<span class="lead">{{ $legalEntity ? __('Юридическое лицо #' . $legalEntity->name) : __('Новое юридическое лицо') }}</span>
						</div>

						<div class="card-body">
							<div class="legal-entity-wrapper">
								@include('legal-entity.data', [
									'legalEntity' => $legalEntity,
								])
							</div>
						</div>

						<div class="card-footer d-flex justify-content-end">
							<button type="submit" class="btn btn-success mr-1 js-submit-legal-entity">
								<i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;
								{{ __('Сохранить') }}
							</button>
							@if ($legalEntity)
								<a href="javascript:void(0)" data-action-url="/legal-entity/{{ $legalEntity->id }}" class="btn btn-danger mr-1 js-delete-legal-entity" role="button">
									<i class="fa-regular fa-trash-can"></i>&nbsp;&nbsp;{{ __('Удалить') }}
								</a>
							@endif
							<a href="{{ route('legal-entity-index') }}" class="btn btn-light mr-3" role="button">
								<i class="fa-solid fa-backward-step"></i>&nbsp;&nbsp;{{ __('Отменить') }}
							</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
