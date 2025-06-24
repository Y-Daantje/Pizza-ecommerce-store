<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320080606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pizza_purchase (id INT AUTO_INCREMENT NOT NULL, pizza_id INT NOT NULL, purchase_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_F7B9966DD41D1D42 (pizza_id), INDEX IDX_F7B9966D558FBEB9 (purchase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pizza_purchase ADD CONSTRAINT FK_F7B9966DD41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizza (id)');
        $this->addSql('ALTER TABLE pizza_purchase ADD CONSTRAINT FK_F7B9966D558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza_purchase DROP FOREIGN KEY FK_F7B9966DD41D1D42');
        $this->addSql('ALTER TABLE pizza_purchase DROP FOREIGN KEY FK_F7B9966D558FBEB9');
        $this->addSql('DROP TABLE pizza_purchase');
    }
}
