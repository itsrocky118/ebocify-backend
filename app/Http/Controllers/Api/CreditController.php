<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CreditService;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    private CreditService $creditService;

    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
    }

    /**
     * Get user's credit balance
     */
    public function balance(Request $request)
    {
        $balance = $this->creditService->getBalance($request->user());

        return response()->json([
            'balance' => $balance,
        ]);
    }

    /**
     * Get credit transaction history
     */
    public function history(Request $request)
    {
        $transactions = $this->creditService->getTransactionHistory($request->user());

        return response()->json($transactions);
    }
}
