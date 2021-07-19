<?php
 namespace App\Controller\Admin;

 use App\Entity\User;
 use Cassandra\Type\UserType;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

 class AdminUserController extends AbstractController
 {
    public function insertUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setRoles(["ROLE_ADMIN"]);

            $plainPassword = $userForm->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('admin/admin_insert.html.twig', [
            'userForm' => $userForm->createView()
        ]);
    }
 }