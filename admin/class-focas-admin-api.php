<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://khomusi.com
 * @since      1.0.0
 *
 * @package    Focas
 * @subpackage Focas/admin_api
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Focas
 * @subpackage Focas/admin
 * @author     Miqdad k. <Miqdadkhomusi1@gmail.com>
 */
class Focas_Admin_Api {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 * $client_ip = $_SERVER['REMOTE_ADDR'];
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	//Request
	public function handle_ajax_request_admin(){
		$param =isset($_REQUEST['param'])?$_REQUEST['param']:"";
		if(!empty($param))
		{
			$user = wp_get_current_user();
			global $wpdb;
			if($param == "AddToInventory"){
				
				$id= $_REQUEST['Id'];
				$rand = substr(md5(microtime()),rand(0,26),7);
				$p = $wpdb->get_results( "INSERT INTO `".$wpdb->prefix."FOCAS_Product` (`ProductId`,`SalePrice`,`Barcode`,`CreatedBY`) VALUES('$id','0','$rand','$user->id')");
				$product=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Product ORDER BY id DESC LIMIT 1");
				date_default_timezone_set('UTC');
				$utc_time = date('Y-m-d H:i:s',time());
				$A=$wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Product is added (id=".$product[0]->Id.")','Product',".$product[0]->Id.",'".json_encode($product)."','".json_encode($product)."','$utc_time');");

				//select *from getLastRecord ORDER BY id DESC LIMIT 1
				echo json_encode([
					'Success' => true,
					'Id' => $product[0]->Id,
				   ]);
			}
			else if($param == "EditProduct")
			{
				$id= $_REQUEST['Id'];
				$SalePrice= $_REQUEST['SalePrice'];
				$Barcode= $_REQUEST['Barcode'];

				$OldJson=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Product where ProductId=$id");
				$update =$wpdb->get_results("UPDATE `".$wpdb->prefix."FOCAS_Product` SET SalePrice='". $SalePrice ."',Barcode='". $Barcode ."' WHERE ProductId=$id");
				$NewJson=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Product where ProductId=$id");
				
				date_default_timezone_set('UTC');
				$utc_time = date('Y-m-d H:i:s',time());
				$A=$wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Product is Edit (id=".$OldJson[0]->Id.")','Product',".$OldJson[0]->Id.",'".json_encode($OldJson[0])."','".json_encode($NewJson[0])."','$utc_time');");
				
				echo json_encode([
					'Success' => true,
				   ]);
			}
			else if ($param == "CustomerDatatable")
			{
				$CustomerList = FocasGetCustomerList();
				$tdata = [];

				foreach ($CustomerList as $key => $value):
					$tdata[$key][] = $value->Id;
					$tdata[$key][] = $value->Name;
					$tdata[$key][] = $value->Email;
					$tdata[$key][] = $value->Phone;
					$tdata[$key][] = $value->Address;
					$tdata[$key][] = $value->Company;
				endforeach;

				$total_records = count($tdata);
				$json_data = array(
					"draw" => intval($_REQUEST['draw']),
					"recordsTotal" => intval($total_records),
					"recordsFiltered" => intval($total_records),
					"data" => $tdata
				);
				echo json_encode($json_data);
			} 
			else if ($param == "SaleDatatable")
			{
				$SaleList = FocasGetAllSales();
				$tdata = [];

				foreach ($SaleList as $key => $value):
					$tdata[$key][] = $value->Id;
					$tdata[$key][] = $value->InvoiceNo;
					$tdata[$key][] = $value->SaleDate;
					$tdata[$key][] = $value->PaymentMode;
					$customer=FocasGetCustomerByID($value->CustomerId);
					$tdata[$key][] = $customer[0]->Name == null ? 'Walk in Customer':$customer[0]->Name;
					$tdata[$key][] = $value->GrandTotal;
					$tdata[$key][] = $value->SaleStatus;
					$tdata[$key][] = $value->CreatedOn;

				endforeach;

				$total_records = count($tdata);
				$json_data = array(
					"draw" => intval($_REQUEST['draw']),
					"recordsTotal" => intval($total_records),
					"recordsFiltered" => intval($total_records),
					"data" => $tdata
				);
				echo json_encode($json_data);
			}
			else if ($param == "PurchaseOrderDatatable")
			{
				$PurchaseOrder=FocasGetAllPurchaseOrder($_REQUEST['Id']);
				$tdata = [];

				foreach ($PurchaseOrder as $key => $value):
					$tdata[$key][] = $value->Id;
					// $customer=FocasGetCustomerByID($value->CustomerId);
					// $tdata[$key][] = $customer[0]->Name == null ? 'Walk in Customer':$customer[0]->Name;
					$tdata[$key][] =FocasDateFormatted( $value->PoDate);
					$tdata[$key][] = $value->Price;
					$tdata[$key][] = $value->Approve;
					$tdata[$key][] =FocasDateFormatted($value->CreatedOn);
				endforeach;

				$total_records = count($tdata);
				$json_data = array(
					"draw" => intval($_REQUEST['draw']),
					"recordsTotal" => intval($total_records),
					"recordsFiltered" => intval($total_records),
					"data" => $tdata
				);
				echo json_encode($json_data);
			}
			else if($param == "PurchaseOrderTotal")
			{
				$id= $_REQUEST['Id'];
				$PurchaseOrderTotal=FocasGetTotalPurchaseOrder($id);
				echo json_encode([
					'Success' => true,
					'Total' => $PurchaseOrderTotal->Price
				   ]);
			}
			else if ($param == "WarehouseDatatable") 
			{
				$WarehouseList = FocasGetWarehouseList();
				$tdata = [];

				foreach ($WarehouseList as $key => $value):
					$tdata[$key][] = $value->Id;
					$tdata[$key][] = $value->Name;
					$tdata[$key][] = $value->Address;
				endforeach;

				$total_records = count($tdata);
				$json_data = array(
					"draw" => intval($_REQUEST['draw']),
					"recordsTotal" => intval($total_records),
					"recordsFiltered" => intval($total_records),
					"data" => $tdata
				);
				echo json_encode($json_data);
			} 
			else if ($param == "DeleteCustomer") 
			{
				$Id = $_REQUEST['Id'];
				$wpdb->get_results("DELETE FROM `" . $wpdb->prefix . "FOCAS_Customer` Where `Id` =  $Id");
				echo json_encode([
					'Success' => true,
				]);
			}
			else if ($param == "DeleteWarehouse") 
			{
				$Id = $_REQUEST['Id'];
				$wpdb->get_results("DELETE FROM `" . $wpdb->prefix . "FOCAS_Warehouse` Where `Id` =  $Id");
				echo json_encode([
					'Success' => true,
				]);
			}
			else if ($param == "VendorDatatable")
			{
				$VendorList = FocasGetVendorList();
				$tdata = [];

				foreach ($VendorList as $key => $value):
					$tdata[$key][] = $value->Id;
					$tdata[$key][] = $value->Name;
					$tdata[$key][] = $value->Email;
					$tdata[$key][] = $value->Phone;
					$tdata[$key][] = $value->Address;
					$tdata[$key][] = $value->Company;
				endforeach;

				$total_records = count($tdata);
				$json_data = array(
					"draw" => intval($_REQUEST['draw']),
					"recordsTotal" => intval($total_records),
					"recordsFiltered" => intval($total_records),
					"data" => $tdata
				);
				echo json_encode($json_data);
			} 
			else if ($param == "DeleteVendor") 
			{
				$Id = $_REQUEST['Id'];
				$wpdb->get_results("DELETE FROM `" . $wpdb->prefix . "FOCAS_Customer` Where `Id` =  $Id");
				echo json_encode([
					'Success' => true,
				]);
			}

			else if ($param == "CompanyDatatable")
			{
				$CompanyList = FocasGetCompanyList();
				$tdata = [];

				foreach ($CompanyList as $key => $value):
					$tdata[$key][] = $value->Id;
					$tdata[$key][] = $value->Name;
					$tdata[$key][] = $value->Email;
					$tdata[$key][] = $value->Phone;
					$tdata[$key][] = $value->Address;
					$tdata[$key][] = $value->Company;
				endforeach;

				$total_records = count($tdata);
				$json_data = array(
					"draw" => intval($_REQUEST['draw']),
					"recordsTotal" => intval($total_records),
					"recordsFiltered" => intval($total_records),
					"data" => $tdata
				);
				echo json_encode($json_data);
			} 
			else if ($param == "DeleteCompany") 
			{
				$Id = $_REQUEST['Id'];
				$wpdb->get_results("DELETE FROM `" . $wpdb->prefix . "FOCAS_Company` Where `Id` =  $Id");
				echo json_encode([
					'Success' => true,
				]);
			}

		} 

		 
		else if (!empty($_POST['AddCustomerData'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['AddCustomerData']));
			$wpdb->get_results("Insert into`" . $wpdb->prefix . "FOCAS_Customer` ( `Name`, `Email`, `Phone`, `Address`, `Notes`, `CreatedOn`, `CreatedBy`) values ('$json->name','$json->email','$json->phone','$json->address','$json->notes','$utc_time','$user->id')");
			$customer = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "FOCAS_Customer ORDER BY id DESC LIMIT 1");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Customer is added (id=" . $customer[0]->Id . ")','Customer'," . $customer[0]->Id . ",'" . json_encode($customer) . "','" . json_encode($customer) . "','$utc_time');");
			echo json_encode([
				'Success' => true
			]);
		}
		else if (!empty($_POST['UpdateCustomeData'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['UpdateCustomeData']));
			$OldJson = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Customer` where `Id` = $json->id");
			$wpdb->get_results("UPDATE`" . $wpdb->prefix . "FOCAS_Customer` SET `Name`='".$json->name."',`Email`='".$json->email."',`Phone`='".$json->phone."',`Address`='".$json->address."',`Notes`='".$json->notes."' Where Id = $json->id");
			$NewJson=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Customer where Id=$json->id");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Customer is updated (id=" . $json->id . ")','Customer'," . $json->id . ",'" . json_encode($OldJson) . "','" . json_encode($NewJson) . "','$utc_time');");
			echo json_encode([
				'Success' => true,
				 'data' => json_encode($OldJson)
			]);
		}
		else if (!empty($_POST['AddWarehouse'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['AddWarehouse']));
			$wpdb->get_results("Insert into`" . $wpdb->prefix . "FOCAS_Warehouse` ( `Name`, `Address`,`CreatedOn`, `CreatedBy`) values ('$json->name','$json->address','$utc_time','$user->id')");
			$warehouse = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "FOCAS_Customer ORDER BY id DESC LIMIT 1");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Warehouse is added (id=" . $warehouse[0]->Id . ")','Warehouse'," . $warehouse[0]->Id . ",'" . json_encode($warehouse) . "','" . json_encode($warehouse) . "','$utc_time');");
			echo json_encode([
				'Success' => true
			]);
		}
		else if (!empty($_POST['editwarehouse']))
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['editwarehouse']));
			$OldJson = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Warehouse` where `Id` = $json->id");
			$wpdb->get_results("UPDATE`" . $wpdb->prefix . "FOCAS_Warehouse` SET `Name`='".$json->name."',`Address`='".$json->address."' Where Id = $json->id");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Warehouse is updated (id=" . $json->id . ")','Warehouse'," . $json->id . ",'" . json_encode($OldJson) . "','" . json_encode($json) . "','$utc_time');");
			echo json_encode([
				'Success' => true,
				 'data' => json_encode($OldJson)
			]);
		}
		else if (!empty($_POST['AddUpdatePurchaseOrder']))
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['AddUpdatePurchaseOrder']));

			if($json->Id > 0)
			{
				$utc=FocasDateFormattedUtc($json->PoDate);
				$approve=$json->Approve ?1:0; 
				$old = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_PurchaseOrder where Id=$json->Id");
				$A=$wpdb->get_results("UPDATE ".$wpdb->prefix."FOCAS_PurchaseOrder SET CustomerId=$json->CustomerId,SaleId=$json->SaleId,Price=$json->Price,PoDate='$utc',Approve=$approve WHERE Id=$json->Id");
				$new = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_PurchaseOrder where Id=$json->Id");
				$PurchaseOrder = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_PurchaseOrder ORDER BY id DESC LIMIT 1");
				$A=$wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Purchase Order is Edit (id=".$PurchaseOrder[0]->Id.")','Order',".$json->SaleId.",'".json_encode($old[0])."','".json_encode($new[0])."','$utc_time');");
			}
			else
			{
				$utc=FocasDateFormattedUtc($json->PoDate);
				$approve=$json->Approve ?1:0; 
				$A = $wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_PurchaseOrder` (`CustomerId`,`SaleId`,`Price`,`CreatedBy`,`CreatedOn`,`PoDate`,`Approve`) VALUES ('$$json->CustomerId','".$json->SaleId."','$json->Price', '$user->id', '$utc_time','$utc','$approve');");
				$PurchaseOrder = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_PurchaseOrder ORDER BY id DESC LIMIT 1");
				$A=$wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Purchase Order is added (id=".$PurchaseOrder[0]->Id.")','Order',".$json->SaleId.",'".json_encode($PurchaseOrder[0])."','".json_encode($PurchaseOrder[0])."','$utc_time');");
			}
			
			echo json_encode([
				'Success' => true,
			]);
		}
		else if (!empty($_POST['PosList']))
		{
			$json = json_decode(stripslashes($_POST['PosList']));
			$Saleproduct=json_decode(stripslashes($json->ProductListJson));
			$PkrOrDiscount=$json->PkrOrDiscount;
			$SubTotalSave=$json->SubTotalSave;
			$GrandTotalSave=$json->GrandTotalSave;
			$PkrOrDiscountValue=$json->PkrOrDiscountValue;
			$paidAmount=$json->Amount;
			$Listcustomer=$json->customer;
			$Name=$json->Name;
			$PhoneNo=$json->PhoneNo;
			$Address=$json->Address;
			$Warehouse=$json->Warehouse;

			date_default_timezone_set('UTC');
			$tempDate = date('Y-m-d H:i:s',time());

			if($Listcustomer == -1)
			{
				global $wpdb;
				$now = $tempDate->format('Y-m-d H:i:s');
				$createBy = 1;
				$wpdb->get_results( "insert into " . $wpdb->prefix ."FOCAS_Customer(Name,Address, PhoneNo, Type, CreatedOn,CreatedBy) value('$Name','$Address', '$PhoneNo', 'Customer', '$now' ,'$createBy')");
				$Customer = $wpdb->get_results("SELECT MAX(Id) AS id FROM ".$wpdb->prefix."FOCAS_Customer");
				$Listcustomer=$Customer[0]->id;
			}

			$check=0;
			if($PkrOrDiscount =='true')
			{
			  $check=1;
			}
			global $wpdb;
			$now = $tempDate;
			$price=$GrandTotalSave -$paidAmount;
			$status="";
			$POPrice=0;
			if($price > 0)
			{
				$status="Partial Paid";
				$POPrice=$paidAmount;
			}
			else
			{
				$status="Paid";
				$POPrice=$GrandTotalSave;
			}
			$query = $wpdb->get_results( "INSERT INTO `".$wpdb->prefix."FOCAS_Sale` (`SaleDate`,`CustomerId`,`PaymentMode`,`PkrOrDiscount`,`PkrOrDiscountValue`,`SubTotal`,`GrandTotal`,`PaidAmount`,`InvoiceNo`,`CreatedOn`,`CreatedBy`,`WarehouseId`,`SaleStatus`) VALUES ('$now','$Listcustomer','Cash','$check','$PkrOrDiscountValue','$SubTotalSave','$GrandTotalSave','$paidAmount','','$now','$user->id','$Warehouse','$status')");
			$sale = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Sale ORDER BY id DESC LIMIT 1");
			$saleupdate = $wpdb->get_results("UPDATE ".$wpdb->prefix."FOCAS_Sale SET `InvoiceNo` = 'ODR-".$sale[0]->Id."' WHERE `Id` =".$sale[0]->Id.";");
			date_default_timezone_set('UTC');
			$utc_time = date('Y-m-d H:i:s',time());
			$A=$wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Order is added (id=".$sale[0]->Id.")','Order',".$sale[0]->Id.",'".json_encode($sale[0])."','".json_encode($sale[0])."','$utc_time');");
			
			$A = $wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_PurchaseOrder` (`CustomerId`,`SaleId`,`Price`,`CreatedBy`,`CreatedOn`,`PoDate`,`Approve`) VALUES ('$Listcustomer','".$sale[0]->Id."','$POPrice', '$user->id', '$now','$now','1');");
			$PurchaseOrder = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_PurchaseOrder ORDER BY id DESC LIMIT 1");
			$A=$wpdb->get_results("INSERT INTO `".$wpdb->prefix."FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Purchase Order is added (id=".$PurchaseOrder[0]->Id.")','Order',".$sale[0]->Id.",'".json_encode($PurchaseOrder[0])."','".json_encode($PurchaseOrder[0])."','$utc_time');");
			  //$sale = $ret = mysqli_query($con, "select max(Id) from sale");
				if(Count($sale) > 0)
				{
					$saleId = $sale[0]->Id;
					foreach ($Saleproduct as $item) 
					{
						$productid = $item->Id;
						$quantity = $item->Qty;
						$SalePrice = $item->price;
						$detailquery =  $wpdb->get_results("Insert into ".$wpdb->prefix."FOCAS_SaleDetail(SaleId,ProductId,Quantity,SalePrice) value('$saleId','$productid','$quantity','$SalePrice')");
						$saledetail =  $wpdb->get_results("SELECT MAX(Id) AS id FROM ".$wpdb->prefix."FOCAS_SaleDetail")[0];
						$detailquery = $wpdb->get_results("Insert into ".$wpdb->prefix."FOCAS_Inventory(QuantityOut,SaleID,ProductId,SaleDetailId) value('$quantity',$saleId,$productid,$saledetail->id)");
					}
					
				}
		}
		else if (!empty($_POST['AddVendorData'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['AddVendorData']));
			$wpdb->get_results("Insert into`" . $wpdb->prefix . "FOCAS_Customer` ( `Name`, `Email`, `Phone`, `Address`, `Notes`, `CreatedOn`, `CreatedBy`,`Type`) values ('$json->name','$json->email','$json->phone','$json->address','$json->notes','$utc_time','$user->id','Vendor')");
			$Vendor = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "FOCAS_Customer ORDER BY id DESC LIMIT 1");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Vendor is added (id=" . $Vendor[0]->Id . ")','Customer'," . $Vendor[0]->Id . ",'" . json_encode($Vendor) . "','" . json_encode($Vendor) . "','$utc_time');");
			echo json_encode([
				'Success' => true
			]);
		}
		else if (!empty($_POST['UpdateVendorData'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['UpdateVendorData']));
			$OldJson = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Customer` where `Id` = $json->id");
			$wpdb->get_results("UPDATE`" . $wpdb->prefix . "FOCAS_Customer` SET `Name`='".$json->name."',`Email`='".$json->email."',`Phone`='".$json->phone."',`Address`='".$json->address."',`Notes`='".$json->notes."' Where Id = $json->id");
			$NewJson=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Customer where Id=$json->id");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Vendor is updated (id=" . $json->id . ")','Vendor'," . $json->id . ",'" . json_encode($OldJson) . "','" . json_encode($NewJson) . "','$utc_time');");
			echo json_encode([
				'Success' => true,
				 'data' => json_encode($OldJson)
			]);
		}
		else if (!empty($_POST['AddCompanyData'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['AddCompanyData']));
			$query="Insert into`" . $wpdb->prefix . "FOCAS_Company` ( `Name`, `Email`, `Phone`, `Address`, `Notes`, `CreatedOn`, `CreatedBy`) values ('$json->name','$json->email','$json->phone','$json->address','$json->notes','$utc_time','$user->id'";
			$wpdb->get_results("Insert into`" . $wpdb->prefix . "FOCAS_Company` ( `Name`, `Email`, `Phone`, `Address`, `Notes`, `CreatedOn`, `CreatedBy`) values ('$json->name','$json->email','$json->phone','$json->address','$json->notes','$utc_time','$user->id')");
			$Company = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "FOCAS_Company ORDER BY id DESC LIMIT 1");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Company is added (id=" . $Company[0]->Id . ")','Company'," . $Company[0]->Id . ",'" . json_encode($Company) . "','" . json_encode($Company) . "','$utc_time');");
			echo json_encode([
				'Success' => true,
				'query'=>$query
			]);
		}
		else if (!empty($_POST['UpdateCompanyData'])) 
		{
			global $wpdb;
			$user = wp_get_current_user();
			$utc_time = date('Y-m-d H:i:s', time());
			$json = json_decode(stripslashes($_POST['UpdateCompanyData']));
			$OldJson = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."FOCAS_Company` where `Id` = $json->id");
			$wpdb->get_results("UPDATE`" . $wpdb->prefix . "FOCAS_Company` SET `Name`='".$json->name."',`Email`='".$json->email."',`Phone`='".$json->phone."',`Address`='".$json->address."',`Notes`='".$json->notes."' Where Id = $json->id");
			$NewJson=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."FOCAS_Company where Id=$json->id");
			$wpdb->get_results("INSERT INTO `" . $wpdb->prefix . "FOCAS_ActivityLog` (`Activity`,`EntityName`,`EntityId`,`OldJson`,`NewJson`,`CreatedOn`) VALUES('Company is updated (id=" . $json->id . ")','Company'," . $json->id . ",'" . json_encode($OldJson) . "','" . json_encode($NewJson) . "','$utc_time');");
			echo json_encode([
				'Success' => true,
				 'data' => json_encode($OldJson)
			]);
		}
		
		wp_die();
	}

}