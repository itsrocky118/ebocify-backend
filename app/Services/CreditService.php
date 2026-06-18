<?php

namespace App\Services;

use App\Models\User;
use App\Models\CreditTransaction;

class CreditService
{
    /**
     * Get current balance for user
     */
    public function getBalance(User $user): int
    {
        return (int) $user->creditTransactions()->sum('amount');
    }

    /**
     * Add credits to user
     */
    public function addCredits(User $user, int $amount, string $reason, ?string $referenceType = null, ?int $referenceId = null): CreditTransaction
    {
        $balanceBefore = $this->getBalance($user);
        $balanceAfter = $balanceBefore + $amount;

        return CreditTransaction::create([
            'user_id' => $user->id,
            'type' => 'bonus',
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'description' => $reason,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Deduct credits from user
     */
    public function deductCredits(User $user, int $amount, string $reason, ?string $referenceType = null, ?int $referenceId = null): ?CreditTransaction
    {
        $currentBalance = $this->getBalance($user);

        if ($currentBalance < $amount) {
            return null; // Insufficient credits
        }

        $balanceAfter = $currentBalance - $amount;

        return CreditTransaction::create([
            'user_id' => $user->id,
            'type' => 'usage',
            'amount' => -$amount,
            'balance_before' => $currentBalance,
            'balance_after' => $balanceAfter,
            'description' => $reason,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Check if user has enough credits
     */
    public function hasEnoughCredits(User $user, int $requiredAmount): bool
    {
        return $this->getBalance($user) >= $requiredAmount;
    }

    /**
     * Get credit transactions history
     */
    public function getTransactionHistory(User $user, int $limit = 50)
    {
        return $user->creditTransactions()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
