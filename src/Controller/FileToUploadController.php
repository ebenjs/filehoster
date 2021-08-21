<?php

namespace App\Controller;

use App\Entity\FileToUpload;
use App\Form\FileToUploadType;
use App\Repository\FileToUploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/file/to/upload")
 */
class FileToUploadController extends AbstractController
{
    /**
     * @Route("/", name="file_to_upload_index", methods={"GET"})
     */
    public function index(FileToUploadRepository $fileToUploadRepository): Response
    {
        return $this->render('file_to_upload/index.html.twig', [
            'file_to_uploads' => $fileToUploadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="file_to_upload_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fileToUpload = new FileToUpload();
        $form = $this->createForm(FileToUploadType::class, $fileToUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fileToUpload */
            $file = $form->get('path')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                $fileToUpload->setSize($file->getSize());

                try {
                    $file->move(
                        $this->getParameter('uploadsDirectory').'/'.$fileToUpload->getCategory()->getName(),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $fileToUpload->setPath($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fileToUpload);
            $entityManager->flush();

            return $this->redirectToRoute('file_to_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('file_to_upload/new.html.twig', [
            'file_to_upload' => $fileToUpload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_to_upload_show", methods={"GET"})
     */
    public function show(FileToUpload $fileToUpload): Response
    {
        return $this->render('file_to_upload/show.html.twig', [
            'file_to_upload' => $fileToUpload,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="file_to_upload_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FileToUpload $fileToUpload): Response
    {
        $form = $this->createForm(FileToUploadType::class, $fileToUpload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_to_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('file_to_upload/edit.html.twig', [
            'file_to_upload' => $fileToUpload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_to_upload_delete", methods={"POST"})
     */
    public function delete(Request $request, FileToUpload $fileToUpload): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fileToUpload->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fileToUpload);
            $entityManager->flush();
        }

        return $this->redirectToRoute('file_to_upload_index', [], Response::HTTP_SEE_OTHER);
    }
}
