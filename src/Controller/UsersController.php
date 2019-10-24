<?php

namespace App\Controller;
// use global
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
// use Entity
use App\Entity\Users;
// use Form
use App\Form\UsersFormType;
// use Service
use App\Services\DoctrineServices;
use App\Services\FormsServices;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(DoctrineServices $ds)
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'users'=>$ds->getUsers()
        ]);
    }
    /**
     * @Route("/users/{id}", name="user_id")
    */
    public function user($id,DoctrineServices $ds){
        return $this->render('users/user.html.twig', [
            'controller_name' => 'UsersController',
            'user'=>$ds->getUser($id)
        ]);
    }
    /**
     * @Route("/create/user/{id}", name="user_create")
    */
    public function create($id, Request $request,FormsServices $fs){
        if($id === -1){
            $user = new Users();
            $form = $this->createForm(UsersFormType::class, $user);
            $form->handleRequest($request);
        }
        else{
            $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
            $form = $this->createForm(UsersFormType::class, $user);
            $form->handleRequest($request);
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $fs->sendForm($task);
            return $this->redirectToRoute('users');
        }
        return $this->render('users/create.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("/delete/users/{id}", name="user_delete") 
    */
    public function delete($id, DoctrineServices $ds){
        $ds->removeUser($id);
        return $this->redirectToRoute('users');
    }
}
