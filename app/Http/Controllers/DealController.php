<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Coin;
use App\Models\Deal;
use App\Models\LegalEntity;
use App\Models\Passport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

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
		$filterContractor = $this->request->session()->get('deal-filter-contractor');
		$filterPeriod = $this->request->session()->get('deal-filter-period');
		$filterPeriodFrom = $this->request->session()->get('deal-filter-period-from');
		$filterPeriodTo = $this->request->session()->get('deal-filter-period-to');
		$filterDealType = $this->request->session()->get('deal-filter-deal-type');

		return view('deal.index', [
			'filterContractor' => $filterContractor,
			'filterPeriod' => $filterPeriod,
			'filterPeriodFrom' => $filterPeriodFrom,
			'filterPeriodTo' => $filterPeriodTo,
			'filterDealType' => $filterDealType,
		]);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList() {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$id = $this->request->get('id') ?? 0;
		$filterContractor = $this->request->get('filter-contractor') ?? '';
		$filterPeriod = $this->request->get('filter-period') ?? '';
		$filterPeriodFrom = $this->request->get('filter-period-from') ?? '';
		$filterPeriodTo = $this->request->get('filter-period-to') ?? '';
		$filterDealType = $this->request->get('filter-deal-type') ?? '';
		
		if ($this->request->exists('filter-contractor')) {
			$this->request->session()->put('deal-filter-contractor', $filterContractor);
		}
		if ($this->request->exists('filter-period')) {
			$this->request->session()->put('deal-filter-period', $filterPeriod);
		}
		if ($this->request->exists('filter-period-from')) {
			$this->request->session()->put('deal-filter-period-from', $filterPeriodFrom);
		}
		if ($this->request->exists('filter-period-to')) {
			$this->request->session()->put('deal-filter-period-to', $filterPeriodTo);
		}
		if ($this->request->exists('filter-deal-type')) {
			$this->request->session()->put('deal-filter-deal-type', $filterDealType);
		}
		
		$filterContractor = $this->request->session()->get('deal-filter-contractor');
		$filterPeriod = $this->request->session()->get('deal-filter-period');
		$filterPeriodFrom = $this->request->session()->get('deal-filter-period-from');
		$filterPeriodTo = $this->request->session()->get('deal-filter-period-to');
		$filterDealType = $this->request->session()->get('deal-filter-deal-type');
		
		$deals = Deal::orderBy('id', 'desc');
		if ($filterContractor) {
			$deals = $deals->whereHas('contractor', function ($query) use ($filterContractor) {
				$query->where('name', 'like', '%' . $filterContractor . '%');
			});
		}
		if ($filterPeriod) {
			switch ($filterPeriod) {
				case 'day':
					$deals = $deals->where('deal_date', '>=', Carbon::now()->subDay()->startOfDay()->format('Y-m-d H:i:s'));
				break;
				case 'week':
					$deals = $deals->where('deal_date', '>=', Carbon::now()->subWeek()->startOfDay()->format('Y-m-d H:i:s'));
				break;
				case 'month':
					$deals = $deals->where('deal_date', '>=', Carbon::now()->subMonth()->startOfDay()->format('Y-m-d H:i:s'));
				break;
				case 'month_3':
					$deals = $deals->where('deal_date', '>=', Carbon::now()->subMonths(3)->startOfDay()->format('Y-m-d H:i:s'));
				break;
				case 'month_6':
					$deals = $deals->where('deal_date', '>=', Carbon::now()->subMonths(6)->startOfDay()->format('Y-m-d H:i:s'));
				break;
				case 'year':
					$deals = $deals->where('deal_date', '>=', Carbon::now()->subYear()->startOfDay()->format('Y-m-d H:i:s'));
				break;
				case 'other':
					if ($filterPeriodFrom) {
						$deals = $deals->where('deal_date', '>=', Carbon::parse($filterPeriodFrom)->startOfDay()->format('Y-m-d H:i:s'));
					}
					if ($filterPeriodTo) {
						$deals = $deals->where('deal_date', '<=', Carbon::parse($filterPeriodTo)->endOfDay()->format('Y-m-d H:i:s'));
					}
				break;
			}
		}
		if ($filterDealType) {
			$deals = $deals->where('deal_type', $filterDealType);
		}
		if ($id) {
			$deals = $deals->where('id', '<', $id);
		}
		$deals = $deals->limit(Deal::LIST_LIMIT)->get();
		
		$VIEW = view('deal.list', [
			'deals' => $deals,
		]);
		
		return response()->json(['status' => 'success', 'html' => (string)$VIEW]);
	}
	
	/**
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit($id = null) {
		$deal = $id ? Deal::findOrFail($id) : [];
		
		$legalEntities = LegalEntity::orderBy('name')
			->get();

		return view('deal.edit', [
			'deal' => $deal,
			'contractor' => $deal->contractor ?? null,
			'passport' => $deal->passport ?? null,
			'legalEntities' => $legalEntities,
		]);
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function save() {
		if (!$this->request->ajax()) {
			abort(404);
		}
	
		$rules = [
			'deal-date' => 'required|date|after:01.01.2015',
			'deal-type' => 'required|in:buy,sell',
			'contractor-name' => 'required|max:255',
			'passport-series' => 'required|max:255',
			'passport-number' => 'required|max:255',
			'passport-date' => 'required|date|after:01.01.1900',
			'passport-office' => 'required|max:255',
			'passport-zipcode' => 'required|max:25',
			'passport-region' => 'required|max:255',
			'passport-city' => 'required|max:255',
			'passport-street' => 'required|max:255',
			'passport-house' => 'required|max:25',
			'passport-file-1' => 'required_without:contractor-id|image|max:10240',
			'passport-file-2' => 'required_without:contractor-id|image|max:10240',
			'coin-name.*' => 'required|max:255',
			'coin-country.*' => 'nullable|max:255',
			'coin-year.*' => 'nullable|max:255',
			'coin-metal.*' => 'nullable|max:255',
			'coin-metal-weight.*' => 'nullable|max:255',
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
	
		$contractorId = $this->request->post('contractor-id') ?: '';
		if ($contractorId) {
			$contractor = Contractor::find($contractorId);
			if (!$contractor) {
				return response()->json(['status' => 'error', 'reason' => 'Контрагент не найден']);
			}
		}
	
		$passportId = $this->request->post('passport-id') ?: '';
		if ($passportId) {
			$passport = Passport::find($passportId);
			if (!$passport) {
				return response()->json(['status' => 'error', 'reason' => 'Паспортные данные не найдены']);
			}
		}
		$passportData = $passport->data_json ?? [];
	
		$isNewPassportVersion = $this->request->post('is-new-passport-version') ?: 0;
		if($isNewPassportVersion || !$passportId) {
			$passport = new Passport();
		}
	
		$dealId = $this->request->post('deal-id') ?: '';
		if ($dealId) {
			$deal = Deal::find($dealId);
			if (!$deal) {
				return response()->json(['status' => 'error', 'reason' => 'Сделка не найдена']);
			}
		} else {
			$deal = new Deal();
		}

		$contractorData = [
			'name' => $this->request->post('contractor-name') ?? '',
		];
	
		$coinIds = $this->request->post('coin-id') ?: [];
		$coinNames = $this->request->post('coin-name') ?: [];
		$coinQuantities = $this->request->post('coin-quantity') ?: [];
		$coinPrices = $this->request->post('coin-price') ?: [];
		$coinCountries = $this->request->post('coin-country') ?: [];
		$coinYears = $this->request->post('coin-year') ?: [];
		$coinMetals = $this->request->post('coin-metal') ?: [];
		$coinMetalWeights = $this->request->post('coin-metal-weight') ?: [];
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
				'metalWeight' => array_key_exists($index, $coinMetalWeights) ? $coinMetalWeights[$index] : '',
				'denomination' => array_key_exists($index, $coinDenominations) ? $coinDenominations[$index] : '',
				'fineness' => array_key_exists($index, $coinFinenesses) ? $coinFinenesses[$index] : '',
				'coinage' => array_key_exists($index, $coinCoinages) ? $coinCoinages[$index] : '',
			];
		}
	
		try {
			\DB::beginTransaction();
		
			if (!$contractorId) {
				$contractor = new Contractor();
				$contractor->name = $this->request->post('contractor-name') ?? '';
				$contractor->created_by = Auth::id();
				$contractor->updated_by = Auth::id();
				$contractor->save();
			}
			
			$passport->contractor_id = $contractor->id;
			$passport->number = $this->request->post('passport-number') ?? null;
			$passport->series = $this->request->post('passport-series') ?? null;
			$passport->issue_date = $this->request->post('passport-date') ? Carbon::parse($this->request->post('passport-date')) : null;
			$passport->issue_office = $this->request->post('passport-office') ?? null;
			$passport->zipcode = $this->request->post('passport-zipcode') ?? 0;
			$passport->region = $this->request->post('passport-region') ?? null;
			$passport->city = $this->request->post('passport-city') ?? null;
			$passport->street = $this->request->post('passport-street') ?? null;
			$passport->house = $this->request->post('passport-house') ?? null;
			$passport->apartment = $this->request->post('passport-apartment') ?? null;
			if ($this->request->file('passport-file-1')) {
				$passportFile1Name =  Str::uuid()->toString();
				$passportFile1Ext =  $this->request->file('passport-file-1')->extension();
				if ($this->request->file('passport-file-1')->storeAs('passport', $passportFile1Name . '.' . $passportFile1Ext)) {
					$passportData['passport_file_1'] = [
						'name' => $passportFile1Name,
						'ext' => $passportFile1Ext,
					];
				}
			}
			if ($this->request->file('passport-file-2')) {
				$passportFile2Name =  Str::uuid()->toString();
				$passportFile2Ext =  $this->request->file('passport-file-2')->extension();
				if ($this->request->file('passport-file-2')->storeAs('passport', $passportFile2Name . '.' . $passportFile2Ext)) {
					$passportData['passport_file_2'] = [
						'name' => $passportFile2Name,
						'ext' => $passportFile2Ext,
					];
				}
			}
			$passport->data_json = $passportData;
			if ($isNewPassportVersion || !$passportId) {
				$passport->created_by = Auth::id();
			}
			$passport->updated_by = Auth::id();
			$passport->save();
			
			foreach ($coinsData as $index => $coinData) {
				if (!$coinData['id']) {
					unset($coinData['id']);
					
					$coin = new Coin();
					$coin->name = $coinData['name'];
					$coin->data_json = [
						'country' => $coinData['country'],
						'year' => $coinData['year'],
						'metal' => $coinData['metal'],
						'metalWeight' => $coinData['metalWeight'],
						'denomination' => $coinData['denomination'],
						'fineness' => $coinData['fineness'],
						'coinage' => $coinData['coinage'],
					];
					$coin->created_by = Auth::id();
					$coin->updated_by = Auth::id();
					$coin->save();

					$coinsData[$index]['id'] = $coin->id;
				}
			}
		
			$deal->contractor_id = $contractor->id;
			$deal->passport_id = $passport->id;
			$deal->data_json = [
				'contractor' => $contractorData,
				'coins' => $coinsData,
			];
			$deal->deal_date = $this->request->post('deal-date');
			$deal->deal_type = $this->request->post('deal-type');
			$deal->legal_entity_id = $this->request->post('deal-legal-entity-id');
			if (!$dealId) {
				$deal->created_by = Auth::id();
			}
			$deal->updated_by = Auth::id();
			$deal->save();
			
			\DB::commit();
		} catch (Throwable $e) {
			\DB::rollback();
			
			Log::debug('500 - Deal Save: ' . $e->getMessage());
			
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
			abort(404);
		}
  
		$deal = Deal::find($id);
		if (!$deal) {
			return response()->json(['status' => 'error', 'reason' => 'Сделка не найдена']);
		}
		
		if (!$deal->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'deal_id' => $id]);
	}
	
	public function printSpecification($id) {
		$deal = $id ? Deal::findOrFail($id) : [];
		
		return view('deal.specification', [
			'deal' => $deal,
		]);
	}
	
	/*public function deleteFile($id, $name, $ext) {
		$deal = Deal::find($id);
		if (!$deal) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		if (is_array($deal->data_json) && !array_key_exists('files', $deal->data_json)) {
			return response()->json(['status' => 'error', 'reason' => 'Некорректные параметры']);
		}
		
		$files = $deal->data_json['files'];
		
		$fileItem = array_filter($files, function($item) use ($name, $ext) {
			return isset($item['name']) && $item['name'] == $name && isset($item['ext']) && $item['ext'] == $ext;
		});
		$file = current($fileItem);
		
		if (!$file || !Storage::disk('private')->exists('file/' . $file['name'] . '.' . $file['ext'])) {
			return response()->json(['status' => 'error', 'reason' => 'Некорректные параметры']);
		}
		
		if (Storage::disk('private')->delete('file/' . $file['name'] . '.' . $file['ext'])) {
			$data = $deal->data_json;
			$data['files'] = Arr::except($data['files'], [key($fileItem)]);
			$deal->data_json = $data;
			if ($deal->save()) {
				return response()->json(['status' => 'success', 'deal_id' => $deal->id]);
			}
		}
		
		return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
	}*/
	
	/**
	 * @param $ext
	 * @param $name
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	/*public function getFile($ext, $name) {
		if (!Storage::disk('private')->exists( 'file/' . $name . '.' . $ext)) {
			return abort(404);
		}
		
		return response()->download(storage_path('app/private/file/' . $name . '.' . $ext), null, [
			'Cache-Control' => 'no-cache, no-store, must-revalidate',
			'Pragma' => 'no-cache',
			'Expires' => '0',
		], null);
	}*/
}
