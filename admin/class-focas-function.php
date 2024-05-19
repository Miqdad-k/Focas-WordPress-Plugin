<?php 


//class

class Product
{
	var $Id;
	var $ProductName;
	var $Pic;
	var $FocusProduct;
}

class FocasProduct
{
	var $Id;
	var $Barcode;
	var $SalePrice;
	var $ProductId;
	var $Quantity;
}

function FocasDateFormatted($utc_datetime)
{
	$utc = new DateTime($utc_datetime, new DateTimeZone('UTC'));
	$local = $utc;
	$local->setTimezone(new DateTimeZone(FocasGetTimeZone()));
	return $local->format('Y-m-d h:i:s');
}
function FocasDateFormattedUtc($datetime)
{
	$local = new DateTime($datetime, new DateTimeZone(FocasGetTimeZone()));
	$utc = $local;
	$utc->setTimezone(new DateTimeZone('UTC'));
	return $utc->format('Y-m-d h:i:s');
}

//Functions 
function FocasGetAllProducts()
{ 	global $wpdb;
	$posts = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type='product' and post_status ='publish' ORDER BY post_date DESC");
	$products = array();
	$count=0;
	foreach($posts as $item)
	{
		$productattachment = FocasGetProductAttachment($item->ID);
		$product = new product;
		$product->Id = $item->ID;
		$product->ProductName = $item->post_title;

		if(Count($productattachment) > 0)
			$product->Pic = $productattachment[0]->guid;
		else
			$product->Pic ="http://msqrsols.com/wp-content/uploads/2023/01/Focas.png";

		$focasProduct = new FocasProduct();
		$avaliableProduct = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Product` WHERE ProductId=' ".$product->Id ."'");
		$qty=FocasGetQuantity($product->Id);
		if(Count($avaliableProduct) > 0)
		{
			$focasProduct->Id =$avaliableProduct[0]->Id;
			$focasProduct->Barcode =$avaliableProduct[0]->Barcode;
			$focasProduct->SalePrice=$avaliableProduct[0]->SalePrice;
			$focasProduct->Quantity=$qty[0]->AvailableQty;
		}
		else
		{
			$focasProduct->Barcode ='';
			$focasProduct->SalePrice="0";
			$focasProduct->Quantity=$qty[0]->AvailableQty;
		}
		$product->FocusProduct=$focasProduct;
		
		$products[$count]=$product;
		$count++;
	}
	return $products;
}

function FocasGetProductAttachment($id)
{
	global $wpdb;
	$productattachment = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type='attachment' AND post_parent=$id");
	return $productattachment;
}

function FocasGetQuantity($id)
{
	global $wpdb;
	$Quantity = $wpdb->get_results( "SELECT (SELECT COALESCE(SUM(QuantityIn),0) - COALESCE(SUM(QuantityOut),0) FROM ".$wpdb->prefix."FOCAS_Inventory WHERE ProductId = p.ID) AS AvailableQty FROM ".$wpdb->prefix."posts p WHERE post_type = 'product' AND id=$id");
	return $Quantity;
}

function FocasGetActivityLogByEntity($EntityId,$EntityName)
{
	global $wpdb;
	$ActivityLog = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_ActivityLog` WHERE EntityId=$EntityId AND EntityName='$EntityName' ORDER BY Id DESC");
	return $ActivityLog;
}

function FocasGetActivityLogById($Id)
{
	global $wpdb;
	$ActivityLog = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_ActivityLog` WHERE Id=$Id ");
	return $ActivityLog;
}
# region Sale
function FocasGetAllFocusProducts()
{ 
	global $wpdb;
	$Focas_product =  $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_Product`");

	$products = array();
	$count=0;
	foreach($Focas_product as $item)
	{
		
		$product = new product;
		$focasProduct = new FocasProduct();

		$focasProduct->Id =$item->Id;
		$focasProduct->Barcode =$item->Barcode;
		$focasProduct->SalePrice=$item->SalePrice;

		$posts = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type='product' and post_status ='publish' and id=".$item->ProductId."")[0];
		$productattachment = FocasGetProductAttachment($posts->ID);
		$product->Id = $posts->ID;
		$product->ProductName = $posts->post_title;

		if(Count($productattachment) > 0)
			$product->Pic = $productattachment[0]->guid;
		else
			$product->Pic ="http://msqrsols.com/wp-content/uploads/2023/01/Focas.png";

		$product->FocusProduct=$focasProduct;
		$products[$count]=$product;
		$count++;
	}
	return $products;
}

function FocasGetCategories()
{
	global $wpdb;
	$Categories =  $wpdb->get_results( "SELECT tr.`term_id`,tr.`Name`,p.guid,tt.term_taxonomy_id FROM `wp_terms`AS tr JOIN  `".$wpdb->prefix."termmeta` AS trm ON  trm.term_id=tr.term_id JOIN  wp_posts AS p ON p.id=trm.meta_value JOIN `".$wpdb->prefix."term_taxonomy` AS tt ON tr.term_id = tt.term_id ");
	return $Categories;
}

function FocasGetTermRelationships()
{
	global $wpdb;
	$term_relationships =  $wpdb->get_results( "SELECT *FROM `".$wpdb->prefix."term_relationships`");
	return $term_relationships;
}

function FocasGetAllSales()
{
	global $wpdb;
	$Sales = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_Sale` ORDER BY Id DESC");
	return $Sales;
}

function FocasGetSaleById($Id)
{
	global $wpdb;
	$Sale = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_Sale` Where Id=$Id");
	return $Sale[0];
}

function FocasGetAllPurchaseOrder($Id)
{
	global $wpdb;
	$purchaseorder = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."FOCAS_PurchaseOrder` Where SaleId=$Id ORDER BY Id DESC");
	return $purchaseorder;
}

function FocasGetTotalPurchaseOrder($Id)
{
	global $wpdb;
	$purchaseorder = $wpdb->get_results( "SELECT SUM(Price) AS Price FROM `".$wpdb->prefix."FOCAS_PurchaseOrder` Where SaleId=$Id and Approve=1 ORDER BY Id DESC");
	return $purchaseorder[0];
}

#endregion

#region Customer
function FocasGetCustomerList()
{
	global $wpdb;
	$CustomerList = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Customer`");
	return $CustomerList;
}
function FocasGetCustomerByID($Id)
{
	global $wpdb;
	$Customer = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Customer` where Id = $Id");
	return $Customer;
}

#endregion Customer

#region Warehouse
function FocasGetWarehouseList()
{
	global $wpdb;
	$WarehouseList = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Warehouse`");
	return $WarehouseList;
}
function FocasGetWarehouseByID($Id)
{
	global $wpdb;
	$Warehouse = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Warehouse` where Id = $Id");
	return $Warehouse;
}

#endregion Warehouse

#Region Setting
function FocasGetTimeZone()
{
	global $wpdb;
	$TimeZone = $wpdb->get_results("SELECT TimeZone FROM `".$wpdb->prefix."FOCAS_Setting` LIMIT 1");
	return $TimeZone[0]->TimeZone;
}
#endregion Setting

#Region Vendor
function FocasGetVendorList()
{
	global $wpdb;
	$VendorList = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Customer` where  Type = 'Vendor'");
	return $VendorList;
}
function FocasGetVendorByID($Id)
{
	global $wpdb;
	$Vendor = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Customer` where Id = $Id and Type = 'Vendor");
	return $Vendor;
}
#endRegion Vendor

#Region Company
function FocasGetCompanyList()
{
	global $wpdb;
	$CompanyList = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Company`");
	return $CompanyList;
}
function FocasGetCompanyByID($Id)
{
	global $wpdb;
	$Company = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Company` where Id = $Id");
	return $Company;
}
#endRegion Company


?>