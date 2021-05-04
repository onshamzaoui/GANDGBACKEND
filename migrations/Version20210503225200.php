<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210503225200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commercial_agent (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, issue VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (product_id INT NOT NULL, technician_id INT NOT NULL, issue_id INT NOT NULL, repair_date DATETIME NOT NULL, expected_maintenance_cost DOUBLE PRECISION NOT NULL, INDEX IDX_2F84F8E94584665A (product_id), INDEX IDX_2F84F8E9E6C5D496 (technician_id), INDEX IDX_2F84F8E95E7AA58C (issue_id), PRIMARY KEY(product_id, technician_id, issue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF60E67CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, client_id INT DEFAULT NULL, category_id INT NOT NULL, product_name VARCHAR(255) NOT NULL, product_image VARCHAR(255) NOT NULL, description TINYTEXT NOT NULL, initial_price DOUBLE PRECISION NOT NULL, selling_price DOUBLE PRECISION DEFAULT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD7E3C61F9 (owner_id), UNIQUE INDEX UNIQ_D34A04AD19EB6921 (client_id), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technician (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validation (commercial_agent_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_16AC5B6E8810634A (commercial_agent_id), INDEX IDX_16AC5B6E4584665A (product_id), PRIMARY KEY(commercial_agent_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9E6C5D496 FOREIGN KEY (technician_id) REFERENCES technician (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E95E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E8810634A FOREIGN KEY (commercial_agent_id) REFERENCES commercial_agent (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD19EB6921');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E8810634A');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E95E7AA58C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7E3C61F9');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E94584665A');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E4584665A');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9E6C5D496');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commercial_agent');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE technician');
        $this->addSql('DROP TABLE validation');
    }
}
