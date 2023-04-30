<?php
namespace App\Service;

Use Doctrie\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
Use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
Use Symfony\Component\Security\Core\Security;
Use stdClass;

class AppHelpers{
    private $params;
    private $doctrine;
    private $security;

    public function __construct(ContainerBagInterface $params, PersistenceManagerRegistry $doctrine, Security $security)
    {
        $this->params = $params;
        $this->doctrine = $doctrine;
        $this->security = $security;
    }

    public function getProduit()
    {
      $produit = $this->security->getProduit();
    }

    public function getUser()
  {
    $user = $this->security->getUser();
    if ($user) {
      $isLoggedIn = true;
    } else {
      $isLoggedIn = false;
    }
    if ($this->security->isGranted('ROLE_ADMIN')) {
      $isAdmin = true;
    } else {
      $isAdmin = false;
    }
    $userObj = new StdClass();
    $userObj->user = $user;
    $userObj->isAdmin = $isAdmin;
    $userObj->isLoggedIn = $isLoggedIn;
    return $userObj;
  }
}