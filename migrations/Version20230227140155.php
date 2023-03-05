<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227140155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cancion (id INT AUTO_INCREMENT NOT NULL, cantante_id INT NOT NULL, disco_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, genero VARCHAR(255) DEFAULT NULL, duracion TIME DEFAULT NULL, reproducciones INT NOT NULL, INDEX IDX_E4620FA0A6BA9FA0 (cantante_id), INDEX IDX_E4620FA086CCF19B (disco_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cantante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_nacimiento DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disco (id INT AUTO_INCREMENT NOT NULL, cantante_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, fecha_lanzamiento DATE DEFAULT NULL, INDEX IDX_29D40CBDA6BA9FA0 (cantante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT FK_E4620FA0A6BA9FA0 FOREIGN KEY (cantante_id) REFERENCES cantante (id)');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT FK_E4620FA086CCF19B FOREIGN KEY (disco_id) REFERENCES disco (id)');
        $this->addSql('ALTER TABLE disco ADD CONSTRAINT FK_29D40CBDA6BA9FA0 FOREIGN KEY (cantante_id) REFERENCES cantante (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY FK_E4620FA0A6BA9FA0');
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY FK_E4620FA086CCF19B');
        $this->addSql('ALTER TABLE disco DROP FOREIGN KEY FK_29D40CBDA6BA9FA0');
        $this->addSql('DROP TABLE cancion');
        $this->addSql('DROP TABLE cantante');
        $this->addSql('DROP TABLE disco');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
