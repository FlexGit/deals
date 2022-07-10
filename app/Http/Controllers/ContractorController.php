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
		$this->limit = 10;
	}
	
	/**
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit($id = null) {
		$contractor = $id ? Contractor::findOrFail($id) : [];
		
		return view('contractor.edit')
			->with('contractor', $contractor);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function getContractors() {
		return view('contractor.index');
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList() {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$contractorName = $this->request->get('contractor') ?: '';
		
		if ($contractorName) {
			$contractors = Contractor::where('name', $contractorName)
				->orderBy('name', 'asc')
				->paginate($this->limit);
		} else {
			$contractors = Contractor::orderBy('name', 'asc')
				->paginate($this->limit);
		}
		
		$VIEW = view('contractor.list', ['contractors' => $contractors]);
		
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
			/*$data_json = $contractor->data_json;
			$data_json['passport_date'] = \Carbon\Carbon::createFromTimestamp($contractor->data_json['passport_date'])->format('Y-m-d');*/
			
			\Log::debug($contractor->passports->toArray());
			
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
	 * @param $ext
	 * @param $name
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function getPassport($ext, $name) {
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
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$rules = [
			'contractor-name' => 'required|max:255',
			'passport-series' => 'required|max:255',
			'passport-number' => 'required|max:255',
			'passport-date' => 'required|date|after:01.01.1900',
			'passport-office' => 'required|max:255',
			'passport-zipcode' => 'required|numeric',
			'passport-region' => 'required|max:255',
			'passport-city' => 'required|max:255',
			'passport-street' => 'required|max:255',
			'passport-house' => 'required|max:255',
			'passport-apartment' => 'required|max:255',
			'passport-file-1' => 'required_without:contractor-id|image|max:10240',
			'passport-file-2' => 'required_without:contractor-id|image|max:10240',
		];
		$validator = Validator::make($this->request->all(), $rules);
		if (!$validator->passes()) {
			return response()->json(['status' => 'error', 'reason' => implode('<br>', $validator->errors()->all())]);
		}
		
		$contractorId = $this->request->post('contractor-id') ?: '';
		
		if ($contractorId) {
			$contractor = Contractor::find($contractorId);
			if (!$contractor) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
			}
		} else {
			$contractor = new Contractor();
			$contractor->created_by = Auth::id();
		}
		
		$contractorData = [];
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
		if ($this->request->post('passport-zipcode')) {
			$contractorData['passport_zipcode'] = $this->request->post('passport-zipcode');
		}
		if ($this->request->post('passport-region')) {
			$contractorData['passport_region'] = $this->request->post('passport-region');
		}
		if ($this->request->post('passport-city')) {
			$contractorData['passport_city'] = $this->request->post('passport-city');
		}
		if ($this->request->post('passport-street')) {
			$contractorData['passport_street'] = $this->request->post('passport-street');
		}
		if ($this->request->post('passport-house')) {
			$contractorData['passport_house'] = $this->request->post('passport-house');
		}
		if ($this->request->post('passport-apartment')) {
			$contractorData['passport_apartment'] = $this->request->post('passport-apartment');
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
		} else {
			$contractorData['passport_file_1'] = isset($contractor->data_json['passport_file_1']) ? $contractor->data_json['passport_file_1'] : '';
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
		} else {
			$contractorData['passport_file_2'] = isset($contractor->data_json['passport_file_2']) ? $contractor->data_json['passport_file_2'] : '';
		}
		
		$contractor->name = $this->request->post('contractor-name');
		$contractor->data_json = $contractorData;
		$contractor->updated_by = Auth::id();
		if (!$contractor->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'contractor_id' => $contractor->id]);
	}
	
	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id) {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$contractor = Contractor::find($id);
		if (!$contractor) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, контрагент не найден']);
		}
		
		if (!$contractor->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'contractor_id' => $id]);
	}
	
	/**
	 * @param $contractorId
	 * @param $passportId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPassportVersion($contractorId, $passportId) {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
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
