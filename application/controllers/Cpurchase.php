<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpurchase extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Purchases');
        $this->load->model('Web_settings');
        $this->template->current_menu = 'purchase';
    }

    public function index($carry = null) {
        $this->permission->check_label('add_purchase')->create()->redirect();
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_add_form();
        if ($carry == 1) {
            $this->template->full_admin_html_view($content);
        } else {
            $this->template->partial_admin_html_view($content);
        }
    }

    //Product Add Form
    public function manage_purchase($carry = null) {
        $this->permission->check_label('manage_purchase')->create()->redirect();
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Purchases');
//        $from_date = $this->input->post('from_date');
//        $to_date = $this->input->post('to_date');
        
        #        #pagination starts        #
        $config["base_url"] = base_url('Cpurchase/manage_purchase/1');
        $config["total_rows"] = $this->Purchases->count_purchase();
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();
        $pagenum = $page;
        #        #pagination ends        #  
        $content = $this->lpurchase->purchase_list($links, $config["per_page"], $page, $pagenum);
        if ($carry == 1) {
            $this->template->full_admin_html_view($content);
        } else {
            $this->template->partial_admin_html_view($content);
        }
    }

//    ========== its for search by from and to date ==============
    public function purchase_search_fromtodate() {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $purchase_no = $this->input->post('purchase_no');
//        echo $from_date;        echo $to_date;        echo $purchase_no;die();
        $data['purchases_list'] = $this->Purchases->purchase_datefilter($from_date, $to_date, $purchase_no);
        $web_settings = $this->Web_settings->retrieve_setting_editdata();
        $data['position'] = $web_settings[0]['currency_position'];
        $data['currency'] = $web_settings[0]['currency'];
        
        $this->load->view('purchase/purchase_search_fromtodate', $data);
    }

    //Insert Product and uload
    public function insert_purchase() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->purchase_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        if (isset($_POST['add-purchase'])) {
            redirect(base_url('Cpurchase/manage_purchase/1'));
            exit;
        } elseif (isset($_POST['add-purchase-another'])) {
            redirect(base_url('Cpurchase/index/1'));
            exit;
        }
    }

    //purchase Update Form
    public function purchase_update_form($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_edit_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

    // purchase Update
    public function purchase_update() {

        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $CI->Purchases->update_purchase();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cpurchase/manage_purchase/1'));
        exit;
    }

    // product_delete
    public function purchase_delete() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Purchases');
        $purchase_id = $_POST['purchase_id'];
        $CI->Purchases->delete_purchase($purchase_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        return true;
    }

    //Purchase item by search
    public function purchase_item_by_search() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $supplier_id = $this->input->post('supplier_id');
        $content = $CI->lpurchase->purchase_by_search($supplier_id);
        $this->template->full_admin_html_view($content);
    }

    //Product search by supplier id
    public function product_search_by_supplier() {

        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Suppliers');
        $supplier_id = $this->input->post('supplier_id');
        $content = $CI->Suppliers->product_search_item($supplier_id);

        if (empty($content)) {
            echo display('product_not_found');
        } else {
            // Select option created for product
            echo "<select name=\"product_id[]\" class=\"productSelection form-control\" id=\"product_id\">";
            echo "<option value=\"0\">" . display('select_one') . "</option>";
            foreach ($content as $product) {
                echo "<option value=" . $product['product_id'] . ">";
                echo $product['product_name'] . "-(" . $product['product_model'] . ")";
                echo "</option>";
            }
            echo "</select>";
        }
    }

    //Retrive right now inserted data to cretae html
    public function purchase_details_data($purchase_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $content = $CI->lpurchase->purchase_details_data($purchase_id);
        $this->template->full_admin_html_view($content);
    }

}
