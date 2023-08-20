<?php

declare(strict_types=1);

namespace OxidEsales\abicorios\OxidEshopInstallment;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230819031800 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `oxarticles` ADD `ABICORIOS_INSTALLMENT_PREPAYMENT` DOUBLE UNSIGNED NOT NULL DEFAULT 0 COMMENT "Article prepayment"');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `oxarticles` DROP COLUMN `ABICORIOS_INSTALLMENT_PREPAYMENT`');
    }
}
