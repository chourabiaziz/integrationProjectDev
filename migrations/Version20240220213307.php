<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220213307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat ADD bstationnement_arret TINYINT(1) NOT NULL, ADD bquittait_stationnement_arret TINYINT(1) NOT NULL, ADD bprenait_stationnement TINYINT(1) NOT NULL, ADD bsortait_dun_parking_lieu TINYINT(1) NOT NULL, ADD bsengageait_dun_parking_lieu TINYINT(1) NOT NULL, ADD bsengageait_sur_une_place_sens_gigatoire TINYINT(1) NOT NULL, ADD brouler_sur_une_place_sens_gigatoire TINYINT(1) NOT NULL, ADD bheurtait_a_larriere TINYINT(1) NOT NULL, ADD broulait_dans_meme_sens_sure_une_file_differente TINYINT(1) NOT NULL, ADD bchangeait_file TINYINT(1) NOT NULL, ADD bdoublait TINYINT(1) NOT NULL, ADD bvirait_droite TINYINT(1) NOT NULL, ADD bvirait_gauche TINYINT(1) NOT NULL, ADD breculait TINYINT(1) NOT NULL, ADD bempietait_sur_une_voie TINYINT(1) NOT NULL, ADD bvenait_de_droite TINYINT(1) NOT NULL, ADD bobservation_signal TINYINT(1) NOT NULL, ADD bindiquation_nombre_cases TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat DROP bstationnement_arret, DROP bquittait_stationnement_arret, DROP bprenait_stationnement, DROP bsortait_dun_parking_lieu, DROP bsengageait_dun_parking_lieu, DROP bsengageait_sur_une_place_sens_gigatoire, DROP brouler_sur_une_place_sens_gigatoire, DROP bheurtait_a_larriere, DROP broulait_dans_meme_sens_sure_une_file_differente, DROP bchangeait_file, DROP bdoublait, DROP bvirait_droite, DROP bvirait_gauche, DROP breculait, DROP bempietait_sur_une_voie, DROP bvenait_de_droite, DROP bobservation_signal, DROP bindiquation_nombre_cases');
    }
}
