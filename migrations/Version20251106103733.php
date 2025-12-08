<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106103733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__order ADD payment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop__order ADD CONSTRAINT FK_FAB359864C3A3BB FOREIGN KEY (payment_id) REFERENCES shop__payment (id)');
        $this->addSql('CREATE INDEX IDX_FAB359864C3A3BB ON shop__order (payment_id)');
        $this->addSql('ALTER TABLE shop__payment ADD currency VARCHAR(3) NOT NULL, ADD status VARCHAR(20) NOT NULL, ADD method VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__order DROP FOREIGN KEY FK_FAB359864C3A3BB');
        $this->addSql('DROP INDEX IDX_FAB359864C3A3BB ON shop__order');
        $this->addSql('ALTER TABLE shop__order DROP payment_id');
        $this->addSql('ALTER TABLE shop__payment DROP currency, DROP status, DROP method');
    }
}
