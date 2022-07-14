@foreach($deals as $deal)
	<tr class="odd" data-id="{{ $deal->id }}">
		<th class="text-center align-middle border-right" scope="row">{{ $deal->id }}</th>
		<td class="align-middle border-right">{{ isset($deal->data_json['contractor']['name']) ? $deal->data_json['contractor']['name'] : '' }}</td>
		<td class="text-center align-middle border-right">{{ ($deal->deal_type == 'buy') ? 'Покупка' : 'Продажа' }}</td>
		<td class="text-center align-middle border-right">{{ $deal->deal_date ? $deal->deal_date->format('d.m.Y') : '' }}</td>
		<td class="border-right">
			@if(isset($deal->data_json['coins']) && $deal->data_json['coins'])
				<table class="table table-sm table-hover">
					<thead>
						<tr class="bg-white">
							<th class="text-center border-right col-md-6">Название</th>
							<th class="text-center border-right text-nowrap col-md-2">Цена, руб</th>
							<th class="text-center border-right text-nowrap col-md-1">Кол-во</th>
							<th class="text-center text-nowrap col-md-3">Сумма, руб</th>
						</tr>
					</thead>
				@php($dealAmount = 0)
				@foreach($deal->data_json['coins'] as $coin)
					@php($amount = $coin['price'] * $coin['quantity'])
					<tr class="bg-white">
						<td class="border-right">{{ $coin['name'] }}</td>
						<td class="text-right border-right">{{ number_format($coin['price'], 0, '.', ' ') }}</td>
						<td class="text-right border-right">{{ $coin['quantity'] }}</td>
						<td class="text-right">{{ number_format($amount, 0, '.', ' ') }}</td>
					</tr>
					@php($dealAmount += $amount)
				@endforeach
					<tfoot>
						<tr>
							<th colspan="3" class="text-right">Итого</th>
							<th class="text-right">{{ number_format($dealAmount, 0, '.', ' ') }}</th>
						</tr>
					</tfoot>
				</table>
			@endif
		</td>
		<td class="text-center align-middle border-right">
			<div class="d-flex justify-content-center">
				<a href="/deal/{{ $deal->id }}/print/specification" class="btn btn-light btn-sm border border-secondary" role="button" title="Печать Спецификации сделки" target="_blank"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;Спецификация</a>
				&nbsp;
				<a href="javascript:void(0)" class="btn btn-light btn-sm border border-secondary" role="button" title="Печать Анкеты"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;Анкета</a>
			</div>
		</td>
		<td class="text-center align-middle">
			<div class="d-flex justify-content-center">
				<a href="/deal/{{ $deal->id }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="fa-regular fa-pen-to-square"></i></a>
				&nbsp;
				<a href="javascript:void(0)" data-action-url="/deal/{{ $deal->id }}" class="btn btn-danger btn-sm js-delete-deal" role="button" title="Удалить"><i class="fa-regular fa-trash-can"></i></a>
			</div>
		</td>
	</tr>
@endforeach
