<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228095411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, heure_overture TIME NOT NULL, heure_fermeture TIME NOT NULL, avis VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE panne (id INT AUTO_INCREMENT NOT NULL, localisation VARCHAR(255) NOT NULL, panne VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, atelier_id INT DEFAULT NULL, INDEX IDX_3885B26082E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, annee_fabrication INT NOT NULL, numero_serie VARCHAR(255) NOT NULL, type_carburant VARCHAR(255) NOT NULL, numero_immatriculation VARCHAR(255) NOT NULL, kilometrage INT NOT NULL, couleur VARCHAR(255) NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, prix_actuel DOUBLE PRECISION NOT NULL, date_achat DATETIME NOT NULL, panne_id INT DEFAULT NULL, INDEX IDX_E9E2810F65B7B5BD (panne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B26082E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F65B7B5BD FOREIGN KEY (panne_id) REFERENCES panne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne DROP FOREIGN KEY FK_3885B26082E2CF35');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F65B7B5BD');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE panne');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
