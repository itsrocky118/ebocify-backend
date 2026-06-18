<?php

namespace App\Services;

use App\Models\User;
use App\Models\ComplianceCertificate;
use Illuminate\Support\Collection;

class ComplianceService
{
    /**
     * Get all expiring certificates for user
     */
    public function getExpiringCertificates(User $user): Collection
    {
        return $user->complianceCertificates()
            ->where('status', '!=', 'expired')
            ->get()
            ->filter(fn(ComplianceCertificate $cert) => $cert->isExpiringsoon());
    }

    /**
     * Get all expired certificates for user
     */
    public function getExpiredCertificates(User $user): Collection
    {
        return $user->complianceCertificates()
            ->get()
            ->filter(fn(ComplianceCertificate $cert) => $cert->isExpired());
    }

    /**
     * Update certificate status
     */
    public function updateCertificateStatus(ComplianceCertificate $certificate): ComplianceCertificate
    {
        if ($certificate->isExpired()) {
            $certificate->update(['status' => 'expired']);
        } elseif ($certificate->isExpiringsoon()) {
            $certificate->update(['status' => 'expiring_soon']);
        } else {
            $certificate->update(['status' => 'active']);
        }

        return $certificate;
    }

    /**
     * Renew a certificate
     */
    public function renewCertificate(ComplianceCertificate $certificate, $newExpiryDate): ComplianceCertificate
    {
        $certificate->update([
            'expiry_date' => $newExpiryDate,
            'status' => 'active',
            'last_renewed_at' => now()->toDateString(),
        ]);

        return $certificate;
    }

    /**
     * Snooze expiry reminder
     */
    public function snoozeReminder(ComplianceCertificate $certificate, int $days = 7): ComplianceCertificate
    {
        $certificate->update([
            'reminder_days_before' => $days,
        ]);

        return $certificate;
    }
}
