<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;


class TestDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function supports($data): bool
    {
        return $data instanceof Test;
    }

    /**
    * @param User $data
    */
    public function persist($data)
    {
        $data->setName('datatest');
        $data->setPseudo('PseudoTestForData');
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}