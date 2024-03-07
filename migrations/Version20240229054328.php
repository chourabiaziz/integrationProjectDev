<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229054328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat CHANGE a_societe_assurance_attestation_valable_du a_societe_assurance_attestation_valable_du DATE DEFAULT NULL, CHANGE a_societe_assurance_attestation_valable_au a_societe_assurance_attestation_valable_au DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat CHANGE a_societe_assurance_attestation_valable_du a_societe_assurance_attestation_valable_du DATE NOT NULL, CHANGE a_societe_assurance_attestation_valable_au a_societe_assurance_attestation_valable_au DATE NOT NULL');
    }
}
