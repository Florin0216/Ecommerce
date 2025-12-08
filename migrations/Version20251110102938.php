<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251110102938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop__delivery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop__order ADD delivery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop__order ADD CONSTRAINT FK_FAB3598612136921 FOREIGN KEY (delivery_id) REFERENCES shop__delivery (id)');
        $this->addSql('CREATE INDEX IDX_FAB3598612136921 ON shop__order (delivery_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__order DROP FOREIGN KEY FK_FAB3598612136921');
        $this->addSql('DROP TABLE shop__delivery');
        $this->addSql('DROP INDEX IDX_FAB3598612136921 ON shop__order');
        $this->addSql('ALTER TABLE shop__order DROP delivery_id');
    }
}
