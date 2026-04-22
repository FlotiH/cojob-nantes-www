<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberAreaController extends AbstractController
{
    /**
     * @Route("/adherent/airtable", name="airtable_data")
     */
    public function airtableDataAction(): Response
    {
        return $this->render('member/airtable_data.html.twig');
    }
}
