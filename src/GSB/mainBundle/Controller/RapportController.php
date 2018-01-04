<?php

namespace GSB\mainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use GSB\mainBundle\Entity\rapport_visite;
use GSB\mainBundle\Entity\offrir;
use GSB\mainBundle\Entity\famille;
use GSB\mainBundle\Entity\medicament;
use Symfony\Component\HttpFoundation\JsonResponse;

class RapportController extends Controller
{
    public function rechercherAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        // Suppression des variables de session si elles existent
        if($session->has('idRapport')){
            $session->remove('idRapport');
        }
        if($session->has('idVisiteur')){
            $session->remove('idVisiteur');
        }
        // Initialisation d'un objet de type Rapport_visite
        $monRapport = new rapport_visite();
        // Construction d'un formulaire de recherche pour implementer l'objet $monRapport de type Rapport_visite
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $monRapport);
        $formbuilder
                ->add('praticien', HiddenType::class, array('required' => false, 'label' => false))
                ->add('nomPraticien', TextType::class, array('required' => false, 'mapped' => false, 'label' => 'Login', 'attr' => (array('autocomplete' => "off" ))))
                ->add('dateDepart', DateType::class, array('required' => false, 'mapped' => false, 'widget' => 'single_text', 'label' => 'Du'))
                ->add('dateArrivee', DateType::class, array('required' => false, 'mapped' => false, 'widget' => 'single_text', 'label' => 'Au'))
                ->add('Valider', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')));
        $form = $formbuilder->getForm();
        //
        // Verification des variables de type $_POST
        //
        if ($request->isMethod('POST')) {
            $repository = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:rapport_visite');
            // Initialisation de la requete
            $query = $repository->createQueryBuilder('u')
                    ->orderBy('u.dateRapport','ASC');
            // Si le praticien à été renseigné
            if(isset($_POST['form']['praticien']) && $_POST['form']['praticien'] != ""){
                $praticien = $_POST['form']['praticien'];
                $query->andWhere('u.praticien =:praticien')
                ->setParameter('praticien', $praticien);
            }
            // Si la date DU est renseignée
            if(isset($_POST['form']['dateDepart']) && $_POST['form']['dateDepart'] != ""){
                $dateDepart = $_POST['form']['dateDepart'];
                if(isset($_POST['form']['dateArrivee'])&& $_POST['form']['dateArrivee'] != ""){
                    // Si la date AU est renseignée
                    $dateArrivee = $_POST['form']['dateArrivee'];
                }else{
                    // Si la date AU n'à pas été renseignée alors elle vaut la date du jour  
                    $dateArrivee= new \DateTime();
                }
                $query->andWhere('u.dateRapport BETWEEN :dateDepart AND :dateArrivee')
                ->setParameter('dateDepart', $dateDepart)
                ->setParameter('dateArrivee', $dateArrivee);
            // Sinon si la date AU est renseignée
            }elseif(isset($_POST['form']['dateArrivee']) && $_POST['form']['dateArrivee'] != ""){
                $dateArrivee = $_POST['form']['dateArrivee'];
                if(isset($_POST['form']['dateDepart']) && $_POST['form']['dateDepart'] != ""){
                    // Si la date DU est renseignée
                    $dateDepart= $_POST['form']['dateDepart'];
                }else{
                    // Si la date DU n'à pas été renseignée alors elle vaut 01-01-1900
                    $dateDepart= new \DateTime('01-01-1900');
                }
                $query->andWhere('u.dateRapport BETWEEN :dateDepart AND :dateArrivee')
                ->setParameter('dateDepart', $dateDepart)
                ->setParameter('dateArrivee', $dateArrivee);
            }
            // Execution de la requete
            $resultat = $query->getQuery()->getResult();
            // Test de la variable $resultat
            if(count($resultat)==0){
                // Si aucun resultat ne correspond à la requete
                $this->addFlash('notice_erreur', 'Aucun resultat !');
                return $this->render('GSBmainBundle:Rapport:rechercher_rapport.html.twig',array('form' => $form->createView()));
            }elseif(count($resultat)==1){
                // Si un seul resultat correspond à la requete, l'afficher
                $session = $this->get('session');
                $session->set('resultat', $resultat);
                return $this->redirectToRoute('gsb_afficher_rapport');
            }else{
                // Si plusieurs resultats correspondent à la requete
                // Construction d'un formulaire de choix
                $formbuilder = $this->get('form.factory')->createBuilder();
                $formbuilder
                    ->setAction($this->generateUrl('gsb_choisir_rapport'))
                    ->add('idRapport', ChoiceType::class, [
                        'choices' => $resultat,
                        'choice_label' => function ($resultat){
                            return $resultat->getDateRapport()->format('d-m-Y').' -> '.$resultat->getPraticien()->getPrenomPraticien().' '.$resultat->getPraticien()->getNomPraticien();
                        },
                        'choice_value' => 'idRapport',
                        'expanded' => false,
                        'multiple' => true,
                        'label' => 'Selectionner un rapport',
                        'attr' => array('class' => 'col-xs-12 listeClient'),
                    ])
                        ->add('Valider', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')));
                    $formListe = $formbuilder->getForm();
                return $this->render('GSBmainBundle:Rapport:rechercher_rapport.html.twig',array('form2' => $formListe->createView()));
            }
        }
        return $this->render('GSBmainBundle:Rapport:rechercher_rapport.html.twig',array('form' => $form->createView()));
    }
    public function choisirAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        if(isset($_POST['form'])){
            $session = $this->get('session');
            $id = $_POST['form']['idRapport'][0];
            $session->set('id', $id);
            return $this->redirectToRoute('gsb_afficher_rapport');
        }else{
            return $this->redirectToRoute('gsb_rechercher_rapport');
        }
    }
    public function afficher_rapportAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        // Récupération des resultats
        $session = $this->get('session');
        if($session->has('idRapport')){
            $id = $session->get('idRapport');
            $session->remove('idRapport');
        }
        elseif($session->has('resultat')){
            $resultat = $session->get('resultat');
            $session->remove('resultat');
            $id=$resultat[0]->getIdRapport();
        }elseif($session->has('id')) {
            $id=$session->get('id');
            $session->remove('id');
        }
        // Repository Rapport
        $repositoryRapport = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:rapport_visite');
        $ceRapport = $repositoryRapport->findOneBy(array('idRapport' => $id));
        $idPraticien = $ceRapport->getPraticien()->getIdPraticien();
        $idVisiteur = $ceRapport->getVisiteur()->getIdVisiteur();
        // Repository Praticien
        $repositoryPraticien = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:praticien');
        $cePraticien = $repositoryPraticien->findOneBy(array('idPraticien' => $idPraticien));
        // Repository Visiteur
        $repositoryVisiteur = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:visiteur');
        $ceVisiteur = $repositoryVisiteur->findOneBy(array('idVisiteur' => $idVisiteur));
        // Repository offert
        $repositoryOffrir = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:offrir');
        $offert = $repositoryOffrir->findBy(array('rapport' => $id));
        
        // Mise en session du IdVisiteur et IdRapport
        $session->set('idVisiteur', $idVisiteur);
        $session->set('idRapport', $id);
        
        // Formulaire Praticien
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $cePraticien);
        $formbuilder
            ->add('prenomPraticien', TextType::class, array('attr' => array('disabled' => true)))
            ->add('nomPraticien', TextType::class, array('attr' => array('disabled' => true)))
            ->add('adressePraticien', HiddenType::class, array('attr' => array('disabled' => true)))
            ->add('cpPraticien', HiddenType::class, array('attr' => array('disabled' => true)))
            ->add('villePraticien', HiddenType::class, array('attr' => array('disabled' => true)));
        $formPraticien = $formbuilder->getForm(); 
        // Formulaire Visiteur
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $ceVisiteur);
        $formbuilder
            ->add('prenomVisiteur', TextType::class, array('attr' => array('disabled' => true)))
            ->add('nomVisiteur', TextType::class, array('attr' => array('disabled' => true)))
            ->add('adresseVisiteur', HiddenType::class, array('attr' => array('disabled' => true)))
            ->add('cpVisiteur', HiddenType::class, array('attr' => array('disabled' => true)))
            ->add('villeVisiteur', HiddenType::class, array('attr' => array('disabled' => true)));
        $formVisiteur = $formbuilder->getForm();
        // Formulaire Rapport
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $ceRapport);
        $formbuilder
            ->add('dateRapport', DateType::class, array('attr' => array('disabled' => true),'widget' => 'single_text'))
            ->add('bilan', TextareaType::class, array('attr' => array('disabled' => true)))
            ->add('motif', TextType::class, array('attr' => array('disabled' => true)));
        $formRapport = $formbuilder->getForm();
        
        // Formulaire Offert
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $offert);
        $formbuilder
            ->setAction($this->generateUrl('gsb_traiter_choix_offrir_rapport'))
            ->add('medicament', ChoiceType::class, [
                'choices' => $offert,
                'choice_label' => function ($offert){
                    return $offert->getQteOfferte().' | '.$offert->getMedicament()->getNomCommercial();
                },
                'choice_value' => function ($offert){
                    return $offert->getMedicament()->getIdMedicament();
                },
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
            ->add('Ajouter', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')))
            ->add('Modifier', SubmitType::class, array('attr' => array('class' => 'bt btContinuer', 'onclick' => 'return verifChecked();')))
            ->add('Supprimer', SubmitType::class, array('attr' => array('class' => 'bt btContinuer', 'onclick' => 'return verifCheckedSupp();')));
        $formOffert = $formbuilder->getForm();
        
        return $this->render('GSBmainBundle:Rapport:afficherRapport.html.twig', array('formPraticien' => $formPraticien->createView(), 'formVisiteur' => $formVisiteur->createView(), 'formRapport' => $formRapport->createView(), 'formOffert' => $formOffert->createView()));
    }
    public function traiter_choix_offrirAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        // Récuperation des variables de session
        $session = $this->get('session');
        $idRapport = $session->get('idRapport');
        $idVisiteur = $session->get('idVisiteur');
        // Suivant le bouton utilisé
        // Bouton Supprimer
        if(isset($_POST['form']['Supprimer'])){
            $idMedicament = $_POST['form']['medicament'];
            $this->addFlash('notice_success', 'Echantillon retiré !');
            $em = $this->getDoctrine()->getManager();
            $echantillonOffert = $em->getRepository('GSBmainBundle:offrir')->findOffert($idMedicament, $idRapport, $idVisiteur);
            $em->remove($echantillonOffert);
            $em->flush();
            return $this->redirectToRoute('gsb_afficher_rapport');
        }
        // Bouton Ajouter
        if(isset($_POST['form']['Ajouter'])){
            // redirection vers creer_offrirAction controller
            return $this->redirectToRoute('gsb_creer_offrir');
        }
        // Bouton Modifier
        if(isset($_POST['form']['Modifier'])){
            $session = $this->get('session');
//            $session->set('idMedicament', $_POST['form']['medicament'][0]);
            $session->set('idMedicament', $_POST['form']['medicament']);
            // redirection vers modifier_offrirAction controller
            return $this->redirectToRoute('gsb_modifier_offrir');
        }
        return $this->redirectToRoute('gsb_afficher_rapport');
    }
    public function creer_offrirAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        // Création du formulaire en fonction de se qui est retourné dans la variable $_POST
        if(isset($_POST['form']['qteOfferte'])){
            // Recuperation des idRapport et idVisiteur
            $session = $this->get('session');
            $idRapport = $session->get('idRapport');
            $idVisiteur = $session->get('idVisiteur');
            $idMedicament = $_POST['form']['medicament'];
            // Récuperation des objets medicament, rapport et visiteur
            // Medicament
            $repositoryMedicament = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:medicament');
            $leMedicament = $repositoryMedicament->findOneBy(array('idMedicament' => $idMedicament));
            // Rapport
            $repositoryRapport = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:rapport_visite');
            $leRapport = $repositoryRapport->findOneBy(array('idRapport' => $idRapport));
            // Visiteur
            $repositoryVisiteur = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:visiteur');
            $leVisiteur = $repositoryVisiteur->findOneBy(array('idVisiteur' => $idVisiteur));
            
            // Verification de l'existance d'un échantillon identique
            $repositoryTestDejaOffert = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:offrir');
            $dejaOffert = $repositoryTestDejaOffert->findDejaOffert($idMedicament, $idRapport, $idVisiteur);
            
            // Si le medicament n'est pas associé a ce rapport
            if(!$dejaOffert){
                // Création d'un nouvel objet offrir
                $echantillonOffert = new offrir();
                $echantillonOffert->setMedicament($leMedicament);
                $echantillonOffert->setRapport($leRapport);
                $echantillonOffert->setVisiteur($leVisiteur);
                $echantillonOffert->setQteOfferte($_POST['form']['qteOfferte']);
                // Enregistrement dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($echantillonOffert);
                $em->flush();
                $this->addFlash('notice_success', 'Echantillon offert enregistré !');
            }else{
                $this->addFlash('notice_erreur', 'Attention ! Vous ne pouvez offrir deux fois le même échantillon !');
                return $this->redirectToRoute('gsb_creer_offrir');
            }
            
        }elseif(isset($_POST['form']['medicament'])){ // La variable $_POST contient le medicament
            $repositoryMedicament = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:medicament');
            $leMedicament = $repositoryMedicament->findOneBy(array('idMedicament' => $_POST['form']['medicament']));
            // Recuperation des idRapport et idVisiteur
            $session = $this->get('session');
            $idRapport = $session->get('idRapport');
            $idVisiteur = $session->get('idVisiteur');

            // Création d'un nouvel objet offrir
            $echantillonOffert = new offrir();
            $echantillonOffert->setMedicament($leMedicament->getIdMedicament());
            $echantillonOffert->setRapport($idRapport);
            $echantillonOffert->setVisiteur($idVisiteur);
            
            $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $echantillonOffert);
            $formbuilder
                ->add('famille', TextType::class, array('mapped' => false, 'disabled' => true, 'data' => $leMedicament->getFamille()->getLibFamille()))
                ->add('leMedicament', TextType::class, array('mapped' => false, 'disabled' => true, 'data' => $leMedicament->getNomCommercial()))
                ->add('medicament', HiddenType::class)
                ->add('rapport', HiddenType::class)
                ->add('visiteur', HiddenType::class)
                ->add('qteOfferte', TextType::class, array('label' => 'Quantité offerte'))
                ->add('Continuer', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')))
                ->add('Annuler', ButtonType::class, array('attr' => array('class' => 'bt btContinuer', 'onclick' => 'window.location="Afficher_rapport"')));
            $form = $formbuilder->getForm();
            return $this->render('GSBmainBundle:Rapport:offrir.html.twig', array('form' => $form->createView()));
        }elseif(isset($_POST['form']['famille'])) {// La variable $_POST contient la famille de medicament
            $idFamille = $_POST['form']['famille'];
            $repositoryFamille = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:famille');
            $laFamille = $repositoryFamille->findOneBy(array('idFamille' => $idFamille));
            $repositoryMedicament = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:medicament');
            $lesMedicaments = $repositoryMedicament->findBy(array('famille' => $idFamille));
            // Création du formulaire
            $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $lesMedicaments);
            $formbuilder
                ->add('famille', TextType::class, array('data' => $laFamille->getLibFamille(), 'disabled' => true))
                ->add('medicament', ChoiceType::class, [
                    'choices' => $lesMedicaments,
                    'choice_label' => function ($lesMedicaments){
                        return $lesMedicaments->getNomCommercial();
                    },
                    'choice_value' => 'idMedicament',
                    'multiple' => false,
                    'expanded' => false,
                ])
                ->add('Continuer', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')))
                ->add('Annuler', ButtonType::class, array('attr' => array('class' => 'bt btContinuer', 'onclick' => 'window.location="Afficher_rapport"')));
            $form = $formbuilder->getForm();
            return $this->render('GSBmainBundle:Rapport:offrir.html.twig', array('form' => $form->createView()));
        }else{ // Rien n'a encore été retourné dans la variable $_POST
            $repositoryMedicament = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:medicament');
            $lesMedicaments = $repositoryMedicament->findAll();
            // Construction du formulaire
            $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $lesMedicaments);
            $formbuilder
                ->add('famille', EntityType::class, [
                    'class' => famille::class,
                    'choice_label' => "libFamille",
                    'expanded' => false,
                    'multiple' => false,
                    'label' => 'Famille',
                ])
                ->add('Continuer', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')))
                ->add('Annuler', ButtonType::class, array('attr' => array('class' => 'bt btContinuer', 'onclick' => 'window.location="Afficher_rapport"')));
            $form = $formbuilder->getForm();
            return $this->render('GSBmainBundle:Rapport:offrir.html.twig', array('form' => $form->createView()));
        }
        return $this->redirectToRoute('gsb_afficher_rapport');
    }
    public function modifier_offrirAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        // Récuperation des ID de rapport, visiteur et medicament
        $session = $this->get('session');
        $idRapport = $session->get('idRapport');
        $idVisiteur = $session->get('idVisiteur');
        $idMedicament = $session->get('idMedicament');
        //// Récupération des objet Medicament, Rapport et Visiteur
        // Medicament
        $repositoryMedicament = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:medicament');
        $leMedicament = $repositoryMedicament->findOneBy(array('idMedicament' => $idMedicament));
        // Rapport
        $repositoryRapport = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:rapport_visite');
        $leRapport = $repositoryRapport->findOneBy(array('idRapport' => $idRapport));
        // Visiteur
        $repositoryVisiteur = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:visiteur');
        $leVisiteur = $repositoryVisiteur->findOneBy(array('idVisiteur' => $idVisiteur));

        // Récuperation de l'objet offrir
        $repository = $this->getDoctrine()->getManager()->getRepository('GSBmainBundle:offrir');
        $echantillonOffert = $repository->findOffert($leMedicament, $leRapport, $leVisiteur);

//        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $echantillonOffert[0]);
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $echantillonOffert);
        $formbuilder
            ->add('famille', TextType::class, array('mapped' => false, 'disabled' => true, 'data' => $leMedicament->getFamille()->getLibFamille()))
            ->add('leMedicament', TextType::class, array('mapped' => false, 'disabled' => true, 'data' => $leMedicament->getNomCommercial()))
            ->add('idOffrir', HiddenType::class)
            ->add('qteOfferte', TextType::class, array('label' => 'Quantité offerte'))
            ->add('Valider', SubmitType::class, array('attr' => array('class' => 'bt btContinuer')))
            ->add('Annuler', ButtonType::class, array('attr' => array('class' => 'bt btContinuer', 'onclick' => 'window.location="Afficher_rapport"')));
        $formModifier = $formbuilder->getForm();
        
        if(isset($_POST['form']['idOffrir']) && isset($_POST['form']['Valider'])){ // Si on à modifié un échantillon
            $formModifier->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
//            $em->persist($echantillonOffert[0]);
            $em->persist($echantillonOffert);
            $em->flush();
            $this->addFlash('notice_success', 'Echantillon offert modifié !');
            return $this->redirectToRoute('gsb_afficher_rapport');
        }
        return $this->render('GSBmainBundle:Rapport:offrir.html.twig', array('formModifier' => $formModifier->createView()));
    }
    public function ajaxAction(Request $request){
        // Verification de l'authentification
        $session = $this->get('session');
        if(!$session->get('identificated')){
            return $this->redirectToRoute('gsb_login');
        }
        if(isset($_POST['valeur'])){
            // recupération de la valeur de l'input praticien
            $valeur = $_POST['valeur'];
            $retour = array();
            $em = $this->getDoctrine()->getManager();
            $resultat = $em->getRepository('GSBmainBundle:praticien')->createQueryBuilder('u')
            ->where('u.nomPraticien LIKE :praticien')
            ->setParameter('praticien', $valeur.'%')
            ->orderBy('u.nomPraticien', 'ASC')
            ->getQuery()
            ->getResult();
            if(count($resultat)>0){
                $i=0;
                foreach ($resultat as $unResultat) {
                    $retour[$i]['id'] = $unResultat->getIdPraticien();
                    $retour[$i]['nom'] = $unResultat->getNomPraticien();
                    $retour[$i]['prenom'] = $unResultat->getPrenomPraticien();
                    $i++;
                }
                $response = new JsonResponse();
                $response->setData($retour);
                return $response;
            }
        }
    }
}