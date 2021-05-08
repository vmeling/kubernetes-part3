<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $user
     *
     * @throws ORMException
     */
    public function createUser(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->flush();
    }

    /**
     * @throws ORMException
     */
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $id
     *
     * @throws EntityNotFoundException
     * @throws ORMException
     */
    public function deleteUser(string $id): void
    {
        $user = $this->find($id);
        if ($user === null) {
            throw new EntityNotFoundException('User not found');
        }
        $this->getEntityManager()->remove($user);
        $this->flush();
    }
}
