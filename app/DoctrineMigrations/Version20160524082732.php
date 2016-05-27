<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160524082732 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE valve_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, descr LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_44BC4D175E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valve_unit_process_connection (valve_unit_id INT NOT NULL, process_connection_id INT NOT NULL, INDEX IDX_DB09AA29F828BE6E (valve_unit_id), INDEX IDX_DB09AA295C64816E (process_connection_id), PRIMARY KEY(valve_unit_id, process_connection_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE valve_unit_process_connection ADD CONSTRAINT FK_DB09AA29F828BE6E FOREIGN KEY (valve_unit_id) REFERENCES valve_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE valve_unit_process_connection ADD CONSTRAINT FK_DB09AA295C64816E FOREIGN KEY (process_connection_id) REFERENCES process_connection (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE valve_unit_process_connection DROP FOREIGN KEY FK_DB09AA29F828BE6E');
        $this->addSql('DROP TABLE valve_unit');
        $this->addSql('DROP TABLE valve_unit_process_connection');
    }
}
