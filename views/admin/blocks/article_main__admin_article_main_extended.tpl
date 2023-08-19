[{$smarty.block.parent}]
<tr>
    <td class="edittext">
        [{oxmultilang ident="ABICORIOS_INSTALLMENT_PREPAYMENT"}]  ([{$oActCur->sign}])
    </td>
    <td class="edittext">
        <input type="text" class="editinput" size="32" maxlength="[{$edit->oxarticles__abicorios_installment_prepayment->fldmax_length}]" name="editval[oxarticles__abicorios_installment_prepayment]" value="[{$edit->oxarticles__abicorios_installment_prepayment->value}]" [{$readonly}]>
    </td>
</tr>
<tr>
    <td class="edittext">
        [{oxmultilang ident="ABICORIOS_INSTALLMENT_NUMBER_OF_MONTHS"}]
    </td>
    <td>
        <input type="text" class="editinput" size="28" maxlength="[{$edit->oxarticles__abicorios_installment_number_of_months->fldmax_length}]" name="editval[oxarticles__abicorios_installment_number_of_months]" value="[{$edit->oxarticles__abicorios_installment_number_of_months->value}]" [{$readonly}]>
        [{oxinputhelp ident="HELP_ABICORIOS_INSTALLMENT_NUMBER_OF_MONTHS"}]
    </td>
</tr>
