<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160506132449 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accuracy_measurement_range (accuracy_id INT NOT NULL, measurement_range_id INT NOT NULL, INDEX IDX_1BF55529A8A986A6 (accuracy_id), INDEX IDX_1BF5552919CFCD10 (measurement_range_id), PRIMARY KEY(accuracy_id, measurement_range_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eq_mode_measurement_range (eq_mode_id INT NOT NULL, measurement_range_id INT NOT NULL, INDEX IDX_67E8041D5513CB8A (eq_mode_id), INDEX IDX_67E8041D19CFCD10 (measurement_range_id), PRIMARY KEY(eq_mode_id, measurement_range_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE measurement_range (id INT AUTO_INCREMENT NOT NULL, theRange VARCHAR(20) NOT NULL, unit INT NOT NULL, UNIQUE INDEX UNIQ_8F98ADCF393C5E38 (theRange), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE units (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_E9B074495E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accuracy_measurement_range ADD CONSTRAINT FK_1BF55529A8A986A6 FOREIGN KEY (accuracy_id) REFERENCES accuracy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accuracy_measurement_range ADD CONSTRAINT FK_1BF5552919CFCD10 FOREIGN KEY (measurement_range_id) REFERENCES measurement_range (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eq_mode_measurement_range ADD CONSTRAINT FK_67E8041D5513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eq_mode_measurement_range ADD CONSTRAINT FK_67E8041D19CFCD10 FOREIGN KEY (measurement_range_id) REFERENCES measurement_range (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accuracy_measurement_range DROP FOREIGN KEY FK_1BF5552919CFCD10');
        $this->addSql('ALTER TABLE eq_mode_measurement_range DROP FOREIGN KEY FK_67E8041D19CFCD10');
        $this->addSql('DROP TABLE accuracy_measurement_range');
        $this->addSql('DROP TABLE eq_mode_measurement_range');
        $this->addSql('DROP TABLE measurement_range');
        $this->addSql('DROP TABLE units');
    }
}
