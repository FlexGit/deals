<div class="row">
	<input type="hidden" id="id" name="id" value="{{ $legalEntity ? $legalEntity->id : '' }}">

	<div class="col-md-12">
		<div class="form-group row">
			<div class="col-md-6">
				<label class="font-weight-bold">Наименование</label>
				<input id="name" type="text" class="form-control" name="name" value="{{ $legalEntity ? $legalEntity->name : '' }}" placeholder="Наименование" required>
			</div>
			<div class="col-md-2">
				<label class="font-weight-bold">ИНН</label>
				<input id="inn" type="text" class="form-control" name="inn" value="{{ $legalEntity ? $legalEntity->inn : '' }}" placeholder="ИНН" required>
			</div>
			<div class="col-md-2">
				<label class="font-weight-bold">КПП</label>
				<input id="kpp" type="text" class="form-control" name="kpp" value="{{ $legalEntity ? $legalEntity->kpp : '' }}" placeholder="КПП" required>
			</div>
			<div class="col-md-2">
				<label class="font-weight-bold">ОГРН</label>
				<input id="ogrn" type="text" class="form-control" name="ogrn" value="{{ $legalEntity ? $legalEntity->ogrn : '' }}" placeholder="ОГРН" required>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-6">
				<label class="font-weight-bold">Банк</label>
				<input id="bank" type="text" class="form-control" name="bank" value="{{ $legalEntity ? $legalEntity->bank : '' }}" placeholder="Банк" required>
			</div>
			<div class="col-md-2">
				<label class="font-weight-bold">Р/С</label>
				<input id="rs" type="text" class="form-control" name="rs" value="{{ $legalEntity ? $legalEntity->rs : '' }}" placeholder="Р/С" required>
			</div>
			<div class="col-md-2">
				<label class="font-weight-bold">К/С</label>
				<input id="ks" type="text" class="form-control" name="ks" value="{{ $legalEntity ? $legalEntity->ks : '' }}" placeholder="К/С" required>
			</div>
			<div class="col-md-2">
				<label class="font-weight-bold">БИК</label>
				<input id="bik" type="text" class="form-control" name="bik" value="{{ $legalEntity ? $legalEntity->bik : '' }}" placeholder="БИК" required>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-6">
				<label class="font-weight-bold">Юридический адрес</label>
				<input id="address" type="text" class="form-control" name="address" value="{{ $legalEntity ? $legalEntity->address : '' }}" placeholder="Юридический адрес" required>
			</div>
		</div>
	</div>
</div>