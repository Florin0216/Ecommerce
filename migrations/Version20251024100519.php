<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251024100519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop__cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_9190A2FEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__cart_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, cart_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_C711691C4584665A (product_id), INDEX IDX_C711691C1AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__order (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_FAB35986A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, order_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_E3D619614584665A (product_id), INDEX IDX_E3D619618D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__payment (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_D87AD8FF4584665A (product_id), INDEX IDX_D87AD8FF12469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop__wishlist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_AB96E1DAA76ED395 (user_id), INDEX IDX_AB96E1DA4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop__cart ADD CONSTRAINT FK_9190A2FEA76ED395 FOREIGN KEY (user_id) REFERENCES user__user (id)');
        $this->addSql('ALTER TABLE shop__cart_item ADD CONSTRAINT FK_C711691C4584665A FOREIGN KEY (product_id) REFERENCES shop__product (id)');
        $this->addSql('ALTER TABLE shop__cart_item ADD CONSTRAINT FK_C711691C1AD5CDBF FOREIGN KEY (cart_id) REFERENCES shop__cart (id)');
        $this->addSql('ALTER TABLE shop__order ADD CONSTRAINT FK_FAB35986A76ED395 FOREIGN KEY (user_id) REFERENCES user__user (id)');
        $this->addSql('ALTER TABLE shop__order_item ADD CONSTRAINT FK_E3D619614584665A FOREIGN KEY (product_id) REFERENCES shop__product (id)');
        $this->addSql('ALTER TABLE shop__order_item ADD CONSTRAINT FK_E3D619618D9F6D38 FOREIGN KEY (order_id) REFERENCES shop__order (id)');
        $this->addSql('ALTER TABLE shop__product_category ADD CONSTRAINT FK_D87AD8FF4584665A FOREIGN KEY (product_id) REFERENCES shop__product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop__product_category ADD CONSTRAINT FK_D87AD8FF12469DE2 FOREIGN KEY (category_id) REFERENCES shop__category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop__wishlist ADD CONSTRAINT FK_AB96E1DAA76ED395 FOREIGN KEY (user_id) REFERENCES user__user (id)');
        $this->addSql('ALTER TABLE shop__wishlist ADD CONSTRAINT FK_AB96E1DA4584665A FOREIGN KEY (product_id) REFERENCES shop__product (id)');
        $this->addSql('ALTER TABLE shop__product DROP FOREIGN KEY FK_7CBA1F4612469DE2');
        $this->addSql('DROP INDEX IDX_7CBA1F4612469DE2 ON shop__product');
        $this->addSql('ALTER TABLE shop__product ADD summary VARCHAR(256) NOT NULL, ADD stock INT NOT NULL, ADD provider VARCHAR(128) NOT NULL, ADD delivery VARCHAR(128) NOT NULL, DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop__cart DROP FOREIGN KEY FK_9190A2FEA76ED395');
        $this->addSql('ALTER TABLE shop__cart_item DROP FOREIGN KEY FK_C711691C4584665A');
        $this->addSql('ALTER TABLE shop__cart_item DROP FOREIGN KEY FK_C711691C1AD5CDBF');
        $this->addSql('ALTER TABLE shop__order DROP FOREIGN KEY FK_FAB35986A76ED395');
        $this->addSql('ALTER TABLE shop__order_item DROP FOREIGN KEY FK_E3D619614584665A');
        $this->addSql('ALTER TABLE shop__order_item DROP FOREIGN KEY FK_E3D619618D9F6D38');
        $this->addSql('ALTER TABLE shop__product_category DROP FOREIGN KEY FK_D87AD8FF4584665A');
        $this->addSql('ALTER TABLE shop__product_category DROP FOREIGN KEY FK_D87AD8FF12469DE2');
        $this->addSql('ALTER TABLE shop__wishlist DROP FOREIGN KEY FK_AB96E1DAA76ED395');
        $this->addSql('ALTER TABLE shop__wishlist DROP FOREIGN KEY FK_AB96E1DA4584665A');
        $this->addSql('DROP TABLE shop__cart');
        $this->addSql('DROP TABLE shop__cart_item');
        $this->addSql('DROP TABLE shop__order');
        $this->addSql('DROP TABLE shop__order_item');
        $this->addSql('DROP TABLE shop__payment');
        $this->addSql('DROP TABLE shop__product_category');
        $this->addSql('DROP TABLE shop__wishlist');
        $this->addSql('ALTER TABLE shop__product ADD category_id INT DEFAULT NULL, DROP summary, DROP stock, DROP provider, DROP delivery');
        $this->addSql('ALTER TABLE shop__product ADD CONSTRAINT FK_7CBA1F4612469DE2 FOREIGN KEY (category_id) REFERENCES shop__category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7CBA1F4612469DE2 ON shop__product (category_id)');
    }
}
