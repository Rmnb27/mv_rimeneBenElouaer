<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VinylMixRepository;

class MixController extends AbstractController
{
    #[Route('/mix/new')]


    public function new(EntityManagerInterface $entityManager): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Do you Remember... Phil Collins?!');
        $genres = ['pop', 'rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        
        $mix->setDescription('A pure mix of drummers turned singers!');
        $mix->setGenre('pop');
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));
        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            'mix: %d id: %d tracks of pure 80\'s heaven ', 
            $mix->getId(), 
            $mix->getTrackCount() 

        )); 
    }
    #[Route('/mix/{id}', name: 'app_mix_show')]
    public function show($id, VinylMixRepository $mixRepository): Response
    {
        $mix = $mixRepository->find($id);
        //dd($mix);
        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }
}
