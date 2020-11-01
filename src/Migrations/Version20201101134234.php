<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201101134234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, candidate_name VARCHAR(255) NOT NULL, candidate_email VARCHAR(255) NOT NULL, candidate_phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_app (budget_id INT NOT NULL, app_id INT NOT NULL, INDEX IDX_6736884436ABA6B8 (budget_id), INDEX IDX_673688447987212D (app_id), PRIMARY KEY(budget_id, app_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_feature (budget_id INT NOT NULL, feature_id INT NOT NULL, INDEX IDX_DD543F8736ABA6B8 (budget_id), INDEX IDX_DD543F8760E4B879 (feature_id), PRIMARY KEY(budget_id, feature_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, app_id_id INT NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_1FD77566A997139A (app_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget_app ADD CONSTRAINT FK_6736884436ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_app ADD CONSTRAINT FK_673688447987212D FOREIGN KEY (app_id) REFERENCES app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_feature ADD CONSTRAINT FK_DD543F8736ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_feature ADD CONSTRAINT FK_DD543F8760E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD77566A997139A FOREIGN KEY (app_id_id) REFERENCES app (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_app DROP FOREIGN KEY FK_673688447987212D');
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD77566A997139A');
        $this->addSql('ALTER TABLE budget_app DROP FOREIGN KEY FK_6736884436ABA6B8');
        $this->addSql('ALTER TABLE budget_feature DROP FOREIGN KEY FK_DD543F8736ABA6B8');
        $this->addSql('ALTER TABLE budget_feature DROP FOREIGN KEY FK_DD543F8760E4B879');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE budget_app');
        $this->addSql('DROP TABLE budget_feature');
        $this->addSql('DROP TABLE feature');
    }
}
