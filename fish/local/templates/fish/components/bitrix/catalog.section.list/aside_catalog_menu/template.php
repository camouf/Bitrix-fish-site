<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="catalog_menu">
    <h4><a href="/catalog/">Каталог</a></h4>
    <?
    $TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
    $CURRENT_DEPTH = $TOP_DEPTH;
    foreach ($arResult["SECTIONS"] as $arSection):
    if ($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"])
        echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH), "<ul>";
    elseif ($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"])
        echo "</li>";
    else {
        while ($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"]) {
            echo "</li>";
            echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</ul>", "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH - 1);
            $CURRENT_DEPTH--;
        }
        echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</li>";
    }
    echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH);
    ?>



    <?if ($arSection['DEPTH_LEVEL'] == 1) { ?>

        <li class="first_level">
            <a href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                <?= $arSection["NAME"] ?>
                <span><?= $arSection["ELEMENT_CNT"] ?></span>
            </a>

    <?} elseif ($arSection['DEPTH_LEVEL'] == 2) {?>

        <li class="second_level">
            <a href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                <?= $arSection["NAME"] ?>
                <?if (strlen($arSection['PICTURE']['SRC']) !== 0) {?>
                    <img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?=$arSection['NAME']?>">
                <?} else {?>
                    <img src="/local/images/nofoto.png" alt="">
                <?} ?>
            </a>

    <? }else{?>

        <li class="tree_level">
            <a href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                <?= $arSection["NAME"] ?>
                <span><?= $arSection["ELEMENT_CNT"] ?></span>
            </a>

    <?}?>





        <?
        $CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
        endforeach;

        while ($CURRENT_DEPTH > $TOP_DEPTH) {
            echo "</li>";
            echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</ul>", "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH - 1);
            $CURRENT_DEPTH--;
        }
        ?>
</div>