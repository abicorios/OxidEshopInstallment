[{$smarty.block.parent}]
<tr>
    <td class="edittext">
        [{oxmultilang ident="ABICORIOS_INSTALLMENT_PREPAYMENT"}]  ([{$oActCur->sign}])
    </td>
    <td class="edittext">
        <input type="text" class="editinput" size="32" maxlength="[{$edit->oxarticles__abicorios_installment_prepayment->fldmax_length}]" name="editval[oxarticles__abicorios_installment_prepayment]" value="[{$edit->oxarticles__abicorios_installment_prepayment->value}]" [{$readonly}]>
    </td>
</tr>
