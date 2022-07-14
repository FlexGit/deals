<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coin;
use Illuminate\Support\Facades\Validator;

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
	}
	
	/**
	 * @param null $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit($id = null) {
		$coin = $id ? Coin::findOrFail($id) : null;
		
		return view('coin.edit', [
			'coin' => $coin
		]);
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function getCoins() {
		$filterCoin = $this->request->session()->get('coin-filter-coin');

		return view('coin.index', [
			'filterCoin' => $filterCoin,
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
		$filterCoin = $this->request->get('filter-coin') ?? '';
		
		if ($this->request->exists('filter-coin')) {
			$this->request->session()->put('coin-filter-coin', $filterCoin);
		}
		
		$filterCoin = $this->request->session()->get('coin-filter-coin');
		
		$coins = Coin::orderBy('id', 'desc');
		if ($filterCoin) {
			$coins = $coins->where('name', 'like', '%' . $filterCoin . '%');
		}
		if ($id) {
			$coins = $coins->where('id', '<', $id);
		}
		$coins = $coins->limit(Coin::LIST_LIMIT)->get();
		
		$VIEW = view('coin.list', [
			'coins' => $coins,
		]);
		
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
			abort(404);
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
				return response()->json(['status' => 'error', 'reason' => 'Ошибка, монета не найдена']);
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
			'metalWeight' => $this->request->post('coin-metal-weight') ?: null,
			'denomination' => $this->request->post('coin-denomination') ?: null,
			'fineness' => $this->request->post('coin-fineness') ?: null,
			'coinage' => $this->request->post('coin-coinage') ?: null,
		];
		$coin->updated_by = Auth::id();
		if (!$coin->save()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'coin_name' => $coin->name]);
	}
	
	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		
		$coin = Coin::find($id);
		if (!$coin) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, монета не найдена']);
		}
		
		$coinName = $coin->name;
		
		if (!$coin->delete()) {
			return response()->json(['status' => 'error', 'reason' => 'Ошибка, попробуйте повторить операцию позже']);
		}
		
		return response()->json(['status' => 'success', 'coin_name' => $coinName]);
	}
	
}
