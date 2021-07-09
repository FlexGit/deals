<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Coin;
use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DealController extends Controller {
	private $request;
	private $user;
	
	/**
	 * @param Request $request
	 */
	public function __construct(Request $request) {
		$this->middleware('auth');
		
		$this->user = Auth::user();
		$this->request = $request;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function getDeals() {
		return view('deal.index');
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList() {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$contractorName = $this->request->get('contractor') ?: '';
		
		$contractorIds = [];
		if ($contractorName) {
			$contractorIds = Contractor::where('name', $contractorName)
				->pluck('id')->all();
		}
		
		if ($contractorIds) {
			$deals = Deal::whereIn('contractor_id', $contractorIds)
				->orderBy('id', 'desc')
				->get();
		} else {
			$deals = Deal::orderBy('id', 'desc')
				->take(10)
				->get();
		}
		$dealsData = [];
		foreach ($deals as $deal) {
			$dealSum = 0;
			$dealData = $deal->data_json;
			foreach ($dealData['coins'] ?: [] as $coin) {
				$dealSum += $coin['quantity'] * $coin['price'];
			}
			$dealsData[$deal->id] = [
				'contractor' => array_key_exists('name', $deal->data_json['contractor']) ? $deal->data_json['contractor']['name'] : '',
				'deal_date' => $deal->deal_date->format('d.m.Y'),
				'deal_type' => $deal->deal_type,
				'deal_sum' => $dealSum,
			];
		}
		
		$VIEW = view('deal.list', ['deals' => $dealsData]);
		
		return response()->json(['status' => 'success', 'html' => (string)$VIEW]);
	}
	
	/**
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit($id = null) {
		$deal = $id ? Deal::findOrFail($id) : [];

		return view('deal.edit')
			->with('deal', $deal);
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function save() {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
	
		$rules = [
			'deal-date' => 'required|date|after:01.01.2015',
			'deal-type' => 'required|in:buy,sell',
			'contractor-name' => 'required|max:255',
			'passport-series' => 'required|max:255',
			'passport-number' => 'required|max:255',
			'passport-date' => 'required|date|after:01.01.1900',
			'passport-office' => 'required|max:255',
			'passport-address' => 'required|max:255',
			'passport-file-1' => 'required_without:contractor-id|image|max:10240',
			'passport-file-2' => 'required_without:contractor-id|image|max:10240',
			'coin-name.*' => 'required|max:255',
			'coin-country.*' => 'nullable|max:255',
			'coin-year.*' => 'nullable|digits:4',
			'coin-metal.*' => 'nullable|max:255',
			'coin-denomination.*' => 'nullable|max:255',
			'coin-fineness.*' => 'nullable|max:255',
			'coin-coinage.*' => 'nullable|max:255',
			'coin-quantity.*' => 'required|numeric',
			'coin-price.*' => 'required|numeric',
		];
		$validator = Validator::make($this->request->all(), $rules);
		if (!$validator->passes()) {
			return response()->json(['status' => 'error', 'reason' => implode('<br>', $validator->errors()->all())]);
		}
	
		$dealId = $this->request->post('deal-id') ?: '';
		$contractorId = $this->request->post('contractor-id') ?: '';
		if ($contractorId) {
			$contractor = Contractor::find($contractorId);
			if (!$contractor) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагента #' . $contractorId . ' не существует']);
			}
			$contractorData = $contractor->data_json;
		}
	
		$coinIds = $this->request->post('coin-id') ?: [];
		$coinNames = $this->request->post('coin-name') ?: [];
		$coinQuantities = $this->request->post('coin-quantity') ?: [];
		$coinPrices = $this->request->post('coin-price') ?: [];
		$coinCountries = $this->request->post('coin-country') ?: [];
		$coinYears = $this->request->post('coin-year') ?: [];
		$coinMetals = $this->request->post('coin-metal') ?: [];
		$coinDenominations = $this->request->post('coin-denomination') ?: [];
		$coinFinenesses = $this->request->post('coin-fineness') ?: [];
		$coinCoinages = $this->request->post('coin-coinage') ?: [];
		
		$coinsData = [];
		foreach ($coinNames as $index => $coinName) {
			$coinsData[] = [
				'name' => $coinName,
				'id' => array_key_exists($index, $coinIds) ? $coinIds[$index] : '',
				'quantity' => array_key_exists($index, $coinQuantities) ? $coinQuantities[$index] : 0,
				'price' => array_key_exists($index, $coinPrices) ? $coinPrices[$index] : 0,
				'country' => array_key_exists($index, $coinCountries) ? $coinCountries[$index] : '',
				'year' => array_key_exists($index, $coinYears) ? $coinYears[$index] : '',
				'metal' => array_key_exists($index, $coinMetals) ? $coinMetals[$index] : '',
				'denomination' => array_key_exists($index, $coinDenominations) ? $coinDenominations[$index] : '',
				'fineness' => array_key_exists($index, $coinFinenesses) ? $coinFinenesses[$index] : '',
				'coinage' => array_key_exists($index, $coinCoinages) ? $coinCoinages[$index] : '',
			];
		}
	
		if ($this->request->post('contractor-name')) {
			$contractorData['name'] = $this->request->post('contractor-name');
		}
		if ($this->request->post('passport-series')) {
			$contractorData['passport_series'] = $this->request->post('passport-series');
		}
		if ($this->request->post('passport-number')) {
			$contractorData['passport_number'] = $this->request->post('passport-number');
		}
		if ($this->request->post('passport-date')) {
			$contractorData['passport_date'] = Carbon::parse($this->request->post('passport-date'))->timestamp;
		}
		if ($this->request->post('passport-office')) {
			$contractorData['passport_office'] = $this->request->post('passport-office');
		}
		if ($this->request->post('passport-address')) {
			$contractorData['passport_address'] = $this->request->post('passport-address');
		}
		if ($this->request->file('passport-file-1')) {
			$passportFile1Name =  Str::uuid()->toString();
			$passportFile1Ext =  $this->request->file('passport-file-1')->extension();
			
			if ($this->request->file('passport-file-1')->storeAs('passport', $passportFile1Name . '.' . $passportFile1Ext)) {
				$contractorData['passport_file_1'] = [
					'name' => $passportFile1Name,
					'ext' => $passportFile1Ext,
				];
			}
		}
		if ($this->request->file('passport-file-2')) {
			$passportFile2Name =  Str::uuid()->toString();
			$passportFile2Ext =  $this->request->file('passport-file-2')->extension();
			
			if ($this->request->file('passport-file-2')->storeAs('passport', $passportFile2Name . '.' . $passportFile2Ext)) {
				$contractorData['passport_file_2'] = [
					'name' => $passportFile2Name,
					'ext' => $passportFile2Ext,
				];
			}
		}
		
		if (!$contractorId) {
			$contractor = new Contractor();
			$contractor->name = $this->request->post('contractor-name');
			$contractor->data_json = $contractorData;
			$contractor->created_by = Auth::id();
			$contractor->updated_by = Auth::id();
			if (!$contractor->save()) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
			}
		}
	
		foreach ($coinsData as $index => $coinData) {
			if (!$coinData['id']) {
				unset($coinData['id']);
				
				$coin = new Coin();
				$coin->name = $coinData['name'];
				$coin->data_json = [
					'country' => $coinData['country'],
					'year' => $coinData['year'],
					'metal' => $coinData['metal'],
					'denomindation' => $coinData['denomindation'],
					'fineness' => $coinData['fineness'],
					'coinage' => $coinData['coinage'],
				];
				$coin->created_by = Auth::id();
				$coin->updated_by = Auth::id();
				if (!$coin->save()) {
					return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
				}
				$coinsData[$index]['id'] = $coin->id;
			}
		}
	
		if ($dealId) {
			$deal = Deal::find($dealId);
			if (!$deal) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
			}
		}
		else {
			$deal = new Deal();
		}
		$deal->contractor_id = $contractor->id;
		$deal->data_json = [
			'contractor' => $contractorData,
			'coins' => $coinsData,
		];
		$deal->deal_date = $this->request->post('deal-date');
		$deal->deal_type = $this->request->post('deal-type');
		if (!$dealId) {
			$deal->created_by = Auth::id();
		}
		$deal->updated_by = Auth::id();
		if (!$deal->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'deal_id' => $deal->id]);
	}
	
	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id) {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
  
		$deal = Deal::find($id);
		if (!$deal) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		if (!$deal->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'deal_id' => $id]);
	}
	
	public function printSpecification($id) {
		$deal = $id ? Deal::findOrFail($id) : [];
		
		return view('deal.specification')
			->with('deal', $deal);
	}
}
