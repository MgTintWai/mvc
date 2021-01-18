<?php

class IncomeApi extends Controller
{
    private $db;
    public function __construct()
    {
        $this->model('IncomeModel');

        $this->db = new Database();
    }
    public function index()
    {
        // $income = $this->db->readAll('vw_categories_income');
        // $data = [
        //     'income' => $income
        // ];
        $this->view('income/index');
    }

    public function importFile()
    {
        $this->view('create/import');
    }


    public function incomeData(){
        $income = $this->db->readAll('vw_categories_income');
        $json =  array('data'=>$income);
        echo json_encode($json);//To call the other 
        
    }

    public function create()
    {
        $category = $this->db->readAll('categories');
        // print_r($category);
        $types = $this->db->readAll('types');
        // print_r($category);
        $data = [
            'categories' => $category,
            'types' => $types
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
           // postman ထဲက data ေတြကုိ ျပန္သံုးခ်င္ရင္ အဲဒါကိုသံုးေပးရတယ္
            // ဒီထဲက data ေတြကို postman မွာျပန္သံုးခ်င္ရင္ json_decoded လုပ္ေပးရတယ္

            $body = json_decode(file_get_contents('php://input'));
            // print_r($body);
            // exit;
            if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

                $id = $body->id;
                $amount = $body->amount;
                $category_id = $body->category_id;
                $user_id = $body->user_id;
                $date = date('Y/m/d');
                $date = $body->date;

                $income = new IncomeModel();
                $income->setId($id);
                $income->setAmount($amount);
                $income->setCategoryId($category_id);
                $income->setUserId($user_id);
                $income->setDate($date);

                $isUpdated = $this->db->update('incomes', $income->getId(), $income->toArray());
                setMessage('success', 'Update successful!');
                
            }

            $id = (int)$isUpdated;
            $updated_data = $this->db->getById('incomes',$id);
            if(isset($updated_data)){

                $data['success'] = true;
                $data['msg'] = "Income Updated Successfully";

            }else{
                $data['success'] = false;
            }
            // ဒီထဲက data ေတြကို postman မွာျပန္သံုးခ်င္ရင္ json_encoded လုပ္ေပးရတယ္
            echo json_encode($data);
            redirect('incomeApi');
        }

    
    // public function destroy($id)
    //     {
    //         $id = $_POST['id'];
    //         $this->db->delete('incomes', $id);
    //         setMessage("Income Data has been Deleted");
        
    //         redirect('income');
    //     }
    public function destroy($id)
        {
            $body = json_decode(file_get_contents('php://input'));
            
            // $id = $body->id;

            $income = new IncomeModel();
            
            $income->setId($id);

            $isdestroy = $this->db->delete('incomes', $income->getId());
            // $this->db->delete('incomes', $id);
            setMessage("success","Income Data has been Deleted");
            
            redirect('income');
        }

        public function import()
            {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // $temp = $_FILES['file']['tmp_name'];
                    // print_r($temp);
                    session_start();
                    if (file_exists($_FILES['file']['tmp_name'])) {
                        $fileName = $_FILES['file']['tmp_name'];
                        $handle = fopen($fileName, 'r');
                        // print_r($handle);
                        // exit;
                        if ($handle !== FALSE) {
                            $header = fgetcsv($handle);
                            array_flip($header);
                            while($data = fgetcsv($handle)) {
                                // print_r($data);
                                // exit;
                                $category= $data[0];
                                // print_r($category);
                                // exit;
                                $amount = $data[1];
                                $date = $data[2];
                                
                                $user_id = base64_decode($_SESSION['id']);
                                // echo $user_id;
                                // exit;
                                $isColumnExist = $this->db->columnFilter('categories', 'name', $data[0]);
                                // print_r($isColumnExist);
                                if ($isColumnExist) {
                                    $c_id = $this->db->getByCategoryId('categories', $data[0]);
                                    $category_id = implode($c_id);
                                    $this->model('IncomeModel');
                                    $income = new IncomeModel();
                                    $income->setAmount($amount);
                                    $income->setCategoryId($category_id);
                                    $income->setUserId($user_id);
                                    $income->setDate($date);
                                    $isCreated = $this->db->create('incomes', $income->toArray());
                                    redirect('income');
                                } else {
                                    $name = $data[0];
                                    $type_id = 1;
                                    $description = 'Automatic fill';
                                    $category = $this->model('CategoryModel');
                                    $category->setName($name);
                                    $category->setDescription($description);
                                    $category->setTypeId($type_id);

                                    $c_id = $this->db->create('categories', $category->toArray());
                                    // $category_id = implode($c_id);
                                    $this->model('IncomeModel');
                                    $income = new IncomeModel();
                                    $income->setAmount($amount);
                                    $income->setCategoryId($c_id);
                                    $income->setUserId($user_id);
                                    $income->setDate($date);
                                    $isCreated = $this->db->create('incomes', $income->toArray());
                                    redirect('income');
                                };
                            }
                        }
                    }
                }
            }
}