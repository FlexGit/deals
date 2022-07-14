<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Contractor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ContractorController extends Controller {
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
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit($id = null) {
		$contractor = $id ? Contractor::findOrFail($id) : null;
		
		return view('contractor.edit', [
			'contractor' => $contractor
		]);
	}
	
	/**
	 * @param $id
	 * @param $passportId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
	 */
	public function editPassport($id, $passportId = null) {
		$contractor = Contractor::find($id);
		if (!$contractor) {
			abort(404);
		}
		
		if ($passportId) {
			$passport = Passport::where('contractor_id', $id)
				->find($passportId);
			if (!$passport) {
				abort(404);
			}
		}
		
		return view('contractor.passport_edit', [
			'contractor' => $contractor,
			'passport' => $passportId ? $passport : null,
		]);
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function getContractors() {
		$filterContractor = $this->request->session()->get('contractor-filter-contractor');

		return view('contractor.index', [
			'filterContractor' => $filterContractor,
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
		
		if ($this->request->exists('filter-contractor')) {
			$this->request->session()->put('contractor-filter-contractor', $filterContractor);
		}
		
		$filterContractor = $this->request->session()->get('contractor-filter-contractor');
		
		$contractors = Contractor::orderBy('id', 'desc');
		if ($filterContractor) {
			$contractors = $contractors->where('name', 'like', '%' . $filterContractor . '%');
		}
		if ($id) {
			$contractors = $contractors->where('id', '<', $id);
		}
		$contractors = $contractors->limit(Contractor::LIST_LIMIT)->get();
		
		$VIEW = view('contractor.list', [
			'contractors' => $contractors,
		]);
		
		return response()->json(['status' => 'success', 'html' => (string)$VIEW]);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function search() {
		$query = $this->request->post('query');
	
		$contractors = Contractor::where("name", "LIKE", "%{$query}%")
			->orderBy("name")
			->get();
	
		$suggestions = [];
		foreach ($contractors as $contractor) {
			$passports = $contractor->passports;
			$lastPassport = $contractor->passports->first();
			
			$suggestions[] = [
				'value' => $contractor->name,
				'id' => $contractor->id,
				'data' => [
					'lastPassport' => $lastPassport,
					'passports' => $passports,
				],
			];
		}
		
		return response()->json(['suggestions' => $suggestions]);
	}
	
	/**
	 * @param $id
	 * @param $ext
	 * @param $name
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function getPassportFile($id, $ext, $name) {
		$contractor = Contractor::find($id);
		if (!$contractor) {
			return abort(404);
		}

		if (!Storage::disk('private')->exists( 'passport/' . $name . '.' . $ext)) {
			return abort(404);
		}

		return response()->download(storage_path('app/private/passport/' . $name . '.' . $ext), null, [
			'Cache-Control' => 'no-cache, no-store, must-revalidate',
			'Pragma' => 'no-cache',
			'Expires' => '0',
		], null);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function save() {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$rules = [
			'contractor-name' => 'required|max:255',
		];
		$validator = Validator::make($this->request->all(), $rules);
		if (!$validator->passes()) {
			return response()->json(['status' => 'error', 'reason' => implode('<br>', $validator->errors()->all())]);
		}
		
		$contractorId = $this->request->post('contractor-id') ?? 0;
		
		if ($contractorId) {
			$contractor = Contractor::find($contractorId);
			if (!$contractor) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
			}
		} else {
			$contractor = new Contractor();
			$contractor->created_by = Auth::id();
		}
		$contractor->name = $this->request->post('contractor-name');
		$contractor->updated_by = Auth::id();
		if (!$contractor->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'name' => $contractor->name]);
	}
	
	/**
	 * @param $contractorId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function savePassport($contractorId) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$contractor = Contractor::find($contractorId);
		if (!$contractor) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
		}
		
		$rules = [
			'passport-series' => 'required|max:25',
			'passport-number' => 'required|max:25',
			'passport-date' => 'required|date|after:01.01.1900',
			'passport-office' => 'required|max:255',
			'passport-zipcode' => 'required|max:25',
			'passport-region' => 'required|max:255',
			'passport-city' => 'required|max:255',
			'passport-street' => 'required|max:255',
			'passport-house' => 'required|max:255',
			'passport-file-1' => 'required_without:contractor-id|image|max:10240',
			'passport-file-2' => 'required_without:contractor-id|image|max:10240',
		];
		$validator = Validator::make($this->request->all(), $rules);
		if (!$validator->passes()) {
			return response()->json(['status' => 'error', 'reason' => implode('<br>', $validator->errors()->all())]);
		}
		
		$passportId = $this->request->post('passport-id') ?? 0;
		
		if ($passportId) {
			$passport = Passport::find($passportId);
			if (!$passport) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, версия паспорта не найдена']);
			}
		} else {
			$passport = new Passport();
			$passport->contractor_id = $contractorId;
			$passport->created_by = Auth::id();
		}
		
		$passportData = [];
		$passport->series = $this->request->post('passport-series') ?? null;
		$passport->number = $this->request->post('passport-number') ?? null;
		$passport->issue_date = $this->request->post('passport-date') ?? null;
		$passport->issue_office = $this->request->post('passport-office') ?? null;
		$passport->zipcode = $this->request->post('passport-zipcode') ?? null;
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
		} else {
			$passportData['passport_file_1'] = isset($passport->data_json['passport_file_1']) ? $passport->data_json['passport_file_1'] : '';
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
		} else {
			$passportData['passport_file_2'] = isset($passport->data_json['passport_file_2']) ? $passport->data_json['passport_file_2'] : '';
		}
		$passport->data_json = $passportData;
		$passport->updated_by = Auth::id();
		if (!$passport->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'series' => $passport->series, 'number' => $passport->number]);
	}
	
	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$contractor = Contractor::find($id);
		if (!$contractor) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
		}
		
		if ($contractor->deals->count()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, удаление невозможно. К контрагенту привязаны сделки']);
		}
		
		$contractorName = $contractor->name;
		
		if (!$contractor->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'name' => $contractorName]);
	}
	
	/**
	 * @param $contractorId
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deletePassport($contractorId, $id) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$contractor = Contractor::find($contractorId);
		if (!$contractor) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
		}
		
		$passport = Passport::find($id);
		if (!$passport) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, версия паспорта не найдена']);
		}
		
		if ($passport->deals->count()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, удаление невозможно. К версии паспорта привязаны сделки']);
		}
		
		$passportSeries = $passport->series;
		$passportNumber = $passport->number;
		$passportData = $passport->data_json;
		
		if (!$passport->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		if (isset($passportData['passport_file_1'])) {
			Storage::disk('private')->delete('passport/' . $passportData['passport_file_1']['name'] . '.' . $passportData['passport_file_1']['ext']);
		}
		if (isset($passportData['passport_file_2'])) {
			Storage::disk('private')->delete('passport/' . $passportData['passport_file_2']['name'] . '.' . $passportData['passport_file_2']['ext']);
		}
		
		return response()->json(['status' => 'success', 'series' => $passportSeries, 'number' => $passportNumber]);
	}

	/**
	 * @param $contractorId
	 * @param $passportId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPassport($contractorId, $passportId) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$contractor = Contractor::find($contractorId);
		if (!$contractor) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
		}
		
		$passport = Passport::where('contractor_id', $contractorId)
			->find($passportId);
		if (!$passport) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, версия паспорта не найдена']);
		}
		
		return response()->json(['status' => 'success', 'passport' => $passport]);
	}
}
