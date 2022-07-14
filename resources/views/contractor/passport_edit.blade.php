@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<form id="passport-form" method="POST" action="{{ route('passport-save', ['id' => $contractor->id]) }}" enctype="multipart/form-data">
						@csrf

						<div class="card-header d-flex justify-content-between">
							<span class="lead font-weight-bold">{{ $passport ? __('Паспорт ' . $passport->series . ' ' . $passport->number . ', ' . ($passport->issue_date ? $passport->issue_date->format('d.m.Y') : '')) : __('Новая версия паспорта') }} контрагента {{ $contractor->name }}</span>
						</div>

						<div class="card-body">
							<div class="contractor-wrapper">
								@include('contractor.passport', [
									'passport' => $passport,
								])
							</div>
						</div>

						<div class="card-footer d-flex justify-content-end">
							<button type="submit" class="btn btn-success mr-1 js-submit-passport">
								<i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;{{ __('Сохранить') }}
							</button>
							@if ($passport)
								<a href="javascript:void(0)" data-action-url="/contractor/{{ $contractor->id }}/passport/{{ $passport->id }}" class="btn btn-danger mr-1 js-delete-passport" role="button">
									<i class="fa-regular fa-trash-can"></i>&nbsp;&nbsp;{{ __('Удалить') }}
								</a>
							@endif
							<a href="{{ route('contractor-index') }}" class="btn btn-light mr-3" role="button">
								<i class="fa-solid fa-backward-step"></i>&nbsp;&nbsp;{{ __('Отменить') }}
							</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
