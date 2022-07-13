<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427114534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE train_fault_event (train_fault_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_4666C071434E7D52 (train_fault_id), INDEX IDX_4666C07171F7E88B (event_id), PRIMARY KEY(train_fault_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE train_fault_event ADD CONSTRAINT FK_4666C071434E7D52 FOREIGN KEY (train_fault_id) REFERENCES trainFaults (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE train_fault_event ADD CONSTRAINT FK_4666C07171F7E88B FOREIGN KEY (event_id) REFERENCES events (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE train_fault_event');
    }
}
