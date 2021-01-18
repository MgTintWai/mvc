<?php

class Income extends Controller
{
    private $db;
    public function __construct()
    {
        $this->model('IncomeModel');

        $this->db = new Database();
    }
    public function index()
    {
        $income = $this->db->readAll('vw_categories_income');
        $data = [
            'income' => $income
        ];
        $this->view('income/index',$data);
    }

    // public function incomeData(){
    //     $income = $this->db->readAll('vw_categories_income');
    //     $json =  array('data'=>$income);
    //     echo json_encode($json);//To call the other 
        
    // }

    public function create()
    {
        $category = $this->db->readAll('categories');
        // print_r($category);
        // $types = $this->db->readAll('types');
        // print_r($category);
        $data = [
            'categories' => $category,
            // 'types' => $types
        ];

        $this->view('create/create', $data);

    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $amount = $_POST['amount'];
            $category_id = $_POST['category_id'];
            session_start();
            $user_id = base64_decode($_SESSION['id']);
            $date = date('Y/m/d');

            $income = new IncomeModel();

            $income->setAmount($amount);
            $income->setCategoryId($category_id);
            $income->setUserId($user_id);
            $income->setDate($date);

            $incomeCreated = $this->db->create('incomes', $income->toArray());
            setMessage('success', 'Create successful!');
            redirect('income');
        }
    }

    public function edit($id)
    {
        $category = $this->db->readAll('categories');

        $income = $this->db->getById('incomes', $id);

        $data = [
            'categories' => $category,
            'incomes'    => $income
        ];
        $this->view('income/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $category_id = $_POST['category_id'];
            $amount = $_POST['amount'];
            session_start();
            $user_id = base64_decode($_SESSION['id']);
            $date = date('Y/m/d');
            // echo $category_id;

            $income = new IncomeModel();
            $income->setId($id);
            $income->setAmount($amount);
            $income->setCategoryId($category_id);
            $income->setUserId($user_id);
            $income->setDate($date);

            $isUpdated = $this->db->update('incomes', $income->getId(), $income->toArray());
            setMessage('success', 'Update successful!');
            redirect('income');
        }
    }

    
    // public function destroy($id)
    //     {
    //          $id = $_POST['id'];
    //         $this->db->delete('incomes', $id);
    //         setMessage("Income Data has been Deleted");
        
    //         redirect('income');
    //     }
    public function destroy($id)
    {
        $id = base64_decode($id);

        $income = new IncomeModel();

        $income->setId($id);

        $isdestroy = $this->db->delete('incomes', $income->getId());
        redirect('income');
    }
}