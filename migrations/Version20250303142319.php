<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303142319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza ADD modal_info1 LONGTEXT NOT NULL, ADD modal_info2 LONGTEXT NOT NULL, ADD modal_info3 LONGTEXT NOT NULL, ADD modal_info4 LONGTEXT NOT NULL, CHANGE model_info model_info VARCHAR(4000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza DROP modal_info1, DROP modal_info2, DROP modal_info3, DROP modal_info4, CHANGE model_info model_info LONGTEXT NOT NULL');
    }
}
