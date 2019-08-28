<?php

class Goods
{
	public static function setGoods($goodsList)
	{
		$db = Db::getConnection();
		$report = [];

		$sqlInsertGoods = 'INSERT INTO goods (id, name) VALUES (:id, :name) ON DUPLICATE KEY UPDATE name = :name';
		$resultInsertGoods = $db->prepare($sqlInsertGoods);

		$sqlInsertGoodsGroup = 'INSERT INTO goods_group (id_goods, id_group) VALUES (:id_goods, :id_group) ON DUPLICATE KEY UPDATE id_group = :id_group';
		$resultInsertGoodsGroup = $db->prepare($sqlInsertGoodsGroup);

		foreach ($goodsList as $goods) {
			$resultInsertGoods->bindValue(':id', $goods['ID'], PDO::PARAM_STR);
			$resultInsertGoods->bindValue(':name', $goods['NAME'], PDO::PARAM_STR);
			if(is_array($goods['ID_GROUP'])){
				foreach ($goods['ID_GROUP'] as $groupItem)
				{
					//добавляем несколько записей товар - группа в таблицу goods_group
					$resultInsertGoodsGroup->bindValue(':id_goods', $goods['ID'], PDO::PARAM_STR);
					$resultInsertGoodsGroup->bindValue(':id_group', $groupItem, PDO::PARAM_STR);
					$report[] = $resultInsertGoodsGroup->execute();
				}
			} else {
				// добавляем одну запись товар - группа в таблицу goods_group
				$resultInsertGoodsGroup->bindValue(':id_goods', $goods['ID'], PDO::PARAM_STR);
				$resultInsertGoodsGroup->bindValue(':id_group', $goods['ID_GROUP'], PDO::PARAM_STR);
				$report[] = $resultInsertGoodsGroup->execute();
			}
			$report[] = $resultInsertGoods->execute();
		}
		return $report;
	}

	public static function setGoodsProperties($goodsList)
	{
		$db = Db::getConnection();
		$report = [];

		$sql = 'INSERT INTO goods_properties (id_goods, id_property, id_property_value)
 				VALUES (:id_goods, :id_property, :id_property_value)
 				ON DUPLICATE KEY UPDATE id_property_value = :id_property_value';

		$result = $db->prepare($sql);

		foreach ($goodsList as $goods) {
			$result->bindValue(':id_goods', $goods['ID'], PDO::PARAM_STR);
			foreach ($goods['PROP'] as $goodsProperty) {
				$result->bindValue(':id_property', $goodsProperty['ID_PROP'], PDO::PARAM_STR);
				if (!is_array($goodsProperty['VALUE'])) {
					$result->bindValue(':id_property_value', $goodsProperty['VALUE'], PDO::PARAM_STR);
					$report[] = $result->execute();
				}
			}
		}
		return $report;
	}

	public static function setGoodsPhoto($goodsList)
	{
		$db = Db::getConnection();
		$report = [];

		$sql = 'INSERT INTO goods_photo (id_goods, path_photo)
 				VALUES (:id_goods, :path_photo)
 				ON DUPLICATE KEY UPDATE path_photo = :path_photo';

		$result = $db->prepare($sql);

		foreach ($goodsList as $goods) {
			if (isset($goods['IMAGE'])) {
				$result->bindValue(':id_goods', $goods['ID'], PDO::PARAM_STR);
				foreach ($goods['IMAGE'] as $goodsProperty) {
					$result->bindValue(':path_photo', $goodsProperty, PDO::PARAM_STR);
					$report[] = $result->execute();
				}
			}
		}
		return $report;
	}

	public static function getGoods($group)
	{
		$propertyName = include(ROOT . '/config/propertyName.php');
		$productByGroup = [];

		$db = Db::getConnection();
		if ($group == 'all') {
			$sql = 'SELECT goods.id, goods.name, goods_properties.id_property_value, properties.name AS property_name, properties_value.value AS property_value
				FROM goods
				LEFT JOIN goods_properties ON goods.id = goods_properties.id_goods
				LEFT JOIN properties ON goods_properties.id_property = properties.id
				LEFT JOIN properties_value ON goods_properties.id_property_value = properties_value.id';
		} else {
			$sql = 'SELECT goods.id, goods.name, goods_properties.id_property_value, properties.name AS property_name, properties_value.value AS property_value
				FROM goods
				LEFT JOIN goods_group ON goods_group.id_goods = goods.id
                LEFT JOIN groups ON groups.id = goods_group.id_group
                LEFT JOIN goods_properties ON goods.id = goods_properties.id_goods
				LEFT JOIN properties ON goods_properties.id_property = properties.id
				LEFT JOIN properties_value ON goods_properties.id_property_value = properties_value.id
				WHERE groups.alias=' . "'" . $group . "'";
		}

		$result = $db->query($sql, PDO::FETCH_ASSOC);

		while ($row = $result->fetch()) {

			if ($row['property_value']) {
				$property_value = $row['property_value'];
			} else {
				$property_value = $row['id_property_value'];
			}

			$productByGroup[$row['id']]["GOODS"] = [
					"ID" => $row['id'],
					"NAME" => $row['name'],
			];

			foreach ($propertyName as $key => $item) {
				if (!isset($productByGroup[$row['id']]["PROPERTY"][$key])) {
					$productByGroup[$row['id']]["PROPERTY"][$key]["PROPERTY_NAME"] = '';
					$productByGroup[$row['id']]["PROPERTY"][$key]["PROPERTY_VALUE"] = '';
				}
			}

			foreach ($propertyName as $key => $item) {
				if ($row['property_name'] == $item) {
					$productByGroup[$row['id']]["PROPERTY"][$key]["PROPERTY_NAME"] = $row['property_name'];
					$productByGroup[$row['id']]["PROPERTY"][$key]["PROPERTY_VALUE"] = $property_value;
				}
			}
		}

		return $productByGroup;
	}
}