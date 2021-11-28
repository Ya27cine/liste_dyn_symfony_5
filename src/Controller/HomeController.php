<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="aap_home")
     */
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
         ->add('name', TextType::class, [
             'constraints' => [
                 new Length(['min'=>5]),
                 new NotBlank(['message'=>'Please enter your name.'])
             ]
              
         ])

         ->add('country', EntityType::class, [
             'class'=> Country::class,
             'placeholder' => "Please choose a country ",
             'choice_label' => 'name',
             'query_builder' => function(CountryRepository $countryRepository){
                 return $countryRepository->createQueryBuilder('x')->orderBy('x.name', 'DESC');
             },
             'constraints' => [
                new NotBlank(['message'=>'Please choose a country'])
            ]
        ])

         ->add('city', EntityType::class, [
             'class'=> City::class,
             'placeholder' => "Please choose a city ",
             'choice_label' => 'name',
             'disabled' => true,
             'query_builder' => function(CityRepository $cityRepository){
                return $cityRepository->createQueryBuilder('y')->orderBy('y.name', 'DESC');
            },
            'constraints' => [
                new NotBlank(['message'=>'Please choose a city'])
            ]
        ])

         ->add('message', TextareaType::class,[
            'constraints' => [
                new Length(['min'=>10]),
                new NotBlank()
            ]
         ])

         ->add('availableAt', DateTimeType::class)
         ->getForm()
        ;


        $form->handleRequest($request);

        if( $form->isSubmitted() &&  $form->isValid()){
            dd('valide');
        }



        return $this->renderForm('home.html.twig', compact('form'));
    }
}
