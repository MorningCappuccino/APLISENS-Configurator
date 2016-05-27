<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160524090846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE welded_element (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, descr LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E6FBB28D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE welded_element_process_connection (welded_element_id INT NOT NULL, process_connection_id INT NOT NULL, INDEX IDX_F852EF37330AAAB (welded_element_id), INDEX IDX_F852EF35C64816E (process_connection_id), PRIMARY KEY(welded_element_id, process_connection_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE welded_element_process_connection ADD CONSTRAINT FK_F852EF37330AAAB FOREIGN KEY (welded_element_id) REFERENCES welded_element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE welded_element_process_connection ADD CONSTRAINT FK_F852EF35C64816E FOREIGN KEY (process_connection_id) REFERENCES process_connection (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE welded_element_process_connection DROP FOREIGN KEY FK_F852EF37330AAAB');
        $this->addSql('DROP TABLE welded_element');
        $this->addSql('DROP TABLE welded_element_process_connection');
    }
}
