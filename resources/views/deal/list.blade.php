@foreach ($deals as $dealId => $deal)
	<tr>
		<th class="text-center border-right" scope="row">{{ $dealId }}</th>
		<td class="border-right">{{ $deal['contractor'] }}</td>
		<td class="text-center border-right">{{ $deal['deal_date'] }}</td>
		<td class="text-right border-right">{{ number_format($deal['deal_sum'], 2, '.', ' ') }}</td>
		<td class="text-center border-right">
			<div class="d-flex justify-content-around">
				<a href="/deal/{{ $dealId }}/print/specification" class="btn btn-light btn-sm border border-secondary" role="button" title="Печать Спецификации сделки" target="_blank"><i class="icon-print" aria-hidden="true"></i>&nbsp;&nbsp;Спецификация</a>
				<a href="javascript:void(0)" class="btn btn-light btn-sm border border-secondary" role="button" title="Печать Анкеты"><i class="icon-print" aria-hidden="true"></i>&nbsp;&nbsp;Анкета</a>
			</div>
		</td>
		<td class="text-center">
			<div class="d-flex justify-content-around">
				<a href="/deal/{{ $dealId }}" class="btn btn-info btn-sm" role="button" title="Редактировать"><i class="icon-edit" aria-hidden="true"></i></a>
				<a href="javascript:void(0)" data-action-url="/deal/{{ $dealId }}" class="btn btn-danger btn-sm js-delete-deal" role="button" title="Удалить"><i class="icon-remove" aria-hidden="true"></i></a>
			</div>
		</td>
	</tr>
@endforeach
