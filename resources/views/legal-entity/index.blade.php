@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-md-between">
						<span class="lead mt-1">{{ __('Юридические лица') }}</span>
						<div>
							<a href="{{ route('legal-entity-edit') }}" class="btn btn-info" role="button">
								<i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Новое юридическое лицо
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="js-legal-entity-list" data-action="{{ route('legal-entity-list') }}"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
