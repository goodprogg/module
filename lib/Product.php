<?php

namespace Doors\MyCommerce;

use Bitrix\Iblock\ElementTable;
use CFile;
use My;

class Product
{

	public function showProductDetailImage($productId)
	{
		$arProduct = ElementTable::getList([
			'filter' => ['ID' => $productId],
			'select' => ['DETAIL_PICTURE'],
		])->fetch();

		if ($arProduct && !empty($arProduct['DETAIL_PICTURE'])) {
			$arDetailPicture = CFile::GetFileArray($arProduct['DETAIL_PICTURE']);
			if ($arDetailPicture) {
				// URL детальной картинки товара
				$detailPictureURL = $arDetailPicture['SRC'];
				return '<img src="' . $detailPictureURL . '" alt="Детальная картинка товара" width="100px">';
			}
		}
		return '';
	}

    public function showProductName($productId)
    {
        $arProduct = ElementTable::getList([
            'filter' => ['ID' => $productId],
            'select' => ['ID', 'NAME', 'CODE'],
        ])->fetch();

        if ($arProduct && !empty($arProduct['NAME'])) {
            $detailPageURL = '/catalog/' . $arProduct['CODE'] . '/';
            return '<a href="' . $detailPageURL . '">' . $arProduct['NAME'] . '</a>';
        }

        return '';
    }



    public function getRetailProductPrice($productId)
	{
		$catalogGroupId = $this->getCatalogGroupId();
		$allProductPrices = \Bitrix\Catalog\PriceTable::getList([
			"select" => ["PRICE"],
			"filter" => [
				"PRODUCT_ID" => $productId,
				"CATALOG_GROUP_ID" => $catalogGroupId
			]
		])->fetch();

		return (float) $allProductPrices['PRICE'];
	}

    public function getAllProductPrice($productId, $groupCatalog)
    {
        $allProductPrices = \Bitrix\Catalog\PriceTable::getList([
            "select" => ["*"],
            "filter" => [
                "PRODUCT_ID" => $productId,
                "CATALOG_GROUP_ID" => $groupCatalog
            ]
        ])->fetch();

        return (float) $allProductPrices['PRICE'];
    }

	public function getCatalogGroupId()
	{
		return (int) \Bitrix\Main\Config\Option::get("doors.mycommerce", "catalog_group_id", 13); // Здесь 13 - значение по умолчанию
	}

	public function getProductQRcode($order)
	{
		return My::getOrderPropertyByCode($order->getPropertyCollection(), 'ORDER_QR')->getValue();
	}

	public function setProductQRcode($order,$qr_value)
    {
        $propertyCollection = $order->getPropertyCollection();

        $new_prop = My::getOrderPropertyByCode($propertyCollection, 'ORDER_QR');

        // Установка
        $new_prop->setValue($qr_value);

        //Удаление
        // $new_prop->delete();
    }
}