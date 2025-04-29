<?php

namespace App\Controller;

use App\Repository\AuditRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audit')]
class AuditController extends AbstractController
{
    #[Route('/', name: 'app_audit_index')]
    public function index(AuditRepository $auditRepository): Response
    {
        $audits = $auditRepository->findBy([], ['timestamp' => 'DESC']);

        return $this->render('audit/index.html.twig', [
            'audits' => $audits,
        ]);
    }
}
