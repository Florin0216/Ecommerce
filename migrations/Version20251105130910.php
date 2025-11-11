<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105130910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__billing ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop__billing ADD CONSTRAINT FK_43D25741A76ED395 FOREIGN KEY (user_id) REFERENCES user__user (id)');
        $this->addSql('CREATE INDEX IDX_43D25741A76ED395 ON shop__billing (user_id)');
        $this->addSql('ALTER TABLE shop__shipping ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop__shipping ADD CONSTRAINT FK_1A6BDCCFA76ED395 FOREIGN KEY (user_id) REFERENCES user__user (id)');
        $this->addSql('CREATE INDEX IDX_1A6BDCCFA76ED395 ON shop__shipping (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__billing DROP FOREIGN KEY FK_43D25741A76ED395');
        $this->addSql('DROP INDEX IDX_43D25741A76ED395 ON shop__billing');
        $this->addSql('ALTER TABLE shop__billing DROP user_id');
        $this->addSql('ALTER TABLE shop__shipping DROP FOREIGN KEY FK_1A6BDCCFA76ED395');
        $this->addSql('DROP INDEX IDX_1A6BDCCFA76ED395 ON shop__shipping');
        $this->addSql('ALTER TABLE shop__shipping DROP user_id');
    }
}
