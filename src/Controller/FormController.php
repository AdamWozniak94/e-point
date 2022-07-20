<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        $url = 'https://restcountries.com/v3.1/subregion/europe';
        $json = file_get_contents($url);
        $countriesData = json_decode($json);
        $countryNamesArray = [];
        foreach ($countriesData as $country) {
            $countryNamesArray[$country->cca2] = $country->name->common;
        }

        return $this->render('index.html.twig', [
            'countryNamesArray' => $countryNamesArray
        ]);
    }

    #[Route('/result')]
    public function result(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $country = $request->get('country');
        $url = 'https://api.genderize.io?name=' . $name . '&country_id=' . $country;
        $json = file_get_contents($url);
        $result = json_decode($json);

        return new JsonResponse($result->gender);
    }
}