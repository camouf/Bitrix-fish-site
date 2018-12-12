<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$templateFolder = &$this->GetFolder();
$APPLICATION->AddHeadScript($templateFolder."/js/jquery.form.js" );
$APPLICATION->AddHeadScript($templateFolder."/js/jquery.jgrowl.min.js" );
?>
<script>
   $(document).ready(
      function()
      {
         var options = {
         url: '<?=$templateFolder?>/ajax/add2basket.php?RND='+Math.random(),
         type: "POST",
         target: '#basket-container',
         success:
            function(responseText) {
               $.jGrowl("Товар добавлен в заказ");
            }
         };
         $(".add_form").ajaxForm(options);
      }
   );
</script>
<? 
function getNumEnding($number, $endingArray) 
    { 
    $number = $number % 100; 
    if ($number>=11 && $number<=19) 
        { 
            $ending=$endingArray[2]; 
        } else { 
        $i = $number % 10; 
        switch ($i) { 
                case (1): $ending = $endingArray[0]; break; 
                case (2): case (3): case (4): $ending = $endingArray[1]; break; 
                default: $ending=$endingArray[2]; } 
                } 
        return $ending; 
    } 
?> 
<?$defaultCurr = CSaleLang::GetLangCurrency(SITE_ID); ?> 
<? 
    $quant='0';$price='0'; 
    foreach ($arResult["ITEMS"] as $v) 
        { 
        if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y") 
            {
            $quant=$quant+$v["QUANTITY"]; 
            $pr=$v["QUANTITY"]*$v["PRICE"]; 
            $price=$price+$pr; 
            } 
        } 
if($quant==0){?>
<a href="/catalog/" rel="nofollow" class="wish_bask">
    <b>В корзине</b>
    <i>0 тов.</i>
</a>
<?}else{?> 
<a href="/personal/cart/" rel="nofollow" class="wish_bask">
    <b>В корзине</b>
    <i>
        <?=$quant?> на <? echo SaleFormatCurrency($price, $defaultCurr); ?>
    </i>
</a>
<?}?> 
