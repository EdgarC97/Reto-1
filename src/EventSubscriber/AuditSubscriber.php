<?php

namespace App\EventSubscriber;

use App\Entity\Audit;
use App\Entity\Employee;
use App\Entity\Project;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;


class AuditSubscriber
{
    private Security $security;
    private EntityManagerInterface $entityManager;
    private array $auditsToInsert = [];
    private bool $isFlushingAudits = false;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->queueAudit('CREATE', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->queueAudit('UPDATE', $args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->queueAudit('DELETE', $args);
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        if (empty($this->auditsToInsert) || $this->isFlushingAudits) {
            return;
        }

        $this->isFlushingAudits = true;
        foreach ($this->auditsToInsert as $audit) {
            $this->entityManager->persist($audit);
        }
        $this->auditsToInsert = []; // Reseteamos la cola
        $this->entityManager->flush();
        $this->isFlushingAudits = false;
    }

    private function queueAudit(string $actionType, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Employee && !$entity instanceof Project) {
            return;
        }

        if ($this->isFlushingAudits) {
            return;
        }

        $user = $this->security->getUser();
        if (!$user) {
            return;
        }

        $audit = new Audit();
        $audit->setUsername($user->getUserIdentifier());
        $audit->setAffectedEntity((new \ReflectionClass($entity))->getShortName());
        $audit->setActionType($actionType);
        $audit->setTimestamp(new \DateTimeImmutable());
        $audit->setEntityId((string) $entity->getId());

        $this->auditsToInsert[] = $audit;
    }
}