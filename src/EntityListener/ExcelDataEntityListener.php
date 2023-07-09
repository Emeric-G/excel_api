<?php

namespace App\EntityListener;

use App\Entity\ExcelData;
use Doctrine\ORM\Events;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(event: Events::prePersist, entity: ExcelData::class)]
class ExcelDataEntityListener
{
    public function __construct(private Security $security)
    {
        
    }

    public function prePersist(ExcelData $excelData, LifecycleEventArgs $event): void
    {
        $excelData->setUser($this->security->getUser());
    }
    
}