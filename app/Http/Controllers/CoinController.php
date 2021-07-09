<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Coin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CoinController extends Controller {
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
		$coin = $id ? Coin::findOrFail($id) : [];
		
		return view('coin.edit')
			->with('coin', $coin);
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function getCoins() {
		return view('coin.index');
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList() {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$coinName = $this->request->get('coin') ?: '';
		
		if ($coinName) {
			$coins = Coin::where('name', $coinName)
				->orderBy('name', 'asc')
				->paginate($this->limit);
		} else {
			$coins = Coin::orderBy('name', 'asc')
				->paginate($this->limit);
		}
		
		$VIEW = view('coin.list', ['coins' => $coins]);
		
		return response()->json(['status' => 'success', 'html' => (string)$VIEW]);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function search() {
		$query = $this->request->post('query');
		
		$coins = Coin::where("name", "LIKE", "%{$query}%")
			->orderBy("name")
			->get();
		
		$suggestions = [];
		foreach ($coins as $coin) {
			$data_json = $coin->data_json;
			
			$suggestions[] = [
				'value' => $coin->name,
				'id' => $coin->id,
				'data' => $data_json,
			];
		}
		
		return response()->json(['suggestions' => $suggestions]);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function save() {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$rules = [
			'coin-name' => 'required|max:255',
			'coin-country' => 'nullable|max:255',
			'coin-year' => 'nullable|max:255',
			'coin-metal' => 'nullable|max:255',
			'coin-denomination' => 'nullable|max:255',
			'coin-fineness' => 'nullable|max:255',
			'coin-coinage' => 'nullable|max:255',
		];
		$validator = Validator::make($this->request->all(), $rules);
		if (!$validator->passes()) {
			return response()->json(['status' => 'error', 'reason' => implode('<br>', $validator->errors()->all())]);
		}
		
		$coinId = $this->request->post('coin-id') ?: '';

		if ($coinId) {
			$coin = Coin::find($coinId);
			if (!$coin) {
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
			}
		}
		else {
			$coin = new Coin();
			$coin->created_by = Auth::id();
		}
		$coin->name = $this->request->post('coin-name');
		$coin->data_json = [
			'country' => $this->request->post('coin-country') ?: null,
			'year' => $this->request->post('coin-year') ?: null,
			'metal' => $this->request->post('coin-metal') ?: null,
			'denomination' => $this->request->post('coin-denomination') ?: null,
			'fineness' => $this->request->post('coin-fineness') ?: null,
			'coinage' => $this->request->post('coin-coinage') ?: null,
		];
		$coin->updated_by = Auth::id();
		if (!$coin->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'coin_id' => $coin->id]);
	}
	
	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id) {
		if (!$this->request->ajax()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		$coin = Coin::find($id);
		if (!$coin) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		if (!$coin->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'coin_id' => $id]);
	}
	
}
