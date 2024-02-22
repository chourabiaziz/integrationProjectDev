<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221115130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne DROP FOREIGN KEY FK_3885B260A40B286D');
        $this->addSql('DROP INDEX IDX_3885B260A40B286D ON panne');
        $this->addSql('ALTER TABLE panne DROP id_voiture_id, DROP statut_intervention');
        $this->addSql('ALTER TABLE voiture ADD panne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F65B7B5BD FOREIGN KEY (panne_id) REFERENCES panne (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810F65B7B5BD ON voiture (panne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne ADD id_voiture_id INT DEFAULT NULL, ADD statut_intervention VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B260A40B286D FOREIGN KEY (id_voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_3885B260A40B286D ON panne (id_voiture_id)');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F65B7B5BD');
        $this->addSql('DROP INDEX IDX_E9E2810F65B7B5BD ON voiture');
        $this->addSql('ALTER TABLE voiture DROP panne_id');
    }
}
