<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\GeneratePdfType;
use App\Repository\PdfRepository;
use App\Service\PdfService;
use App\Service\UrlToPdfMicroService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate/pdf', name: 'app_generate_pdf')]
    public function generatePdf
    (
        Request               $request,
        UrlToPdfMicroService  $urlToPdfMicroService,
        EntityManagerInterface $entityManager,
        PdfService            $pdfService
    ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour générer un PDF.');
            return $this->redirectToRoute('app_login');
        }

        $canGeneratePdf = $pdfService->canGeneratePdfToday($user);
        $form = $this->createForm(GeneratePdfType::class);

        if ($canGeneratePdf === true) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $pdf = new Pdf();
                $url = $form->get('url')->getData();
                $content = $urlToPdfMicroService->convertUrlToPdf($url);

                $fileName = 'pdf_' . uniqid() . '.pdf';
                $filePath =   'pdf/' . $fileName;
                file_put_contents($filePath, $content);

                $pdf->setTitle($fileName);
                $pdf->setOwner($user);
                $pdf->setCreatedAt(new \DateTimeImmutable());

                $entityManager->persist($pdf);
                $entityManager->flush();

                $this->addFlash('success', 'Le PDF a été généré avec succès. Vous pouveez maintenant le retrouver dans la rebruique "Historique".');

                 return new Response($urlToPdfMicroService->convertUrlToPdf($url), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="file.pdf"',
                ]);
            }
        }


        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
            'canGeneratePdf' => $canGeneratePdf,
        ]);
    }
}
