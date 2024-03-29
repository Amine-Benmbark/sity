<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730151204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie CHANGE name name VARCHAR(20) NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE commande ADD name VARCHAR(30) NOT NULL, ADD prix DOUBLE PRECISION NOT NULL, ADD total DOUBLE PRECISION NOT NULL, CHANGE quantite quantity INT NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE name name VARCHAR(20) NOT NULL COLLATE `utf8_general_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8_general_ci`, CHANGE img img VARCHAR(255) NOT NULL COLLATE `utf8_general_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie CHANGE name name VARCHAR(20) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`');
        $this->addSql('ALTER TABLE commande DROP name, DROP prix, DROP total, CHANGE quantity quantite INT NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE name name VARCHAR(20) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, CHANGE img img VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`');
    }
}
