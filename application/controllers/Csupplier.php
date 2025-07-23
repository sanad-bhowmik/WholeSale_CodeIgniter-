<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Csupplier extends CI_Controller {

    public $supplier_id;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lsupplier');
        $this->load->library('session');
        $this->load->model('Suppliers');
        $this->auth->check_admin_auth();
        $this->template->current_menu = 'supplier';
    }

    public function index($carry = null) {
        $this->permission->check_label('add_supplier')->create()->redirect();
        $content = $this->lsupplier->supplier_add_form();
        if ($carry == 1) {
            $this->template->full_admin_html_view($content);
        } else {
            $this->template->partial_admin_html_view($content);
        }
    }

    //Supplier Search Item
    public function supplier_search_item() {
        $supplier_id = $this->input->post('supplier_id');
        $content = $this->lsupplier->supplier_search_item($supplier_id);

        $this->template->full_admin_html_view($content);
    }

    //Product Add Form
    public function manage_supplier($carry = null) {
        $this->permission->check_label('manage_supplier')->create()->redirect();
        #        #pagination starts        #
        $config["base_url"] = base_url('Csupplier/manage_supplier/1');
        $config["total_rows"] = $this->Suppliers->supplier_list_count();
        $config["per_page"] = 10;
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
        #        #pagination ends        #  
        $content = $this->lsupplier->supplier_list($links, $config["per_page"], $page);
        if ($carry == 1) {
            $this->template->full_admin_html_view($content);
        } else {
            $this->template->partial_admin_html_view($content);
        }
    }

    //Insert Product and uload
    public function insert_supplier() {
        $tran_id = date('Ymdi');
        $depid = date('Ymdis');
        $supplier_id = $this->auth->generator(20);
        $data = array(
            'supplier_id' => $supplier_id,
            'supplier_name' => $this->input->post('supplier_name'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'details' => $this->input->post('details'),
            'status' => 1
        );
        $supplier = $this->lsupplier->insert_supplier($data);
        if ($supplier == TRUE) {
            $s_ledger = array(
                'transaction_id' => $tran_id,
                'supplier_id' => $supplier_id,
                'chalan_no' => 'Adjustment',//$depid,
                'deposit_no' => NULL,
                'amount' => (!empty($this->input->post('previous_balance')) ? $this->input->post('previous_balance') : 0),
                'description' => 'Previous Balance',
                'payment_type' => '',
                'cheque_no' => '',
                'date' => date('Y-m-d'),
                'status' => 1,
                'd_c' => 'c'
            );
            $this->db->insert('supplier_ledger', $s_ledger);

            $this->session->set_userdata(array('message' => display('successfully_added')));
            if (isset($_POST['add-supplier'])) {
                redirect(base_url('Csupplier/manage_supplier/1'));
                exit;
            } elseif (isset($_POST['add-supplier-another'])) {
                redirect(base_url('Csupplier/index/1'));
                exit;
            }
        } else {
            $this->session->set_userdata(array('error_message' => display('already_exists')));
            if (isset($_POST['add-supplier'])) {
                redirect(base_url('Csupplier/manage_supplier/1'));
                exit;
            } elseif (isset($_POST['add-supplier-another'])) {
                redirect(base_url('Csupplier/index/1'));
                exit;
            }
        }
    }

    //Supplier Update Form
    public function supplier_update_form($supplier_id) {
        $content = $this->lsupplier->supplier_edit_data($supplier_id);

        $this->template->full_admin_html_view($content);
    }

    // Supplier Update
    public function supplier_update() {
        $supplier_id = $this->input->post('supplier_id');
        $data = array(
            'supplier_name' => $this->input->post('supplier_name'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'details' => $this->input->post('details')
        );
        $this->Suppliers->update_supplier($data, $supplier_id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Csupplier/manage_supplier/1'));
        exit;
    }

    // Supplier Delete from System
    public function supplier_delete() {
        $supplier_id = $_POST['supplier_id'];
        $this->Suppliers->delete_supplier($supplier_id);
        $this->Suppliers->delete_supplier_ledger($supplier_id);
        $this->Suppliers->delete_supplier_transection($supplier_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        return true;
    }

    // Supplier details findings !!!!!!!!!!!!!! Inactive Now !!!!!!!!!!!!
    public function supplier_details($supplier_id) {
        $content = $this->lsupplier->supplier_detail_data($supplier_id);
        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

//Supplier Ledger Book
    public function supplier_ledger() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');
        $supplier_id = $this->input->post('supplier_id');
//        $cat = $this->input->post('cat');
//        if ($cat == "all") {
//            $url = "Csupplier/supplier_ledger_report";
//            redirect(base_url($url));
//            exit;
//        }
        $sup_sale = $this->input->post('cat');
        if ($sup_sale == "2") {
            $url = "Csupplier/supplier_sales_details" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }

        $sup_sale_summary = $this->input->post('cat');
        if ($sup_sale_summary == "3") {
            $url = "Csupplier/supplier_sales_summary" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }
        $sup_sale_summary = $this->input->post('cat');
        if ($sup_sale_summary == "4") {
            $url = "Csupplier/sales_payment_actual" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }
        $content = $this->lsupplier->supplier_ledger($supplier_id, $start, $end);

        $this->template->full_admin_html_view($content);
//        $this->template->partial_admin_html_view($content);
    }

    public function supplier_ledger_report() {
        $this->permission->check_label('supplier_ledger')->create()->redirect();
        $content = $this->lsupplier->supplier_ledger_report();
        //$this->supplier_id=$supplier_id;
//        $this->template->full_admin_html_view($content);
        $this->template->partial_admin_html_view($content);
    }

    // Supplier wise sales report details
    public function supplier_sales_details() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');
        $supplier_id = $this->uri->segment(4);
        $config["base_url"] = base_url('Csupplier/supplier_sales_details/' . $supplier_id);
        $config["total_rows"] = $this->Suppliers->supplier_sales_details_count($supplier_id);
        $config["per_page"] = 10;
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
        #
        #pagination ends

        $content = $this->lsupplier->supplier_sales_details($supplier_id, $links, $config["per_page"], $page, $start, $end);

        //$this->supplier_id=$supplier_id;
        $this->template->full_admin_html_view($content);
    }

    // Supplier wise sales report summary
    public function supplier_sales_summary() {
        #
        #pagination starts
        #
        $supplier_id = $this->uri->segment(4);
        $config["base_url"] = base_url('Csupplier/supplier_sales_summary/' . $supplier_id . "/");
        $config["total_rows"] = $this->Suppliers->supplier_sales_summary_count($supplier_id);
        $config["per_page"] = 10;
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
        #
        #pagination ends
        #  
        $content = $this->lsupplier->supplier_sales_summary($supplier_id, $links, $config["per_page"], $page);

        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    // Actual Ledger based on sales & deposited amount
    public function sales_payment_actual() {
        #
        #pagination starts
        $supplier_id = $this->uri->segment(3);

        $config["base_url"] = base_url('Csupplier/sales_payment_actual/' . $supplier_id . "/");
        $config["total_rows"] = $this->Suppliers->sales_payment_actual_count();
        $config["per_page"] = 10;
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
        #
        #pagination ends
        #  
        $content = $this->lsupplier->sales_payment_actual($supplier_id, $links, $config["per_page"], $page);

        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    // search report 
    public function search_supplier_report() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');

        $content = $this->lpayment->result_datewise_data($start, $end);
        $this->template->full_admin_html_view($content);
    }

    //Supplier sales details all from menu
    public function supplier_sales_details_all($carry = null) {
        $this->permission->check_label('supplier_sales_details')->create()->redirect();
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');

        $config["base_url"] = base_url('Csupplier/supplier_sales_details_all_fulladmin/1');
        $config["total_rows"] = $this->Suppliers->supplier_sales_details_count_all();
        $config["per_page"] = 10;
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
        #        #pagination ends        #  
        $content = $this->lsupplier->supplier_sales_details_allm($links, $config["per_page"], $page);

        //$this->supplier_id=$supplier_id;
        if ($carry == 1) {
            $this->template->full_admin_html_view($content);
        } else {
            $this->template->partial_admin_html_view($content);
        }
    }

    public function supplier_sales_details_all_fulladmin($carry = null) {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');

        $config["base_url"] = base_url('Csupplier/supplier_sales_details_all_fulladmin/1');
        $config["total_rows"] = $this->Suppliers->supplier_sales_details_count_all();
        $config["per_page"] = 10;
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
        #        #pagination ends        #  
        $content = $this->lsupplier->supplier_sales_details_allm($links, $config["per_page"], $page);

        //$this->supplier_id=$supplier_id;
         if ($carry == 1) {
            $this->template->full_admin_html_view($content);
        } else {
            $this->template->partial_admin_html_view($content);
        }
//        $this->template->partial_admin_html_view($content);
    }

    // supplier ledger for supplier information 
    public function supplier_ledger_info($supplier_id) {
        $content = $this->lsupplier->supplier_ledger_info($supplier_id);
        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    ####### supplier actual ledger by supplier price ########

    public function supplier_actual_ledger() {
        $content = $this->lsupplier->supplier_actual_ledger();
        //$this->supplier_id=$supplier_id;
        $this->template->full_admin_html_view($content);
    }

    public function supplier_actual_ledger_rpt() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');
        $supplier_id = $this->input->post('supplier_id');
        $cat = $this->input->post('cat');
        if ($cat == "all") {
            $url = "Csupplier/supplier_actual_ledger";
            redirect(base_url($url));
            exit;
        }
        $sup_sale = $this->input->post('cat');
        if ($sup_sale == "2") {
            $url = "Csupplier/supplier_sales_details" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }

        $sup_sale_summary = $this->input->post('cat');
        if ($sup_sale_summary == "3") {
            $url = "Csupplier/supplier_sales_summary" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }
        $sup_sale_summary = $this->input->post('cat');
        if ($sup_sale_summary == "4") {
            $url = "Csupplier/sales_payment_actual" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }
        $content = $this->lsupplier->supplier_ledger_actual_rpt($supplier_id, $start, $end);

        $this->template->full_admin_html_view($content);
    }

    ####### supplier actual ledger by sales price ########

    public function supplier_actual_ledger_sales_price() {
        $this->permission->check_label('supplier_actual_ledger_sale')->create()->redirect();
        $content = $this->lsupplier->supplier_actual_ledger_sales_price();
        //$this->supplier_id=$supplier_id;
//        $this->template->full_admin_html_view($content);
        $this->template->partial_admin_html_view($content);
    }

    ################ supplier actual ledger sales price report supplier id 

    public function supplier_actual_salesprice_rpt() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');
        $supplier_id = $this->input->post('supplier_id');
        $cat = $this->input->post('cat');
        if ($cat == "all") {
            $url = "Csupplier/supplier_actual_ledger_sales_price";
            redirect(base_url($url));
            exit;
        }
        $sup_sale = $this->input->post('cat');


        if (!empty($supplier_id) AND $sup_sale == "2") {
            $url = "Csupplier/supplier_sales_details" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }

        $sup_sale_summary = $this->input->post('cat');
        if ($sup_sale_summary == "3") {
            $url = "Csupplier/supplier_sales_summary" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }
        $sup_sale_summary = $this->input->post('cat');
        if ($sup_sale_summary == "4") {
            $url = "Csupplier/sales_payment_actual" . '/' . $supplier_id . '/' . $start . '/' . $end;
            redirect(base_url($url));
            exit;
        }
        $content = $this->lsupplier->supplier_ledger_salesprice_rpt($supplier_id, $start, $end);

        $this->template->full_admin_html_view($content);
    }

    public function supplier_payment() {
        $this->permission->check_label('supplier_payment_ledger')->create()->redirect();
        $content = $this->lsupplier->supplier_payment();
        //$this->supplier_id=$supplier_id;
//        $this->template->full_admin_html_view($content);
        $this->template->partial_admin_html_view($content);
    }

    ###### supplier payment report ###########

    public function supplier_payment_report() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');
        $supplier_id = $this->input->post('supplier_id');
        if ($supplier_id == "all") {
            $url = "Csupplier/supplier_payment";
            redirect(base_url($url));
            exit;
        }
        $config["base_url"] = base_url('Csupplier/supplier_payment_report/' . $supplier_id . "/");
        $config["total_rows"] = $this->Suppliers->supplier_payment_count($supplier_id, $start, $end);
        $config["per_page"] = 10;
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
        $content = $this->lsupplier->supplier_payment_report($supplier_id, $start, $end, $links, $config["per_page"], $page);
        //$this->supplier_id=$supplier_id;
        $this->template->full_admin_html_view($content);
    }

}
