<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126124802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_workout_plan (user_id INT NOT NULL, workout_plan_id INT NOT NULL, INDEX IDX_25182403A76ED395 (user_id), INDEX IDX_25182403945F6E33 (workout_plan_id), PRIMARY KEY(user_id, workout_plan_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_workout_plan ADD CONSTRAINT FK_25182403A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_workout_plan ADD CONSTRAINT FK_25182403945F6E33 FOREIGN KEY (workout_plan_id) REFERENCES workout_plan (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_workout_plan DROP FOREIGN KEY FK_25182403A76ED395');
        $this->addSql('ALTER TABLE user_workout_plan DROP FOREIGN KEY FK_25182403945F6E33');
        $this->addSql('DROP TABLE user_workout_plan');
    }
}
