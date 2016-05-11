<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160506141726 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE measurement_range CHANGE unit unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE measurement_range ADD CONSTRAINT FK_8F98ADCFF8BD700D FOREIGN KEY (unit_id) REFERENCES units (id)');
        $this->addSql('CREATE INDEX IDX_8F98ADCFF8BD700D ON measurement_range (unit_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE measurement_range DROP FOREIGN KEY FK_8F98ADCFF8BD700D');
        $this->addSql('DROP INDEX IDX_8F98ADCFF8BD700D ON measurement_range');
        $this->addSql('ALTER TABLE measurement_range CHANGE unit_id unit INT NOT NULL');
    }
}
