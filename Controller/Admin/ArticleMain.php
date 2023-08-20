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
        try {
            if ($prepayment > $price) {
                throw oxNew(\OxidEsales\Eshop\Core\Exception\ArticleInputException::class, 'ERROR_INSTALLMENT_PREPAYMENT_GREATER_THAN_PRICE');
            }
        } catch (\OxidEsales\Eshop\Core\Exception\ArticleInputException $oEx) {
            $oArticle->oxarticles__abicorios_installment_prepayment->setValue(0);
            $oArticle->save();
            \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($oEx);
        }
    }
}
