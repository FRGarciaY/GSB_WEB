<?php

namespace GSB\mainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use GSB\mainBundle\Entity\visiteur;


class LogController extends Controller
{
    public function loginAction(Request $request)
    {
        // Si l'authentification est valide, on retourne sur la page principale
        $session = $this->get('session');
        if($session->get('identificated', true)){
            return $this->redirectToRoute('gs_bmain_homepage');
        }
        // Création du formulaire
        $monVisiteur = new visiteur();
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $monVisiteur);
        $formbuilder
                ->add('loginVisiteur', TextType::class, array('required' => true, 'label' => 'Login'))
                ->add('pwdVisiteur', PasswordType::class, array('required' => true, 'label' => 'Password'))
                ->add('Valider', SubmitType::class, array('attr' => array('class' => 'bt btLogin')));
        $form = $formbuilder->getForm();
        
        // Test de variable de type $_POST
        if ($request->isMethod('POST')) {
        $login = $_POST['form']['loginVisiteur'];
        $password = $_POST['form']['pwdVisiteur'];
        $repository = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:visiteur');
        $query = $repository->createQueryBuilder('u');
        $query->andWhere('u.loginVisiteur =:login AND u.pwdVisiteur =:password')
               ->setParameter('login', $login)
               ->setParameter('password', $password);
        $authentification = $query->getQuery()->getResult();
        // test de l'existance du tableau de variable $authentification a l'emplacement ['0']
        if(isset($authentification['0'])){
            $prenom = $authentification['0']->getPrenomVisiteur();
            $session = $this->get('session');
            $session->set('identificated', true);
            $session->set('prenom', $prenom);
            return $this->redirectToRoute('gs_bmain_homepage');
        }
            $this->addFlash('notice_erreur', 'Erreur de Login ou de Mot de passe');
            return $this->render('GSBmainBundle:Log:login.html.twig',array('form' => $form->createView()));  
        }
        return $this->render('GSBmainBundle:Log:login.html.twig',array('form' => $form->createView()));
    }
    public function logoutAction(Request $request)
    {
        $session = $this->get('session');
        $session->set('identificated', false);
        $session->remove('prenom');
        return $this->redirectToRoute('gsb_login');
    }
}
