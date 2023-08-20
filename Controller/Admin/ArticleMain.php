<?php

namespace abicorios\OxidEshopInstallment\Controller\Admin;

/**
 * @see \OxidEsales\Eshop\Application\Controller\Admin\ArticleMain
 */
class ArticleMain extends ArticleMain_parent
{
    public function save()
    {
        parent::save();
        $oConfig = $this->getConfig();
        $aParams = $oConfig->getRequestParameter('editval');
        $oArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $oArticle->load($aParams['oxarticles__oxid']);
        $prepayment = $oArticle->oxarticles__abicorios_installment_prepayment->value;
        $price = $oArticle->oxarticles__oxprice->value;
        if ($prepayment > $price) {
            $oArticle->oxarticles__abicorios_installment_prepayment->setValue(0);
            $oArticle->oxarticles__abicorios_installment_number_of_months->setValue(0);
            $oArticle->save();
        }
    }
}
