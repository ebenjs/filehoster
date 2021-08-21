<?php

namespace App\Form;

use App\Entity\FileToUpload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FileToUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('summary')
            ->add('createdDate')
            ->add('category')
            ->add('path', FileType::class, [
                'label' => 'File to upload',
                'mapped' => false,
                'required' => true,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'video/mpeg',
                            'video/mp4',
                        ],
                        'mimeTypesMessage' => 'You must select a pdf, an image or a video file.',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FileToUpload::class,
        ]);
    }
}
