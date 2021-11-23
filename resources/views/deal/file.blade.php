<div class="row file-container">
	<div class="col-md-12">
		<div class="form-groupmb-0">
			<div class="col-form-label d-flex justify-content-start">
				<div>
					[<a href="javascript:void(0);" class="js-delete-file" data-action-url="{{ route('file-delete', ['id' => $deal->id, 'name' => $file['name'], 'ext' => $file['ext']]) }}" data-role="button" tabindex="-1"><i class="icon-remove" aria-hidden="true"></i></a>]
				</div>
				<div style="margin-left: 10px;">
					<span class="font-weight-bold">{{ __('Файл: ') }}</span>
					<a href="javascript:void(0)" class="js-get-file" data-path="/file/{{ $file['ext'] }}/{{ $file['name'] }}">{{ $file['name'] }}</a>
				</div>
			</div>
		</div>
	</div>
</div>
