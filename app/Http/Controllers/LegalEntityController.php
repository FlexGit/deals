<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\LegalEntity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LegalEntityController extends Controller {
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
		$legalEntity = $id ? LegalEntity::findOrFail($id) : [];
		
		return view('legal-entity.edit', [
			'legalEntity' => $legalEntity
		]);
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function getLegalEntities() {
		return view('legal-entity.index');
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList() {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$legalEntities = LegalEntity::orderBy('name')
			->paginate($this->limit);
		
		$VIEW = view('legal-entity.list', [
			'legalEntities' => $legalEntities
		]);
		
		return response()->json(['status' => 'success', 'html' => (string)$VIEW]);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function save() {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$rules = [
			'name' => 'required|max:255',
			'inn' => 'required|max:50',
			'kpp' => 'required|max:50',
			'ogrn' => 'required|max:50',
			'bank' => 'required|max:255',
			'rs' => 'required|max:50',
			'ks' => 'required|max:50',
			'bik' => 'required|max:50',
			'address' => 'required|max:255',
		];
		$validator = Validator::make($this->request->all(), $rules);
		if (!$validator->passes()) {
			return response()->json(['status' => 'error', 'reason' => implode('<br>', $validator->errors()->all())]);
		}
		
		$legalEntityId = $this->request->post('id') ?: '';

		if ($legalEntityId) {
			$legalEntity = LegalEntity::find($legalEntityId);
			if (!$legalEntity) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, юридическое лицо не найдено']);
			}
		}
		else {
			$legalEntity = new LegalEntity();
			$legalEntity->created_by = Auth::id();
		}
		$legalEntity->name = $this->request->post('name') ?? null;
		$legalEntity->inn = $this->request->post('inn') ?? null;
		$legalEntity->kpp = $this->request->post('kpp') ?? null;
		$legalEntity->ogrn = $this->request->post('ogrn') ?? null;
		$legalEntity->bank = $this->request->post('bank') ?? null;
		$legalEntity->rs = $this->request->post('rs') ?? null;
		$legalEntity->ks = $this->request->post('ks') ?? null;
		$legalEntity->bik = $this->request->post('bik') ?? null;
		$legalEntity->address = $this->request->post('address') ?? null;
		$legalEntity->updated_by = Auth::id();
		if (!$legalEntity->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'legal_entity_name' => $legalEntity->name]);
	}
	
	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$legalEntity = LegalEntity::find($id);
		if (!$legalEntity) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, юридическое лицо не найдено']);
		}
		
		$legalEntityName = $legalEntity->name;
		
		if (!$legalEntity->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'legal_entity_name' => $legalEntityName]);
	}
}
