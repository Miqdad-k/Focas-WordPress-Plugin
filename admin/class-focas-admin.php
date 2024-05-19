<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://khomusi.com
 * @since      1.0.0
 *
 * @package    Focas
 * @subpackage Focas/admin
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
 
	//end
class Focas_Admin {

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
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Focas_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Focas_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/focas-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Focas_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Focas_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/focas-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jdd.js', array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jdd.min.js', array(), $this->version, false );


	}

	public function Focas_menu()
	{
		
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		
		$url=FOCAS_Url."/wp-json/MSQR/v1/domainActive";
		$domain = home_url();
		$response = wp_remote_get( $url ."?url=$domain");

		if ( is_wp_error( $response ) ) {
			$data =false;
		} else {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			// Use the $data variable to access the response data
		}
		$data=TRUE;
		if($data){
			if($roles[0] == 'administrator')
			{
				add_menu_page(
					'FOCAS', // Title of the page
					'FOCAS', // Text to show on the menu link
					'administrator', // Capability requirement to see the link
					"Focas-Dashboard", //slug
					array($this,"Focas_Dashboard"), // The 'slug' - file to display when clicking the link
					"dashicons-facebook-alt",
					"30"
				);

				add_submenu_page(
					"Focas-Dashboard",
					'Dashboard', // Title of the page
					'Dashboard', // Text to show on the menu link
					'administrator', // Capability requirement to see the link
					"Focas-Dashboard", //slug
					array($this,"Focas_Dashboard") // The 'slug' - file to display when clicking the link
				);

				add_submenu_page(
					"Focas-Dashboard",
					'Point Of Sale', // Title of the page
					'P O S', // Text to show on the menu link
					'administrator', // Capability requirement to see the link
					"pos-List", //slug
					array($this,"Focas_Pos") // The 'slug' - file to display when clicking the link
				);
			}
			else
			{
				add_menu_page(
					'FOCAS', // Title of the page
					'FOCAS', // Text to show on the menu link
					'administrator', // Capability requirement to see the link
					"Focas-Dashboard", //slug
					array($this,"Focas_Dashboard"), // The 'slug' - file to display when clicking the link
					"dashicons-facebook-alt",
					"30"
				);

				add_submenu_page(
					"Focas-Dashboard",
					'Point Of Sale', // Title of the page
					'P O S', // Text to show on the menu link
					'administrator', // Capability requirement to see the link
					"Focas-Dashboard", //slug
					array($this,"Focas_Dashboard") // The 'slug' - file to display when clicking the link
				);
			}
			
			add_submenu_page(
				"Focas-Dashboard",
				'Products', // Title of the page
				'Products', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Product-List", //slug
				array($this,"Focas_ProductList") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Product-List",
				'Product Details', // Title of the page
				'Product Details', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Product-Details", //slug
				array($this,"Focas_ProductDetails") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Product-List",
				'Activity Log', // Title of the page
				'Activity Log', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Activity-Log", //slug
				array($this,"FOCAS_ActivityLog") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Focas-Dashboard",
				'Customer', // Title of the page
				'Customer', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Customer-List", //slug
				array($this,"Focas_CustomerList") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Maintain-Customer",
				'Add Customer', // Title of the page
				'Add Customer', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Maintain-Customer", //slug
				array($this,"Focas_MaintainCustomer") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Focas-Dashboard",
				'Warehouse', // Title of the page
				'Warehouse', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Warehouse-List", //slug
				array($this,"Focas_WarehouseList") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Maintain-Warehouse",
				'Add WareHouse', // Title of the page
				'Add WareHouse', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Maintain-Warehouse", //slug
				array($this,"Focas_MaintainWarehouse") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Focas-Dashboard",
				'Vendor', // Title of the page
				'Vendor', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Vendor-List", //slug
				array($this,"Focas_VendorList") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Maintain-Vendor",
				'Add Vendor', // Title of the page
				'Add Vendor', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Maintain-Vendor", //slug
				array($this,"Focas_MaintainVendor") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Focas-Dashboard",
				'Company', // Title of the page
				'Company', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Company-List", //slug
				array($this,"Focas_CompanyList") // The 'slug' - file to display when clicking the link
			);
			add_submenu_page(
				"Maintain-Company",
				'Add Company', // Title of the page
				'Add Company', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Maintain-Company", //slug
				array($this,"Focas_MaintainCompany") // The 'slug' - file to display when clicking the link
			);

			add_submenu_page(
				"Focas-Dashboard",
				'Purchase', // Title of the page
				'Purchase', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Purchase-List", //slug
				array($this,"Focas_Dashboard") // The 'slug' - file to display when clicking the link
			);
			
			add_submenu_page(
				"Focas-Dashboard",
				'OutBound', // Title of the page
				'OutBound', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"OutBound-List", //slug
				array($this,"Focas_OutBound") // The 'slug' - file to display when clicking the link
			);
			add_submenu_page(
				"OutBound-List",
				'OutBound Details', // Title of the page
				'OutBound Details', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"OutBound-Detail", //slug
				array($this,"OutBoundDetail") // The 'slug' - file to display when clicking the link
			);

		}
		else
		{
			add_menu_page(
				'FOCAS', // Title of the page
				'FOCAS', // Text to show on the menu link
				'administrator', // Capability requirement to see the link
				"Focas-Dashboard", //slug
				array($this,"Focas_Warning"), // The 'slug' - file to display when clicking the link
				"dashicons-facebook-alt",
				"30"
			);

		}
	}



	//Pages

	public function Focas_Dashboard()
	{
		//echo json_encode($data);
		ob_start();
		include_once(FOCAS_Path."admin/partials/Home/Dashboard.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}
	public function Focas_Warning()
	{
		echo 'Warning';
		ob_start();
		include_once(FOCAS_Path."admin/partials/Common/Warning.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_ProductList()
	{
		$products=FocasGetAllProducts();
		// $id = $_GET['id'];
		// echo $id;
		ob_start();
		include_once(FOCAS_Path."admin/partials/Home/Productlist.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_ProductDetails()
	{
		 $id = $_GET['id'];
		// echo $id;
		$activitylist=FocasGetActivityLogByEntity($id,'Product');
		ob_start();
		include_once(FOCAS_Path."admin/partials/Home/ProductDetails.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function FOCAS_ActivityLog()
	{
		 $id = $_GET['id'];
		 //echo $id;
		$activity=FocasGetActivityLogById($id);
		$OldJson=$activity[0]->OldJson;
		$NewJson=$activity[0]->NewJson;
		ob_start();
		include_once(FOCAS_Path."admin/partials/Home/ActivityLog.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}
	public function Focas_CustomerList()
	{
		$CustomerList=FocasGetCustomerList();
		ob_start();
		include_once(FOCAS_Path."admin/partials/Customer/CustomerList.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_MaintainCustomer()
	{
		if (isset($_GET['id']))
		{
			$Customer = FocasGetCustomerByID($_GET['id']);
			$activitylist=FocasGetActivityLogByEntity($_GET['id'],'Customer');
		}
		ob_start();
		include_once(FOCAS_Path."admin/partials/Customer/ManitainCustomer.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_WarehouseList()
	{
		$WarehouseList=FocasGetWarehouseList();
		ob_start();
		include_once(FOCAS_Path."admin/partials/Warehouse/WarehouseList.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_MaintainWarehouse()
	{
		if (isset($_GET['id']))
		{
			$Warehouse = FocasGetWarehouseByID($_GET['id']);
			$activitylist=FocasGetActivityLogByEntity($_GET['id'],'Warehouse');
		}
		ob_start();
		include_once(FOCAS_Path."admin/partials/Warehouse/MaintainWarehouse.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_Pos()
	{
		$user = wp_get_current_user();
		
		$ProductList=FocasGetAllFocusProducts();
		$Focas_Categories=FocasGetCategories();
		$term_relationships=FocasGetTermRelationships();
		ob_start();
		include_once(FOCAS_Path."admin/partials/Sales/POS.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}
	public function Focas_VendorList()
	{
		$VendorList=FocasGetVendorList();
		ob_start();
		include_once(FOCAS_Path."admin/partials/Customer/VendorList.php");
  		$template =ob_get_contents();
		  ob_end_clean();
		  echo $template;
	}
  
	public function Focas_OutBound()
	{
		//echo json_encode($data);
		ob_start();
		include_once(FOCAS_Path."admin/partials/Sales/SaleList.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_MaintainVendor()
	{
		if (isset($_GET['id']))
		{
			$Vendor = FocasGetVendorByID($_GET['id']);
			$activitylist=FocasGetActivityLogByEntity($_GET['id'],'Vendor');
		}
		ob_start();
		include_once(FOCAS_Path."admin/partials/Customer/MaintainVendor.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}

	public function Focas_CompanyList()
	{
		$Company_List=FocasGetCompanyList();
		ob_start();
		include_once(FOCAS_Path."admin/partials/Company/Company_List.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}
	public function Focas_MaintainCompany()
	{
		if (isset($_GET['id']))
		{
			$Company = FocasGetCompanyByID($_GET['id']);
			$activitylist=FocasGetActivityLogByEntity($_GET['id'],'Company');
		}
		ob_start();
		include_once(FOCAS_Path."admin/partials/Company/Maintain_Company.php");
    $template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}
  
	public function OutBoundDetail()
	{   
		$Sale=FocasGetSaleById($_GET['id']);
		$warehouse=FocasGetWarehouseByID($Sale->Id);
		ob_start();
		include_once(FOCAS_Path."admin/partials/Sales/SaleDetails.php");
		$template =ob_get_contents();
		ob_end_clean();
		echo $template;
	}
}

