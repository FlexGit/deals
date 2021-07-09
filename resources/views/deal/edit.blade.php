@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 90%;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form id="deal-form" method="POST" action="{{ route('deal-save') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="deal-id" name="deal-id" value="{{ $deal ? $deal->id : '' }}">

                    <div class="card-header d-flex justify-content-between">
                        <span class="lead">{{ $deal ? __('Сделка #' . $deal->id . ' от ' . $deal->deal_date->format('d.m.Y')) : __('Новая сделка') }}</span>
                        @if($deal)
                            <div>
                                <a href="/deal/{{ $deal->id }}/print/specification" class="btn btn-light btn-sm border border-secondary" role="button" target="_blank"><i class="icon-print" aria-hidden="true"></i>&nbsp;&nbsp;Спецификация</a>
                                <a href="javascript:void(0)" class="btn btn-light btn-sm border border-secondary" role="button"><i class="icon-print" aria-hidden="true"></i>&nbsp;&nbsp;Анкета</a>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row border-between">
                            <div class="col-md-6 pr-5 contractor-wrapper">
                                <div class="form-group row">
                                    <label for="deal-date" class="col-md-3 col-form-label text-md-right font-weight-bold">{{ __('Дата сделки') }}</label>
                                    <div class="col-md-4">
                                        <input id="deal-date" type="date" class="form-control" name="deal-date" value="{{ $deal ? $deal->deal_date->format('Y-m-d') : date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-5 vertical-align-middle">
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 0.5rem;">
                                            <input type="radio" class="custom-control-input" id="deal-type-buy" name="deal-type" value="buy" required {{ ($deal && $deal->deal_type == 'buy') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="deal-type-buy">Покупка</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="margin-top: 0.5rem;">
                                            <input type="radio" class="custom-control-input" id="deal-type-sell" name="deal-type" value="sell" required {{ ($deal && $deal->deal_type == 'sell') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="deal-type-sell">Продажа</label>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                @include('deal.contractor', [
									'deal' => $deal,
								])
                            </div>

                            <div class="col-md-6 pl-5 coin-wrapper">
                                <div class="row coins">
                                    <div class="col-md-12">
                                        @if ($deal && array_key_exists('coins', $deal->data_json))
                                            @foreach ($deal->data_json['coins'] as $index => $coin)
                                                @include('deal.coin', [
                                                    'index' => $index,
                                                    'coin' => $coin,
                                                ])
                                            @endforeach
                                        @else
                                            @include('deal.coin', [
                                                'index' => 0,
                                                'coin' => [],
                                            ])
                                        @endif

                                        <div class="form-group row">
                                            <a href="javascript:void(0)" class="btn btn-link js-add-coin" role="button" tabindex="-1">{{ __('Добавить монету') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success mr-1 js-submit-deal">
                            <i class="icon-save" aria-hidden="true"></i>&nbsp;&nbsp;
                            {{ __('Сохранить') }}
                        </button>
                        @if ($deal)
                            <a href="javascript:void(0)" data-action-url="/deal/{{ $deal->id }}" class="btn btn-danger mr-1 js-delete-deal" role="button"><i class="icon-remove" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Удалить') }}</a>
                        @endif
                        <a href="{{ route('deal-index') }}" class="btn btn-light mr-3" role="button"><i class="icon-backward" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('Отменить') }}</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
