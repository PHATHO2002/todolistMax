 <?php
    require_once dirname(__DIR__) . '\config\database.php';

    use Models\TaskModel;

    require_once dirname(__DIR__) . '\models\task.php';
    require_once dirname(__DIR__) . '\controller\BaseController.php';

    class TaskController extends BaseController
    {
        public function __construct()
        {
            try {
                $this->db = getDatabaseConnection();
                $this->model = new TaskModel($this->db);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'message' => 'Không thể kết nối với cơ sở dữ liệu. Chi tiết lỗi: ' . $e->getMessage(),
                    'data' => null
                ]);
                exit();
            }
        }
        public function selectAll()
        {
            $this->checkSession();
            $respone = $this->model->selectByfiled('user_id', $_SESSION['userdata']['user_id'] ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function createTask()
        {
            $this->checkSession();
            $respone = $this->model->createTask($_SESSION['userdata']['user_id'] ?? null, $_POST);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function getOneTask()
        {
            $this->checkSession();
            $respone = $this->model->selectOneByfiled('task_id', $_GET['task_id'] ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function searchByTitle()
        {
            $this->checkSession();
            $respone = $this->model->selectByfiled('title', $_GET['title'] ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function delete()
        {
            $this->checkSession();
            $respone = $this->model->deleteOneByFiled('task_id', $_POST['task_id'] ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function updateTask()
        {
            $this->checkSession();
            $respone = $this->model->update($_POST['task_id'] ?? null, $_POST ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function filterByStatusPriority()
        {
            $this->checkSession();
            $respone = $this->model->filterByStatusPriority($_POST['status'] ?? null, $_POST['priority'] ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
        public function updateCompletes()
        {
            $this->checkSession();

            $respone = $this->model->updateCompletes($_POST['task_ids'] ?? null);
            $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
        }
    }
