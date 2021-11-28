<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="aap_home")
     */
    public function index(): Response
    {
        $form = $this->createFormBuilder()
         ->add('name', TextType::class)

         ->add('country', EntityType::class, [
             'class'=> Country::class,
             'placeholder' => "Please choose a country ",
             'choice_label' => 'name',
             'query_builder' => function(CountryRepository $countryRepository){
                 return $countryRepository->createQueryBuilder('x')->orderBy('x.name', 'DESC');
             }
        ])

         ->add('city', EntityType::class, [
             'class'=> City::class,
             'placeholder' => "Please choose a city ",
             'choice_label' => 'name',
             'disabled' => true,
             'query_builder' => function(CityRepository $cityRepository){
                return $cityRepository->createQueryBuilder('y')->orderBy('y.name', 'DESC');
            }
        ])

         ->add('message', TextareaType::class)
         ->getForm()
        ;

        return $this->renderForm('home.html.twig', compact('form'));
    }
}
