<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925142226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creance DROP FOREIGN KEY FK_82D1060E7CDAA279');
        $this->addSql('DROP INDEX IDX_82D1060E7CDAA279 ON creance');
        $this->addSql('ALTER TABLE creance CHANGE configuration_pay_fip_id configuration_payfip_id INT NOT NULL, CHANGE object objet VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE creance ADD CONSTRAINT FK_82D1060E41AF8B38 FOREIGN KEY (configuration_payfip_id) REFERENCES configuration_payfip (id)');
        $this->addSql('CREATE INDEX IDX_82D1060E41AF8B38 ON creance (configuration_payfip_id)');
        $this->addSql('ALTER TABLE log_erreur ADD creance_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creance DROP FOREIGN KEY FK_82D1060E41AF8B38');
        $this->addSql('DROP INDEX IDX_82D1060E41AF8B38 ON creance');
        $this->addSql('ALTER TABLE creance CHANGE configuration_payfip_id configuration_pay_fip_id INT NOT NULL, CHANGE objet object VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE creance ADD CONSTRAINT FK_82D1060E7CDAA279 FOREIGN KEY (configuration_pay_fip_id) REFERENCES configuration_payfip (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_82D1060E7CDAA279 ON creance (configuration_pay_fip_id)');
        $this->addSql('ALTER TABLE log_erreur DROP creance_id');
    }
}
