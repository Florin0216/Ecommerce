<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251104134921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop__billing (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(64) NOT NULL, last_name VARCHAR(64) NOT NULL, address LONGTEXT NOT NULL, city VARCHAR(64) NOT NULL, country VARCHAR(64) NOT NULL, postal_code INT NOT NULL, phone_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__shipping (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(64) NOT NULL, last_name VARCHAR(64) NOT NULL, address LONGTEXT NOT NULL, city VARCHAR(64) NOT NULL, country VARCHAR(64) NOT NULL, postal_code INT NOT NULL, phone_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop__order ADD billing_id INT DEFAULT NULL, ADD shipping_id INT DEFAULT NULL, DROP first_name, DROP last_name, DROP email, DROP address, DROP city, DROP country, DROP postal_code, DROP phone_number');
        $this->addSql('ALTER TABLE shop__order ADD CONSTRAINT FK_FAB359863B025C87 FOREIGN KEY (billing_id) REFERENCES shop__billing (id)');
        $this->addSql('ALTER TABLE shop__order ADD CONSTRAINT FK_FAB359864887F3F8 FOREIGN KEY (shipping_id) REFERENCES shop__shipping (id)');
        $this->addSql('CREATE INDEX IDX_FAB359863B025C87 ON shop__order (billing_id)');
        $this->addSql('CREATE INDEX IDX_FAB359864887F3F8 ON shop__order (shipping_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__order DROP FOREIGN KEY FK_FAB359863B025C87');
        $this->addSql('ALTER TABLE shop__order DROP FOREIGN KEY FK_FAB359864887F3F8');
        $this->addSql('DROP TABLE shop__billing');
        $this->addSql('DROP TABLE shop__shipping');
        $this->addSql('DROP INDEX IDX_FAB359863B025C87 ON shop__order');
        $this->addSql('DROP INDEX IDX_FAB359864887F3F8 ON shop__order');
        $this->addSql('ALTER TABLE shop__order ADD first_name VARCHAR(64) NOT NULL, ADD last_name VARCHAR(64) NOT NULL, ADD email VARCHAR(128) NOT NULL, ADD address LONGTEXT NOT NULL, ADD city VARCHAR(64) NOT NULL, ADD country VARCHAR(64) NOT NULL, ADD postal_code INT NOT NULL, ADD phone_number INT NOT NULL, DROP billing_id, DROP shipping_id');
    }
}
