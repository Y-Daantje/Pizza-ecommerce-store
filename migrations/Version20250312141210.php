<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312141210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza CHANGE model_id model_id INT NOT NULL, CHANGE modal_info1 modal_info1 LONGTEXT DEFAULT NULL, CHANGE modal_info2 modal_info2 LONGTEXT DEFAULT NULL, CHANGE modal_info3 modal_info3 LONGTEXT DEFAULT NULL, CHANGE modal_info4 modal_info4 LONGTEXT DEFAULT NULL, CHANGE image2 image2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza CHANGE model_id model_id INT DEFAULT NULL, CHANGE modal_info1 modal_info1 LONGTEXT NOT NULL, CHANGE modal_info2 modal_info2 LONGTEXT NOT NULL, CHANGE modal_info3 modal_info3 LONGTEXT NOT NULL, CHANGE modal_info4 modal_info4 LONGTEXT NOT NULL, CHANGE image2 image2 VARCHAR(255) NOT NULL');
    }
}
