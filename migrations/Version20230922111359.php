<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922111359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD localities_id INT NOT NULL, ADD roles_id INT NOT NULL, ADD avatars_id INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9C59FC1CE FOREIGN KEY (localities_id) REFERENCES localities (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E938C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9FA40957A FOREIGN KEY (avatars_id) REFERENCES avatars (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9C59FC1CE ON users (localities_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E938C751C4 ON users (roles_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9FA40957A ON users (avatars_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9C59FC1CE');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E938C751C4');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9FA40957A');
        $this->addSql('DROP INDEX IDX_1483A5E9C59FC1CE ON users');
        $this->addSql('DROP INDEX IDX_1483A5E938C751C4 ON users');
        $this->addSql('DROP INDEX IDX_1483A5E9FA40957A ON users');
        $this->addSql('ALTER TABLE users DROP localities_id, DROP roles_id, DROP avatars_id');
    }
}
