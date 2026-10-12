<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261012141601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimony CHANGE age age SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE talk ADD tag VARCHAR(255) NOT NULL, ADD duration SMALLINT NOT NULL, CHANGE link link VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE talk DROP tag, DROP duration, CHANGE link link VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE testimony CHANGE age age SMALLINT DEFAULT NULL');
    }
}
