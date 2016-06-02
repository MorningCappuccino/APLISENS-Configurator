<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160525125728 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE welded_element_valve_unit (welded_element_id INT NOT NULL, valve_unit_id INT NOT NULL, INDEX IDX_409DEF527330AAAB (welded_element_id), INDEX IDX_409DEF52F828BE6E (valve_unit_id), PRIMARY KEY(welded_element_id, valve_unit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE welded_element_eq_mode (welded_element_id INT NOT NULL, eq_mode_id INT NOT NULL, INDEX IDX_5B0C56AF7330AAAB (welded_element_id), INDEX IDX_5B0C56AF5513CB8A (eq_mode_id), PRIMARY KEY(welded_element_id, eq_mode_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE welded_element_valve_unit ADD CONSTRAINT FK_409DEF527330AAAB FOREIGN KEY (welded_element_id) REFERENCES welded_element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE welded_element_valve_unit ADD CONSTRAINT FK_409DEF52F828BE6E FOREIGN KEY (valve_unit_id) REFERENCES valve_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE welded_element_eq_mode ADD CONSTRAINT FK_5B0C56AF7330AAAB FOREIGN KEY (welded_element_id) REFERENCES welded_element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE welded_element_eq_mode ADD CONSTRAINT FK_5B0C56AF5513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE welded_element_valve_unit');
        $this->addSql('DROP TABLE welded_element_eq_mode');
    }
}
