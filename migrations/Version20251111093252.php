<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251111093252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop__wishlist_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, wishlist_id INT DEFAULT NULL, INDEX IDX_5BD5B5C04584665A (product_id), INDEX IDX_5BD5B5C0FB8E54CD (wishlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop__wishlist_item ADD CONSTRAINT FK_5BD5B5C04584665A FOREIGN KEY (product_id) REFERENCES shop__product (id)');
        $this->addSql('ALTER TABLE shop__wishlist_item ADD CONSTRAINT FK_5BD5B5C0FB8E54CD FOREIGN KEY (wishlist_id) REFERENCES shop__wishlist (id)');
        $this->addSql('ALTER TABLE shop__wishlist DROP INDEX IDX_AB96E1DAA76ED395, ADD UNIQUE INDEX UNIQ_AB96E1DAA76ED395 (user_id)');
        $this->addSql('ALTER TABLE shop__wishlist DROP FOREIGN KEY FK_AB96E1DA4584665A');
        $this->addSql('DROP INDEX IDX_AB96E1DA4584665A ON shop__wishlist');
        $this->addSql('ALTER TABLE shop__wishlist DROP product_id, CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__wishlist_item DROP FOREIGN KEY FK_5BD5B5C04584665A');
        $this->addSql('ALTER TABLE shop__wishlist_item DROP FOREIGN KEY FK_5BD5B5C0FB8E54CD');
        $this->addSql('DROP TABLE shop__wishlist_item');
        $this->addSql('ALTER TABLE shop__wishlist DROP INDEX UNIQ_AB96E1DAA76ED395, ADD INDEX IDX_AB96E1DAA76ED395 (user_id)');
        $this->addSql('ALTER TABLE shop__wishlist ADD product_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shop__wishlist ADD CONSTRAINT FK_AB96E1DA4584665A FOREIGN KEY (product_id) REFERENCES shop__product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AB96E1DA4584665A ON shop__wishlist (product_id)');
    }
}
