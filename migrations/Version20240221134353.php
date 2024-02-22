<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221134353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne ADD atelier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B26082E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_3885B26082E2CF35 ON panne (atelier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne DROP FOREIGN KEY FK_3885B26082E2CF35');
        $this->addSql('DROP INDEX IDX_3885B26082E2CF35 ON panne');
        $this->addSql('ALTER TABLE panne DROP atelier_id');
    }
}
