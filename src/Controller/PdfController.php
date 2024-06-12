<?php

namespace App\Controller;

use App\Repository\PdfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(PdfRepository $pdfRepository): Response
    {
        $pdfs = $pdfRepository->findBy(['owner' => $this->getUser()]);

        return $this->render('pdf/index.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }
}
