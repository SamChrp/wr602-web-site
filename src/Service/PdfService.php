<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\PdfRepository;

class PdfService
{
    public function __construct(
        private PdfRepository $pdfRepository
    )
    {
    }

    public function countPdfGeneratedToday(): int
    {
        $todayDate = new \DateTime('today');
        $tomorrowDate = new \DateTime('tomorrow');

        return count($this->pdfRepository->findTodaysPdf($todayDate, $tomorrowDate));
    }

    public function canGeneratePdfToday($user): bool
    {
        $subscription = $user->getSubscription();

        if ($this->countPdfGeneratedToday() < $subscription->getPfdLimit()) {
            return true;
        } elseif ($subscription->getPfdLimit() == -1) {
            return true;
        } else {
            return false;
        }

    }
}