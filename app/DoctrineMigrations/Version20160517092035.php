<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160517092035 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eq_mode_process_connection (eq_mode_id INT NOT NULL, process_connection_id INT NOT NULL, INDEX IDX_EF89933F5513CB8A (eq_mode_id), INDEX IDX_EF89933F5C64816E (process_connection_id), PRIMARY KEY(eq_mode_id, process_connection_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process_connection (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, descr LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_87BC506E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE special_version_processconnection (special_version_id INT NOT NULL, processconnection_id INT NOT NULL, INDEX IDX_EBC33AD4AFDC03B5 (special_version_id), INDEX IDX_EBC33AD43D350899 (processconnection_id), PRIMARY KEY(special_version_id, processconnection_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eq_mode_process_connection ADD CONSTRAINT FK_EF89933F5513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eq_mode_process_connection ADD CONSTRAINT FK_EF89933F5C64816E FOREIGN KEY (process_connection_id) REFERENCES process_connection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE special_version_processconnection ADD CONSTRAINT FK_EBC33AD4AFDC03B5 FOREIGN KEY (special_version_id) REFERENCES special_version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE special_version_processconnection ADD CONSTRAINT FK_EBC33AD43D350899 FOREIGN KEY (processconnection_id) REFERENCES process_connection (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eq_mode_process_connection DROP FOREIGN KEY FK_EF89933F5C64816E');
        $this->addSql('ALTER TABLE special_version_processconnection DROP FOREIGN KEY FK_EBC33AD43D350899');
        $this->addSql('DROP TABLE eq_mode_process_connection');
        $this->addSql('DROP TABLE process_connection');
        $this->addSql('DROP TABLE special_version_processconnection');
    }
}
