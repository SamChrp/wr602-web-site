<?php

namespace App\Controller;

use App\Form\GeneratePdfType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate/pdf', name: 'app_generate_pdf')]
    public function generatePdf
    (
        Request             $request,
        HttpClientInterface $client,
        ParameterBagInterface $params
    ): Response
    {
        $form = $this->createForm(GeneratePdfType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->get('url')->getData();

            $hostMicroService = $params->get('PDF_URL');

            $response = $client->request('POST', $hostMicroService .'/url/converter', [
                'body' => [
                    'url' => $url
                ],
            ]);
            return new Response($response->getContent(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="file.pdf"',
            ]);
        }

        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
