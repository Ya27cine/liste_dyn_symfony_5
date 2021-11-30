<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\EventSubscriber\FormSelectCountrySubscriber;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="aap_home")
     */
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder(['availableAt'=> new \DateTime('+5 days')])
         ->add('name', TextType::class, [
             'constraints' => [
                 new Length(['min'=>5]),
                 new NotBlank(['message'=>'Please enter your name.'])
             ]
              
         ])->addEventSubscriber(new FormSelectCountrySubscriber())

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

         ->add('availableAt', DateTimeType::class,[
             'widget'=> 'single_text'
         ])

         ->add('show', RadioType::class,[
        ])

        
         ->getForm()
        ;



        $form->handleRequest($request);

        if( $form->isSubmitted() &&  $form->isValid()){
            //dd( $form->get('name')->getData());
        }



        return $this->renderForm('home.html.twig', compact('form'));
    }


     /**
     * @Route("/updateselect/{id}", name="update_select")
     */
    public function getDataSelect(Country $country, NormalizerInterface $normalizerInterface): Response
    {
       // $data =   $normalizerInterface->normalize($country->getCities(), null, ['groups' => 'selector:city'])  ;
   
        return $this->json( 
            ['data' => $country->getCities()],
            200,[],
            ['groups' => 'selector:city']
        );
    }
}
