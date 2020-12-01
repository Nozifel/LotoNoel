<?php

namespace App\Controller;

use App\Entity\Combinaison;
use App\Entity\Grille;
use App\Entity\Loto;
use App\Entity\Tirage;
use App\Form\LotoType;
use App\Repository\GrilleRepository;
use App\Repository\LotoRepository;
use App\Repository\TirageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @Route("/loto")
 */
class LotoController extends AbstractController
{
    /**
     * @Route("/", name="loto_index", methods={"GET"})
     */
    public function index(LotoRepository $lotoRepository): Response
    {
        return $this->render('loto/index.html.twig', [
            'lotos' => $lotoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="loto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $loto = new Loto();
        $form = $this->createForm(LotoType::class, $loto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $loto->setAuteur( $this->getUser() );

            $entityManager->persist($loto);
            $entityManager->flush();

            return $this->redirectToRoute('loto_index');
        }

        return $this->render('loto/new.html.twig', [
            'loto' => $loto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loto_show", methods={"GET"})
     */
    public function show(Loto $loto, TirageRepository $tirageRepository, GrilleRepository $grilleRepository ): Response
    {
        $tiragesJoueur = array();
        $tirages = array();

        $_nombresTires = $tirageRepository->findNombreTires( $loto );
        $nombresTires = array();

        $listeJoursTirage = array();

        if( !empty($_nombresTires) )
        {
            foreach ( $_nombresTires as $key => $_nombreTire ) {
                array_push($nombresTires, $_nombreTire['nombre']);

                if( !array_key_exists($_nombreTire['dateTirage']->format('Y-m-d'), $listeJoursTirage) )
                    $listeJoursTirage[ $_nombreTire['dateTirage']->format('Y-m-d') ] = array('nombres' => array(), 'date' => $_nombreTire['dateTirage']->format('Y-m-d') );

                array_push($listeJoursTirage[ $_nombreTire['dateTirage']->format('Y-m-d') ]['nombres'], $_nombreTire['nombre']);
            }
        }

        foreach( $loto->getJoueurs() as $key => $joueur )
        {
            $tirage = null;
            if( $joueur->getId() != $this->getUser()->getId() ) {

                $grille = $grilleRepository->findOneBy(
                    array(
                        'loto' => $loto,
                        'joueur' => $joueur
                    )
                );

                if( !empty($grille) )
                    $tirage = $grille;
                else {
                    $tirage = $tirageRepository->findBy(
                        array(
                            'loto' => $loto,
                            'joueur' => $joueur
                        ),
                        array(
                            'nombre' => 'ASC'
                        )
                    );
                }
            }

            if( $tirage )
                array_push($tirages, $tirage );
        }

        $grille = $grilleRepository->findOneBy(
            array(
                'loto' => $loto,
                'joueur' => $this->getUser()
            )
        );

        if( empty($grille) ) {
            if ($loto->getJoueurs()->contains($this->getUser()))
                $tiragesJoueur = $tirageRepository->findBy(
                    array(
                        'loto' => $loto,
                        'joueur' => $this->getUser()
                    ),
                    array(
                        'nombre' => 'ASC'
                    )
                );
        }
        else{
            $tiragesJoueur = $grille->getGrille();
        }

        return $this->render('loto/show.html.twig', [
            'loto' => $loto,
            'tiragesJoueur' => $tiragesJoueur,
            'tirages' => $tirages,
            'nombresTires' => $nombresTires,
            'listeJoursTirage' => $listeJoursTirage
        ]);
    }

    /**
     * @Route("/{id}/edit", name="loto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loto $loto): Response
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            throw $this->createNotFoundException('Page non trouvée !');

        $form = $this->createForm(LotoType::class, $loto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loto_index');
        }

        return $this->render('loto/edit.html.twig', [
            'loto' => $loto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loto_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Loto $loto): Response
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            throw $this->createNotFoundException('Page non trouvée !');

        if ($this->isCsrfTokenValid('delete'.$loto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loto_index');
    }

    /**
     * @Route("/{id}/genererTirage", name="loto_generer_tirage", methods={"POST"})
     */
    public function genererTirage(Request $request, Loto $loto): Response
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            return new JsonResponse(
                ['message' => "Vous n'êtes pas l'auteur"],
                Response::HTTP_FORBIDDEN
            );

        $joueurs = $loto->getJoueurs();
        $hauteur = $loto->getHauteurGrille();
        $largeur = $loto->getLargeurGrille();
        $nbJoueurs = $joueurs->count();
        $nbJours = $loto->getDateDebut()->diff( $loto->getDateFin() );

        $nombresParJoueurs = $hauteur * $largeur;

        $listeJoueurs = array();

        foreach ( $joueurs as $key => $joueur )
            $listeJoueurs[ $joueur->getId() ] = array('joueur' => $joueur, 'nbNombres' => 0);

        $nbTirage = $hauteur * $largeur * $nbJoueurs;

        $tiragesParJour = floor( $nbTirage / $nbJours->format("%a") );

        $loto->setTiragesParJour( $tiragesParJour );

        $nbTirage = range(1, $nbTirage);
        shuffle($nbTirage);

        for ( $i = 1; $i < count($nbTirage)+1; $i++ ) {

            do {
                $idLeJoueur = array_rand($listeJoueurs);

            }while( $listeJoueurs[ $idLeJoueur ]['nbNombres'] == $nombresParJoueurs );

            $listeJoueurs[ $idLeJoueur ]['nbNombres']++;

            $tirage = new Tirage();
            $tirage->setNombre( $i );
            $tirage->setJoueur( $listeJoueurs[ $idLeJoueur ]['joueur'] );
            $loto->addTirage( $tirage );

            if( $listeJoueurs[ $idLeJoueur ]['nbNombres'] == $nombresParJoueurs ) {
                unset($listeJoueurs[$idLeJoueur]);
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($loto);
        $entityManager->flush();

        return $this->render('loto/card.html.twig', [
            'loto' => $loto
        ]);
    }

    /**
     * @Route("/{id}/autoriseEditionGrilles", name="loto_autoriser_edition_grilles", methods={"POST"})
     */
    public function autoriserEditionGrilles(Request $request, Loto $loto): Response
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            return new JsonResponse(
                ['message' => "Vous n'êtes pas l'auteur"],
                Response::HTTP_FORBIDDEN
            );

        $loto->setAutoriserEditionGrilles( true );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($loto);
        $entityManager->flush();

        return $this->render('loto/card.html.twig', [
            'loto' => $loto
        ]);
    }

    /**
     * @Route("/{id}/addCombinaison", name="loto_add_combinaison", methods={"POST"})
     */
    public function addCombinaison(Request $request, Loto $loto): Response
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            return new JsonResponse(
                ['message' => "Vous n'êtes pas l'auteur"],
                Response::HTTP_FORBIDDEN
            );

        parse_str($request->get('form'), $datas);

        $typeCombinaison = $datas['type_combinaison-'.$loto->getId()];

        $combinaison = new Combinaison();
        $combinaison->setDescription( $datas['description'] );

        $combinaison->setType( $typeCombinaison );

        switch ($typeCombinaison)
        {
            case '1_colonne':
                $combinaison->setType( 'colonne' );
                break;

            case '1_ligne':
                $combinaison->setType( 'ligne' );
                break;

            case 'combinaison':
                $combinaison->setType( 'combinaison' );
                $combinaison->setPattern( $datas['c'] );
                break;

            case 'numero':
                $combinaison->setType( 'numero' );
                $combinaison->setNumero( $datas['numero'] );
                break;
        }


        $loto->addCombinaison( $combinaison );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($loto);
        $entityManager->flush();

        return $this->render('loto/card.html.twig', [
            'loto' => $loto
        ]);
    }

    /**
     * @Route("/{id}/deleteCombinaison/{idCombinaison?}", name="loto_delete_combinaison", methods={"POST"})
     * @Entity("combinaison", expr="repository.find(idCombinaison)")
     */
    public function deleteCombinaison( Request $request, Loto $loto, Combinaison $combinaison )
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            return new JsonResponse(
                ['message' => "Vous n'êtes pas l'auteur"],
                Response::HTTP_FORBIDDEN
            );

        $loto->removeCombinaison( $combinaison );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($loto);
        $entityManager->flush();

        return $this->render('loto/card.html.twig', [
            'loto' => $loto
        ]);
    }

    /**
     * @Route("/{id}/grille", name="grille_update", methods={"POST"})
     */
    public function updateGrille(Request $request, Loto $loto, TirageRepository $tirageRepository, GrilleRepository $grilleRepository): Response
    {
        $now = new \DateTime();

        if( $now >= $loto->getDateDebut() )
            return new JsonResponse(
                ['message' => "Le loto a déjà commencé. Vous ne pouvez plus modifier votre grille."],
                Response::HTTP_OK
            );

        $joueur = $this->getUser();

        $grille = $grilleRepository->findOneBy(
           array(
               'loto' => $loto,
               'joueur' => $joueur
           )
        );

        if( empty($grille) )
            $grille = new Grille();

        $datas = $request->get('numeros');

        $tiragesJoueur = $tirageRepository->findBy(
            array(
                'loto' => $loto,
                'joueur' => $joueur
            ),
            array(
                'nombre' => 'ASC'
            )
        );

        $_datas = $datas;
        sort($_datas);

        $listeRepo = array();

        foreach( $tiragesJoueur as $key => $tirageJoueur )
            array_push($listeRepo, $tirageJoueur->getNombre() );

        if( $_datas != $listeRepo )
            return new JsonResponse(
                ['message' => "Certains numéros ne vous appartiennent pas."],
                Response::HTTP_FORBIDDEN
            );

        $largeur = $loto->getLargeurGrille();

        $tableau = array();

        $tmp = array();
        foreach( $datas as $key => $data )
        {
            array_push($tmp, $data);

            if( ($key+1) % $largeur == 0 ) {
                array_push($tableau, $tmp);
                $tmp = array();
            }
        }

        $grille->setLoto($loto);
        $grille->setJoueur( $joueur );
        $grille->setGrille( $tableau );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($grille);
        $entityManager->flush();

        return new JsonResponse(
            ['message' => "Votre grille a été enregistrée."],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{id}/tirage", name="tirage", methods={"GET"})
     */
    public function tirageDuJour( Request $request, Loto $loto, TirageRepository $tirageRepository )
    {
        if( $loto->getAuteur()->getId() != $this->getUser()->getId() )
            throw $this->createNotFoundException('Page non trouvée !');

        $tirageParJour = $loto->getTiragesParJour();

        $totalTire = $tirageRepository->findNombreTires( $loto );
        $totalTire = count($totalTire);

        $now = new \DateTime();

        $debut = new \DateTime();
        $debut->setTime(0, 0, 0, 0);
        $fin  = new \DateTime();
        $fin->setTime(23, 59,59);

        do{
            $nombreTires = $tirageRepository->nombreDuJour($debut, $fin, $loto);

            $nombreTires = count( $nombreTires );

            if( $nombreTires < $tirageParJour ) {
                $tirage = $tirageRepository->randomTirage($loto->getId());

                $totalTire = $totalTire+1;

                if (isset($tirage[0])) {
                    $tirage[0]->setDateTirage( \DateTime::createFromFormat('U.u', microtime(TRUE)) );
                    $tirage[0]->setOrdre( $totalTire );

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($tirage[0]);
                    $entityManager->flush();
                }
            }
        }while( $nombreTires < $tirageParJour );

        return new JsonResponse(
            ['message' => "Votre grille a été enregistrée."],
            Response::HTTP_OK
        );
    }
}
