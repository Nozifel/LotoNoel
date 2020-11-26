<?php

namespace App\Controller;

use App\Entity\Combinaison;
use App\Entity\Loto;
use App\Entity\Tirage;
use App\Form\LotoType;
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
    public function show(Loto $loto, TirageRepository $tirageRepository ): Response
    {
        $tirages = array();

        if( $loto->getJoueurs()->contains( $this->getUser() ) )
            $tirages = $tirageRepository->findBy(
                array(
                    'loto' => $loto,
                    'joueur' => $this->getUser()
                ),
                array(
                    'nombre' => 'ASC'
                )
            );

        return $this->render('loto/show.html.twig', [
            'loto' => $loto,
            'tirages' => $tirages
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
}
