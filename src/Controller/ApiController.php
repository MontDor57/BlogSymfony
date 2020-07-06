<?php

namespace App\Controller;

use App\Entity\Test;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/apip", name="api_post", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $jsonRecu = $request->getContent();

        $decode = json_decode($jsonRecu, true);

        $count = count($decode);
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $batchSize = 20;
        for ($i = 1; $i <= $count; ++$i) {
            $test = $serializer->deserialize(json_encode($decode[$i]), Test::class, 'json');
            $em->persist($test);
            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear();
            }
        }
        $em->flush();
        $em->clear();

        dd($count);
    }
}
