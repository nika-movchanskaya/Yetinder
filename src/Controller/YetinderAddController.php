<?php
namespace App\Controller;

use App\Entity\Yeti;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\DBAL\Connection;

class YetinderAddController extends AbstractController
{
    /**
     * @Route("/add", name="app_add")
     */

    public function new(Request $request, Connection $connection, SluggerInterface $slugger): Response
    {
        $yeti = new Yeti();
        $form = $this->createFormBuilder($yeti)
            ->add('name', TextType::class, ['required' => true, ])
            ->add('height', IntegerType::class, ['required' => true, 'label' => 'Height, cm',])
            ->add('weight', IntegerType::class, ['required' => true, 'label' => 'Weight, kg',])
            ->add('address', TextType::class, ['required' => true, 'label' => 'Where did you see',])
            ->add('photo', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Add Yeti'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $yeti = $form->getData();

            $photo = $form->get('photo')->getData();

            //if photo was added, download it
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                //move the file to the upload directory
                try {
                    $photo->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $this->redirectToRoute('app_main');
                }

                $yeti->setPhoto($newFilename);
            }
            else {
                $newFilename = $this->getParameter('default_photo');
            }

            $name = $yeti->getName();
            $height = $yeti->getHeight();
            $weight = $yeti->getWeight();
            $address = $yeti->getAddress();

            //insert new one into DB
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder
                ->insert('Yetis')
                ->setValue('name', '?')
                ->setValue('height', '?')
                ->setValue('weight', '?')
                ->setValue('address', '?')
                ->setValue('photo', '?')
                ->setParameter(0, $name)
                ->setParameter(1, $height)
                ->setParameter(2, $weight)
                ->setParameter(3, $address)
                ->setParameter(4, $newFilename);

            $res = $queryBuilder->execute();

            $this->addFlash(
                'notice',
                'Great! New Yeti was saved:)'
            );
            return $this->redirectToRoute('app_main');
        }

        return $this->renderForm('yeti/new.html.twig', [
            'form' => $form,
        ]);
    }
} 
?>