<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260821124745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(63) NOT NULL, link VARCHAR(255) DEFAULT NULL, priority SMALLINT NOT NULL, enabled TINYINT NOT NULL, image VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE talk (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, source VARCHAR(63) NOT NULL, date DATE NOT NULL, link VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE testimony ADD firstname VARCHAR(31) NOT NULL, ADD age SMALLINT DEFAULT NULL, ADD promo_nb VARCHAR(31) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');

        $this->addSql('UPDATE testimony SET age = substr(regexp_substr(name, \'[0-9]* ans\'), 1, 2) WHERE substr(regexp_substr(name, \'[0-9]* ans\'), 1, 2) != \'\'');
        $this->addSql('UPDATE testimony SET promo_nb = substr(regexp_substr(name, \'- .*\'), 3)');
        $this->addSql('UPDATE testimony SET firstname = SUBSTRING(name, 1, CHAR_LENGTH(regexp_substr(name, CONCAT(\'.*, \', age))) - 4) WHERE age > 0');

        $this->addSql('ALTER TABLE article ADD start DATE DEFAULT NULL, ADD end DATE DEFAULT NULL, ADD location VARCHAR(127) DEFAULT NULL, ADD start_time TIME DEFAULT NULL, ADD button_label VARCHAR(63) NOT NULL, ADD button_link VARCHAR(255) NOT NULL, ADD tag VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE talk');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE available_at available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE testimony DROP firstname, DROP age, DROP promo_nb');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');

        $this->addSql('ALTER TABLE article DROP start, DROP end, DROP location, DROP start_time, DROP button_label, DROP button_link, DROP tag');
    }
}
