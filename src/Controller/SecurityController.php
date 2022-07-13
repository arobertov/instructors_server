<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     * @param IriConverterInterface $iriConverter
     * @return Response
     * @throws Exception
     */
    public function login(IriConverterInterface $iriConverter):Response
    {
        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromItem($this->getUser())
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout(): void
    {
        throw new \RuntimeException('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}