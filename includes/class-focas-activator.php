<?php

/**
 * Fired during plugin activation
 *
 * @link       https://khomusi.com
 * @since      1.0.0
 *
 * @package    Focas
 * @subpackage Focas/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Focas
 * @subpackage Focas/includes
 * @author     Miqdad k. <Miqdadkhomusi1@gmail.com>
 */
class Focas_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() 
	{
		global $wpdb;
		global $jal_db_version;
		$jal_db_version = '1.0';
		$charset_collate = $wpdb->get_charset_collate();

		$FOCAS_Product = $wpdb->prefix . 'FOCAS_Product';
		$FOCAS_Productsql = "CREATE TABLE $FOCAS_Product (
			`Id` mediumint(9) AUTO_INCREMENT,
			`ProductId` int DEFAULT 0,
			`SalePrice` Decimal DEFAULT 0,
			`Barcode`varchar(250) DEFAULT 0,
			`CreatedBy`int DEFAULT 0,
			 PRIMARY KEY  (Id) 
			 ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta( $FOCAS_Productsql );

		$FOCAS_ActivityLog = $wpdb->prefix . 'FOCAS_ActivityLog';
		$FOCAS_ActivityLogsql = "CREATE TABLE $FOCAS_ActivityLog (
			`Id` MEDIUMINT(9) AUTO_INCREMENT,
			`Activity` LONGTEXT,
			`EntityName` VARCHAR(100),
			`EntityId` INT DEFAULT 0,
			`OldJson` LONGTEXT,
			`NewJson` LONGTEXT,
			`CreatedOn` DATETIME,
			 PRIMARY KEY  (Id)  
			 ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta( $FOCAS_ActivityLogsql );

		$FOCAS_Inventory = $wpdb->prefix . 'FOCAS_Inventory';
		$FOCAS_Inventorysql = "CREATE TABLE $FOCAS_Inventory (
			`Id` mediumint(9) AUTO_INCREMENT,
			`QuantityIn` Decimal DEFAULT 0,
			`QuantityOut` Decimal DEFAULT 0,
			`SaleId`int DEFAULT 0,
			`PurchaseId`int DEFAULT 0,
			`ProductId` int DEFAULT 0,
			`PurchaseDetailId` int DEFAULT 0,
			`SaleDetailId` int DEFAULT 0,
			`Warehouse` int DEFAULT 0,
			PRIMARY KEY  (Id) 
			) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta( $FOCAS_Inventorysql );

		$FOCAS_Sale = $wpdb->prefix . 'FOCAS_Sale';
    	$FOCAS_Salesql = "CREATE TABLE $FOCAS_Sale (
		`Id` mediumint(9) AUTO_INCREMENT,
        `SaleDate`  DATETIME ,
        `CustomerId` int DEFAULT 0,
        `PaymentMode` varchar(250) ,
        `PkrOrDiscount` TINYINT (1),
        `PkrOrDiscountValue` DECIMAL DEFAULT 0,
        `SubTotal` DECIMAL DEFAULT 0,
        `GrandTotal` DECIMAL DEFAULT 0,
        `PaidAmount` DECIMAL DEFAULT 0,
		`InvoiceNo` varchar(250),
		`CreatedOn` DATETIME,
		`CreatedBy` int DEFAULT 0,
		`WarehouseId` int DEFAULT 0,
		`SaleStatus` varchar(250),
         PRIMARY KEY  (Id) 
         ) $charset_collate;";
    	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    	dbDelta( $FOCAS_Salesql );

		$FOCAS_SaleDetail = $wpdb->prefix . 'FOCAS_SaleDetail';
		$FOCAS_SaleDetailsql = "CREATE TABLE $FOCAS_SaleDetail (
			`Id` mediumint(9) AUTO_INCREMENT,
			`SaleId` int DEFAULT 0,
			`ProductId` int DEFAULT 0,
			`Quantity`int DEFAULT 0,
			`SalePrice` Decimal DEFAULT 0,
			`WarehouseId` int DEFAULT 0,
			 PRIMARY KEY  (Id) 
			 ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $FOCAS_SaleDetailsql );

		$FOCAS_PurchaseOrder = $wpdb->prefix . 'FOCAS_PurchaseOrder';
		$FOCAS_PurchaseOrdersql = "CREATE TABLE $FOCAS_PurchaseOrder (
			`Id` mediumint(9) AUTO_INCREMENT,
			`CustomerId` int DEFAULT 0,
			`SaleId` int DEFAULT 0,
			`Price`Decimal DEFAULT 0,
			`CreatedBy` int DEFAULT 0,
			`CreatedOn` DATETIME,
			`PoDate` DATETIME,
			`Approve` TINYINT,
			 PRIMARY KEY  (Id) 
			 ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $FOCAS_PurchaseOrdersql );

		$FOCAS_Customer = $wpdb->prefix . 'FOCAS_Customer';
		$FOCAS_Customersql = "CREATE TABLE $FOCAS_Customer (
			`Id` MEDIUMINT(9) AUTO_INCREMENT,
			`Name` VARCHAR(250),
			`Email` VARCHAR(250),
			`Phone` VARCHAR(150),
			`Address` VARCHAR(500),
			`Notes` VARCHAR(500),
			`CreatedOn` DATETIME,
			`CreatedBy` INT,
			`CompanyId` INT,
			`Type` VARCHAR(100),
			 PRIMARY KEY  (Id)  
			 ) $charset_collate;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($FOCAS_Customersql);

		$FOCAS_Warehouse = $wpdb->prefix . 'FOCAS_Warehouse';
		$FOCAS_Warehousesql = "CREATE TABLE $FOCAS_Warehouse (
			`Id` MEDIUMINT(9) AUTO_INCREMENT,
			`Name` VARCHAR(250),
			`Address` VARCHAR(500),
			`CreatedOn` DATETIME,
			`CreatedBy` INT,
			 PRIMARY KEY  (Id)  
			 ) $charset_collate;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($FOCAS_Warehousesql);

		$FOCAS_Setting = $wpdb->prefix . 'FOCAS_Setting';
		$FOCAS_Settingsql = "CREATE TABLE $FOCAS_Setting (
			`Id` MEDIUMINT(9) AUTO_INCREMENT,
			`TimeZone` VARCHAR(250),
			 PRIMARY KEY  (Id)
			 ) $charset_collate;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($FOCAS_Settingsql);

		add_option( 'jal_db_version', $jal_db_version );

		$FOCAS_Company = $wpdb->prefix . 'FOCAS_Company';
		$FOCAS_Companysql = "CREATE TABLE $FOCAS_Company (
			`Id` MEDIUMINT(9) AUTO_INCREMENT,
			`Name` VARCHAR(250),
			`Email` VARCHAR(250),
			`Phone` VARCHAR(150),
			`Address` VARCHAR(500),
			`Notes` VARCHAR(500),
			`CreatedOn` DATETIME,
			`CreatedBy` INT,
			 PRIMARY KEY  (Id)  
			 ) $charset_collate;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($FOCAS_Companysql);
	}

}
