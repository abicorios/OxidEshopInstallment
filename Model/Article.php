<?php

namespace abicorios\OxidEshopInstallment\Model;

/**
 * @see \OxidEsales\Eshop\Application\Model\Article
 */
class Article extends Article_parent
{
    public function getMonthlyInstallmentPrice()
    {
        $price = $this->oxarticles__oxprice->value;
        $prepayment = $this->oxarticles__abicorios_installment_prepayment->value;
        $months = $this->oxarticles__abicorios_installment_number_of_months->value;
        $monthlyInstallmentPrice = ($price - $prepayment) / $months;
        $monthlyInstallmentPrice = round($monthlyInstallmentPrice, 2);
        return $monthlyInstallmentPrice;
    }
}
