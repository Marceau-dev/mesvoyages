<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260221145225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE visite_environnement ADD CONSTRAINT FK_6690F746C1C5DC59 FOREIGN KEY (visite_id) REFERENCES visite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite_environnement ADD CONSTRAINT FK_6690F746BAFB82A1 FOREIGN KEY (environnement_id) REFERENCES environnement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite DROP image_name, DROP image_size, DROP updated_at');
        $this->addSql('ALTER TABLE visite_environnement DROP FOREIGN KEY FK_6690F746C1C5DC59');
        $this->addSql('ALTER TABLE visite_environnement DROP FOREIGN KEY FK_6690F746BAFB82A1');
    }
}
