<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160526125442 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE brace (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, descr LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_DEFBB7835E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brace_process_connection (brace_id INT NOT NULL, process_connection_id INT NOT NULL, INDEX IDX_FD09832E4D973DC (brace_id), INDEX IDX_FD09832E5C64816E (process_connection_id), PRIMARY KEY(brace_id, process_connection_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brace_body_type (brace_id INT NOT NULL, body_type_id INT NOT NULL, INDEX IDX_EC0C25044D973DC (brace_id), INDEX IDX_EC0C25042CBA3505 (body_type_id), PRIMARY KEY(brace_id, body_type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brace_eq_mode (brace_id INT NOT NULL, eq_mode_id INT NOT NULL, INDEX IDX_8DEF987D4D973DC (brace_id), INDEX IDX_8DEF987D5513CB8A (eq_mode_id), PRIMARY KEY(brace_id, eq_mode_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brace_process_connection ADD CONSTRAINT FK_FD09832E4D973DC FOREIGN KEY (brace_id) REFERENCES brace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brace_process_connection ADD CONSTRAINT FK_FD09832E5C64816E FOREIGN KEY (process_connection_id) REFERENCES process_connection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brace_body_type ADD CONSTRAINT FK_EC0C25044D973DC FOREIGN KEY (brace_id) REFERENCES brace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brace_body_type ADD CONSTRAINT FK_EC0C25042CBA3505 FOREIGN KEY (body_type_id) REFERENCES body_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brace_eq_mode ADD CONSTRAINT FK_8DEF987D4D973DC FOREIGN KEY (brace_id) REFERENCES brace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brace_eq_mode ADD CONSTRAINT FK_8DEF987D5513CB8A FOREIGN KEY (eq_mode_id) REFERENCES eq_mode (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE brace_process_connection DROP FOREIGN KEY FK_FD09832E4D973DC');
        $this->addSql('ALTER TABLE brace_body_type DROP FOREIGN KEY FK_EC0C25044D973DC');
        $this->addSql('ALTER TABLE brace_eq_mode DROP FOREIGN KEY FK_8DEF987D4D973DC');
        $this->addSql('DROP TABLE brace');
        $this->addSql('DROP TABLE brace_process_connection');
        $this->addSql('DROP TABLE brace_body_type');
        $this->addSql('DROP TABLE brace_eq_mode');
    }
}
