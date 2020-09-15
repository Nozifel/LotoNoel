<?php

namespace App\Controller;

use App\Entity\Loto;
use App\Form\LotoType;
use App\Repository\LotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function show(Loto $loto): Response
    {
        return $this->render('loto/show.html.twig', [
            'loto' => $loto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="loto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loto $loto): Response
    {
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
        if ($this->isCsrfTokenValid('delete'.$loto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loto_index');
    }
}
