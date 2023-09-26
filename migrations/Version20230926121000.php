<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926121000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configuration_payfip (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, numcli VARCHAR(6) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, option_select_ref INT DEFAULT NULL, option_select_montant INT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creance (id INT AUTO_INCREMENT NOT NULL, configuration_payfip_id INT NOT NULL, reference VARCHAR(255) NOT NULL, montant INT NOT NULL, email VARCHAR(255) DEFAULT NULL, exer VARCHAR(4) DEFAULT NULL, urlnotif VARCHAR(249) DEFAULT NULL, urlredirect VARCHAR(249) DEFAULT NULL, resultrans VARCHAR(1) DEFAULT NULL, numauto VARCHAR(16) DEFAULT NULL, dattrans DATE DEFAULT NULL, idop VARCHAR(36) DEFAULT NULL, heur_trans DATETIME DEFAULT NULL, log_erreur VARCHAR(255) DEFAULT NULL, objet VARCHAR(50) DEFAULT NULL, saisie VARCHAR(1) DEFAULT NULL, reference_denvoie VARCHAR(255) DEFAULT NULL, date_import DATE DEFAULT NULL, statut INT DEFAULT NULL, INDEX IDX_82D1060E41AF8B38 (configuration_payfip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE import (id INT AUTO_INCREMENT NOT NULL, configuration_payfip_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_import DATE NOT NULL, option_select_ref INT DEFAULT NULL, option_select_montant INT DEFAULT NULL, INDEX IDX_9D4ECE1D41AF8B38 (configuration_payfip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_erreur (id INT AUTO_INCREMENT NOT NULL, log_erreur VARCHAR(255) DEFAULT NULL, exer VARCHAR(4) DEFAULT NULL, resultrans VARCHAR(1) DEFAULT NULL, numauto VARCHAR(16) DEFAULT NULL, dat_trans DATE DEFAULT NULL, heur_trans DATETIME DEFAULT NULL, montant INT DEFAULT NULL, idop VARCHAR(36) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, creance_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creance ADD CONSTRAINT FK_82D1060E41AF8B38 FOREIGN KEY (configuration_payfip_id) REFERENCES configuration_payfip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE import ADD CONSTRAINT FK_9D4ECE1D41AF8B38 FOREIGN KEY (configuration_payfip_id) REFERENCES configuration_payfip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creance DROP FOREIGN KEY FK_82D1060E41AF8B38');
        $this->addSql('ALTER TABLE import DROP FOREIGN KEY FK_9D4ECE1D41AF8B38');
        $this->addSql('DROP TABLE configuration_payfip');
        $this->addSql('DROP TABLE creance');
        $this->addSql('DROP TABLE import');
        $this->addSql('DROP TABLE log_erreur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
