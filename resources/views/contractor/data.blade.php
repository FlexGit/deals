<input type="hidden" id="contractor-id" name="contractor-id" value="{{ $contractor ? $contractor->id : '' }}">

<div class="form-group row">
	<div class="col-md-6">
		<label class="font-weight-bold">ФИО</label>
		<input id="contractor-name" type="text" class="form-control" name="contractor-name" value="{{ $contractor ? $contractor->name : '' }}" placeholder="ФИО" required>
	</div>
</div>
