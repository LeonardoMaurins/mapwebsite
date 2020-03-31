<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index() {

        $users = $this->getDoctrine()->getRepository
        (User::class)->findAll();

        return $this->render('/login/selectuser.html.twig', array('users' => $users));
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signup() {
        return $this->render('/signup/signup.html.twig');
    }

    /**
     * @Route("/signup", name="create_user")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('password', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('signup');
        }

        return $this->render('signup/signup.html.twig', array(
            'form' => $form->createView()
        ));
    }

//    /**
//     * @Route("/register", name="register")
//     */
//    public function register() {
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $user = new User();
//
//        $user = $this->getDoctrine()->getRepository
//        (User::class)->findAll();
//
//        $user->setUsername('B00107064');
//        $user->setEmail('B00107064@mytudublin.ie');
//        $user->setPassword('pass');
//
//        $entityManager->persist($user);
//
//        $entityManager->flush();
//    }

    /**
     * @Route("/login", name="selection", methods={"GET","POST"})
     */
    public function selection(){
        return $this->render('/login/login.html.twig');
    }

    /**
     * @Route("/loginsuccessful")
     */
    public function login($username, $password) {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername('B00107064');
        $user->setPassword('pass');

        $entityManager->persist($user);

        $entityManager->flush();
    }

//    /**
//     * @Route("/login", name="selection", methods={"GET","POST"})
//     */
//    public function

//    private $twig;
//
//    public function __construct(\Twig\Environment $twig)
//    {
//        $this->twig = $twig;
//    }
//
//    public function index()
//    {
//        $template = 'login.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Select User'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function home()
//    {
//        $template = 'home.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Home'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function login()
//    {
//        $template = 'selectuser.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Login'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function passwordrecovery()
//    {
//        $template = 'passwordrecovery.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Password Recovery'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function map()
//    {
//        $template = 'map.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Map'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function bustimetable()
//    {
//        $template = 'bustimetable.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Bus timetable'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function staffdirectory()
//    {
//        $template = 'staffdirectory.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Staff Directory'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
//    public function underconstruction()
//    {
//        $template = 'underconstruction.html.twig';
//        $argsArray = [
//            'pageTitle' => 'Under Construction'
//        ];
//        $html =  $this->twig->render($template, $argsArray);
//        print $html;
//    }
//
    public function loginerror($errors)
    {
        $template = 'loginerror.html.twig';
        $argsArray = [
            'pageTitle' => 'Login Error',
            ["errors" => $errors]
        ];
        $html =  $this->twig->render($template, $argsArray, ["errors" => $errors]);
        print $html;

    }

    public function processLogin()
    {
        // (1) extract data from received HTTP Request
        $username = filter_input(INPUT_GET, 'username');
        $password = filter_input(INPUT_GET, 'password');

        // (2) validate and build-up 'errors' array
        $errors = $this->validateLogin($username, $password);

        // (3) display errors or form confirmation depending on whether errors array is empty
        if(sizeof($errors)>0){
//            require_once '../templates/loginerror.html.twig';
            $this->loginerror($errors);
        } else {
            $this->home();
        }
    }
//
//    private function validateLogin($studentID, $password)
//    {
//        $errors = [];
//        if (empty($studentID)) {
//            $errors[] = 'Missing Student ID';
//        }
//
//        if (empty($password)) {
//            $errors[] = 'Missing password';
//        }
//
//        return $errors;
//    }
}