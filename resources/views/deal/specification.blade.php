@php
	$data = $deal->data_json;
	$contractor = (isset($data['contractor']) && $data['contractor']) ? $data['contractor'] : [];
	$passport = $deal->passport ?? null;
	$legalEntity = $deal->legalEntity ?? null;
	$coins = $data['coins'] ?? [];
	$sumAmount = 0;

	$clientRequisites = '
		<span class="font-weight-bold">' . ($contractor ? $contractor['name'] : '') . '</span>
		<br><br>
		<span class="font-weight-bold">Паспорт: </span> <span>' . ($passport ? ($passport->series . ' ' . $passport->number . ', ' . ($passport->issue_date ? $passport->issue_date->format('d.m.Y') : '') . ', ' . $passport->issue_office) : '') . '</span>
		<br><br>
		<span class="font-weight-bold">Адрес регистрации: </span> <span>' . ($passport ? ($passport->zipcode . ', ' . $passport->region . ', ' . $passport->city . ', ' . $passport->street . ', ' . ($passport->house ? 'д. ' . $passport->house : '') . ', ' . ($passport->apartment ? 'кв. ' . $passport->apartment : '')) : '') . '</span>';

	$companyRequisites = '
		<span class="font-weight-bold">' . ($legalEntity ? $legalEntity->name : '') . '</span>
		<br>
		<span>ИНН ' . ($legalEntity ? $legalEntity->inn : '') . ' / КПП ' . ($legalEntity ? $legalEntity->kpp : '') . '</span>
		<br>
		<span>ОГРН ' . ($legalEntity ? $legalEntity->ogrn : '') . '</span>
		<br><br>
		<span>' . ($legalEntity ? $legalEntity->bank : '') . '</span>
		<br>
		<span>Р/С: № ' . ($legalEntity ? $legalEntity->rs : '') . '</span>
		<br>
		<span>К/С: № ' . ($legalEntity ? $legalEntity->ks : '') . '</span>
		<br>
		<span>БИК ' . ($legalEntity ? $legalEntity->bik : '') .'</span>
		<br><br>
		<span class="font-weight-bold">Юридический адрес: </span>
		<span>' . ($legalEntity ? $legalEntity->address : '') . '</span>
		<br><br>
		<span class="font-weight-bold">Генеральный директор ' . ($legalEntity ? $legalEntity->name : '') . '</span>';
@endphp

@extends('layouts.print')

@section('content')
	<div>
		<h4 class="mb-3 text-center">ПРИЕМО ПЕРЕДАТОЧНЫЙ АКТ<br>КУПЛИ-ПРОДАЖИ МОНЕТ</h4>

		Настоящий Акт составлен в соответствии с Правилами оказания услуг опубликованном по адресу: <a href="https://www.zolotoy-zapas.ru" target="_blank">https://www.zolotoy-zapas.ru</a> об общих условиях совершения сделок с монетами из драгоценных металлов (с юридическими лицами, индивидуальными предпринимателями и физическими лицами, занимающимися в установленном законодательством Российской Федерации порядке частной практикой) № 06-М/11/16 от 18 ноября 2016 г. (далее – Правила).
		<br>
		Все термины, используемые в настоящем Акте, имеют значение, указанное в Правилах.
		<br>
		Настоящим указанные ниже Стороны подтверждают совершение Сделки покупки/продажи Монет из драгоценных металлов на следующих условиях:

		<table class="coins-table mt-2 mb-2">
			<thead>
				<tr>
					<td>№<br>п/п</td>
					<td>Наименование<br>Монеты, страна,<br>год выпуска</td>
					<td>Драгоценный<br>металл</td>
					<td>Значение<br>номинала</td>
					<td>Проба</td>
					<td>Качество<br>чеканки</td>
					<td>Цена,<br>руб./шт.</td>
					<td>Кол-во,<br>шт.</td>
					<td>Общая<br>стоимость,<br>руб.</td>
				</tr>
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
					<td>5</td>
					<td>6</td>
					<td>7</td>
					<td>8</td>
					<td>9</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="8" class="pt-1 pb-1 font-weight-bold">Инвестиционные монеты</td>
				</tr>
			</thead>
			<tbody>
				@foreach ($coins as $index => $coin)
					@php($amount = $coin['price'] * $coin['quantity'])
					<tr>
						<td>{{ ($index + 1) }}</td>
						<td>{{ $coin['name'] }}{{ $coin['country'] ? ', ' . $coin['country'] : '' }}{{ $coin['year'] ? ', ' . $coin['year'] : '' }}</td>
						<td>{{ $coin['metal'] }}</td>
						<td class="text-nowrap">{{ $coin['denomination'] }}</td>
						<td>{{ $coin['fineness'] }}</td>
						<td>{{ $coin['coinage'] }}</td>
						<td class="text-right text-nowrap">{{ number_format($coin['price'], 0, '.', ' ') }}</td>
						<td class="text-right text-nowrap">{{ number_format($coin['quantity'], 0, '.', ' ') }}</td>
						<td class="text-right text-nowrap">{{ number_format($amount, 0, '.', ' ') }}</td>
					</tr>
					@php($sumAmount += $amount)
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" class="text-center font-weight-bold">ИТОГО</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right font-weight-bold">{{ number_format($sumAmount, 0, '.', ' ') }}</td>
				</tr>
			</tfoot>
		</table>
		<div class="mb-3">Общая стоимость: {{ number_format($sumAmount, 0, '.', ' ') }} руб. 00 коп. (<span id="sum-letter" data-sum="{{ $sumAmount }}"></span>)</div>
		Место совершения сделки, передачи денежных средств и монет: 123317, г. Москва, Пресненская набережная, д. 12, 36 этаж, офис № 7.<br>
		Основание для совершения сделки является согласие Сторон с правилами и условиями совершения сделок с монетами из драгоценных металлов опубликованными по адресу: <a href="https://www.zolotoy-zapas.ru" target="_blank">https://www.zolotoy-zapas.ru</a> и являющимися договором оферты.  Принимая условия настоящего акта, Стороны подтверждают свое согласие на совершение сделки купли/продажи монет и принимают обязательства оплаты монет в соответствии с данными, указанными в настоящем акте.<br>
		Стороны подтверждают, что монеты/денежные средства не находятся под залогом и/или иным обременением. Стороны заключают сделку в своих интересах, в соответствии с действующим законодательством РФ в целях тезаврации (приобретения сберегательных монет). Стороны подтверждают, что уплата налоговых требований является обязательством налогоплательщика, получающего доход и обязанностей налогового агента у второй стороны не возникает.
		<hr>
		<div class="mt-4" style="page-break-inside: avoid;">
			<div class="row text-left">
				<div class="col-6 pr-5">
					<h5 class="mb-3">ПРОДАВЕЦ</h5>
					@if($deal->deal_type == 'sell')
						{!! $companyRequisites !!}
					@else
						{!! $clientRequisites !!}
					@endif
				</div>
				<div class="col-6 pl-5">
					<h5 class="mb-3">ПОКУПАТЕЛЬ</h5>
					@if($deal->deal_type == 'buy')
						{!! $companyRequisites !!}
					@else
						{!! $clientRequisites !!}
					@endif
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-6 pr-5">
					____________________/_____________/
				</div>
				<div class="col-6 pl-5">
					____________________/_____________/
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-center mt-4">
			<img src="/images/qr-terms.svg" alt="">
		</div>
	</div>
@endsection
