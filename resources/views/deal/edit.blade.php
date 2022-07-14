@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="deal-form" method="POST" class="js-deal-list" data-action="{{ route('deal-list') }}" action="{{ route('deal-save') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <input type="hidden" id="deal-id" name="deal-id" value="{{ $deal ? $deal->id : '' }}">

                    <div class="card-header d-flex justify-content-between">
                        <span class="lead">{{ $deal ? __('Сделка #' . $deal->id . ' от ' . $deal->deal_date->format('d.m.Y')) : __('Новая сделка') }}</span>
                        @if($deal)
                            <div>
                                <a href="/deal/{{ $deal->id }}/print/specification" class="btn btn-light btn-sm border border-secondary" role="button" target="_blank">
                                    <i class="fa-solid fa-print"></i>&nbsp;&nbsp;Спецификация
                                </a>
                                <a href="javascript:void(0)" class="btn btn-light btn-sm border border-secondary" role="button">
                                    <i class="fa-solid fa-print"></i>&nbsp;&nbsp;Анкета
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2 vertical-align-middle">
                                <label for="deal-date" class="font-weight-bold">Тип сделки</label>
                                <div>
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
                            <div class="col-md-2">
                                <label for="deal-date" class="font-weight-bold">Дата сделки</label>
                                <input id="deal-date" type="date" class="form-control" name="deal-date" value="{{ $deal ? $deal->deal_date->format('Y-m-d') : date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="deal-legal-entity-id" class="font-weight-bold">Юридическое лицо</label>
                                <select id="deal-legal-entity-id" name="deal-legal-entity-id" class="form-control" required>
                                    <option></option>
                                    @foreach($legalEntities as $legalEntity)
                                        <option value="{{ $legalEntity->id }}" @if($deal && $legalEntity->id == $deal->legal_entity_id) selected @endif>{{ $legalEntity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span class="lead">Контрагент</span>
                    </div>
                    <div class="card-body">
                        @include('deal.contractor', [
                            'deal' => $deal,
                        ])
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span class="lead">Монеты</span>
                    </div>

                    <div class="card-body">
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

                                <div class="form-group text-right">
                                    <a href="javascript:void(0)" class="btn btn-info js-add-coin" role="button" tabindex="-1">
                                        <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;{{ __('Добавить монету') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success mr-1 js-submit-deal">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;{{ __('Сохранить') }}
                        </button>
                        @if ($deal)
                            <a href="javascript:void(0)" data-action-url="/deal/{{ $deal->id }}" class="btn btn-danger mr-1 js-delete-deal" role="button">
                                <i class="fa-regular fa-trash-can"></i>&nbsp;&nbsp;{{ __('Удалить') }}
                            </a>
                        @endif
                        <a href="{{ route('deal-index') }}" class="btn btn-light mr-3" role="button">
                            <i class="fa-solid fa-backward-step"></i>&nbsp;&nbsp;{{ __('Отменить') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
