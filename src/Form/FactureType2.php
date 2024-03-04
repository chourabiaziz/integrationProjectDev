<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Facture;
use App\Repository\ContratRepository;
use App\Repository\FactureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $clientName = $options['clientName'];
        $builder->add('contrat', EntityType::class, [
            'class' => Contrat::class,
            'choice_label' => function ($contrat) {
                return 'de Ref°' . $contrat->getId() .
                    ' de couverture : ' . $contrat->getCouverture() .
                    ' de ' . $contrat->getDateDebut()->format('Y-m-d') .
                    ' jusqu\'à ' . $contrat->getDateFin()->format('Y-m-d') .
                    ' pour Client : ' . $contrat->getClient(); // Supposons que getNom() retourne le nom du client
            },
            'multiple' => true,
           
            'query_builder' => function (ContratRepository $er) use ($clientName) {
             
                // Utilisez le nom du client pour filtrer les contrats
                return $er->createQueryBuilder('c')
                    ->where('c.client = :client_name') // Supposons que le champ client dans Contrat est une chaîne de caractères
                    ->setParameter('client_name', $clientName);
            },
            


            'choice_attr' => function ($choice, $key, $value) {
                return ['class' => 'checkbox-inline'];
            },
        ]);
    }
 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('clientName'); // Définir 'client' comme option requise

        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
