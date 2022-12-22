<?php
include_once 'src/util/Request.php';
include_once 'src/util/Router.php';

require_once 'src/model/database.php';
require_once 'src/model/student_model.php';

require_once 'src/controller/student_controller.php';

// CORS
header('Access-Control-Allow-Origin: *');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'
);
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');

// Database
$db = new Database();

// Create Tables if they don't exists yet
$db->create_tables();

// Controllers
$student_controller = new StudentController($db);

// Router
$router = new Router(new Request());

$router->get('/', function () {
    return <<<HTML
  <h1>Hello world</h1>
HTML;
});

$router->post('/register', function (Request $request) {
    $req_data = $request->getBody();
    if (
        !isset($req_data->firstName) ||
        !isset($req_data->lastName) ||
        !isset($req_data->matric) ||
        !isset($req_data->password)
    ) {
        http_response_code(400);
        return json_encode([
            'status' => 400,
            'message' => 'Incomplete details',
        ]);
    }

    global $student_controller;
    $student = $student_controller->register(
        $req_data->firstName,
        $req_data->lastName,
        $req_data->matric,
        $req_data->password
    );

    if (isset($student)) {
        http_response_code(201);
        return json_encode([
            'status' => 201,
            'message' => 'Student Created Successfully',
            'data' => $student,
        ]);
    } else {
        http_response_code(500);
        return json_encode([
            'status' => 500,
            'message' => 'Internal Server Error',
        ]);
    }
});

$router->post('/login', function (Request $request) {
    $req_data = $request->getBody();
    if (!isset($req_data->matric) || !isset($req_data->password)) {
        http_response_code(400);
        return json_encode([
            'status' => 400,
            'message' => 'Incomplete details',
        ]);
    }

    global $student_controller;
    $token = $student_controller->login($req_data->matric, $req_data->password);

    if (isset($token)) {
        http_response_code(201);
        return json_encode([
            'status' => 201,
            'message' => 'Student login Successfully',
            'data' => $token,
        ]);
    } else {
        http_response_code(500);
        return json_encode([
            'status' => 500,
            'message' => 'Internal Server Error',
        ]);
    }
});

$router->post('/schedule-appointment', function (Request $request) {
    $req_data = $request->getBody();
    if (
        !isset($req_data->days_available_id) ||
        !isset($req_data->student_id) ||
        !isset($req_data->appointment_date) ||
        !isset($req_data->status)
    ) {
        http_response_code(400);
        return json_encode([
            'status' => 400,
            'message' => 'Incomplete details',
        ]);
    }

    global $student_controller;
    $body = [
        'days_available_id' => $req_data->days_available_id,
        'student_id' => $req_data->student_id,
        'appointment_date' => $req_data->appointment_date,
        'status' => $req_data->status,
        'message' => $req_data->message,
    ];
    $appointment_request = $student_controller->createAppointmentRequest($body);

    if (isset($appointment_request)) {
        http_response_code(201);
        return json_encode([
            'status' => 201,
            'message' => 'Appointment Schedule Request Created Successfully',
            'data' => $appointment_request,
        ]);
    } else {
        http_response_code(500);
        return json_encode([
            'status' => 500,
            'message' => 'Internal Server Error',
        ]);
    }
});
