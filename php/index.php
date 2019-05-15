<?php

@session_start();

if (isset($_POST['function'])) {

    switch ($_POST['function']) {
    case 'sign_in':
        sign_in();
        break;
    case 'sign_up':
        sign_up();
        break;
    case 'get_public_events':
        get_public_events();
        break;
    case 'insert_event':
        insert_event();
        break;
    case 'get_study_sessions':
        get_study_sessions();
        break;
    case 'subscribe_to_event':
        subscribe_to_event();
        break;
    case 'delete_event':
        delete_event();
        break;
    case 'set_planned_time':
        set_planned_time();
        break;
    case 'unsubscribe':
        unsubscribe();
        break;
    case 'invite':
        invite();
        break;
    case 'get_active_notifications':
        get_active_notifications();
        break;
    case 'get_study_start_time':
        get_study_start_time();
        break;
    case 'set_study_start_time':
        set_study_start_time();
        break;
    case 'unset_study_start_time':
        unset_study_start_time();
        break;
    case 'add_study_session':
        add_study_session();
        break;
    case 'get_random_event':
        get_random_event();
        break;
    case 'insert_random_event':
        insert_random_event();
        break;
    }
}

function sign_in() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    $db = new DB();
    $fail = false;
    if (isset($_POST['email'])) {
        if ($r = $db->sign_in_with($_POST['email'], $_POST['password'])) {
            $_SESSION['uid'] = $r['uid'];
        } else {
            $fail = true;
        }
    } else {
        $fail = true;
    }

    echo json_encode(["success" => !$fail]);
}

function sign_up() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    $db = new DB();
    $fail = false;
    if (isset($_POST['username'])) {
        if ($a = $db->create_account($_POST['username'], $_POST['password'], $_POST['email'])) {
            $db->sign_in_with($_POST['username'], $_POST['password']);
            $_SESSION['uid'] = $a;
        } else {
            $fail = true;
        }
    } else {
        $fail = true;
    }

    echo json_encode(["success" => !$fail]);
}

function get_public_events() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    include "../php/Event.php";
    $db = new DB();
    $fail = false;
    if (isset($_POST['longitude']) && isset($_POST['latitude'])) {
        $columns = $db->get_public_events($_POST['longitude'], $_POST['latitude'], 10);
        $result = [];
        while ($row = $columns->fetch(PDO::FETCH_ASSOC)) {
            $result[] =
                [
                "name" => $row['name'],
                "longitude" => $row['longitude'],
                "latitude" => $row['latitude'],
                "description" => $row['description'],
                "uid" => $row['uid'],
                "date" => $row['date'],
                "image" => $row['image'],
                "eid" => $row['eid'],
            ];
        }
        echo json_encode(["events" => $result, "success" => true]);
    } else {
        echo json_encode(["success" => false, "sql_error" => $db->get_error()]);
    }
}

function insert_event() {
    //header("Content-Type: application/json");
    include "../php/DB.php";
    if (isset($_POST['longitude'])
        && isset($_POST['latitude'])
        && isset($_POST['name'])
        && isset($_POST['description'])
        && isset($_POST['type'])
        && isset($_POST['time'])
        && isset($_POST['date'])
        && isset($_POST['hours'])
        && isset($_POST['minutes'])) {

        $db = new DB();
        if (file_exists($_FILES['image']['tmp_name'])) {
            $info = $_FILES['image']['name'];
            $file = random_string(20) . ".png";
            $file = "../uploads/$file";
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
        } else {
            $file = null;
        }
        if ($db->insert_event($_POST['name'],
            $_POST['description'],
            $_POST['type'],
            $_POST['date'] . " " . $_POST['time'],
            toSeconds($_POST['hours'], $_POST['minutes']),
            $_POST['longitude'],
            $_POST['latitude'],
            $file)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }

    }

    header('Location: ../web/myactivities.php');
}

function toSeconds($h, $m) {
    return $h * 3600 + $m * 60;
}

function get_study_sessions() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    if (isset($_SESSION['uid'])) {
        $db = new DB();
        $query = $db->get_study_sessions($_SESSION['uid']);
        if ($query) {
            $result = [];
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
            echo json_encode(["success" => true, "sessions" => $result, "count" => $query->rowCount()]);
        } else {
            echo json_encode(["success" => false, "cause" => "sql_failure"]);
        }
    } else {
        echo json_encode(["success" => false, "cause" => "invalid_session_id"]);
    }
}

function subscribe_to_event() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    if (!isset($_SESSION['uid']) || !isset($_POST['eid'])) {
        echo json_encode(["success" => false, "cause" => "eid or uid is not set"]);
    } else {
        $db = new DB();
        if ($db->subscribe_to_event($_POST['eid'], $_SESSION['uid'])) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }
}

function delete_event() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    if (isset($_POST['eid'])) {
        $db = new DB();
        if ($db->events_belong_to($_POST['eid'], $_SESSION['uid'])) {
            if ($db->delete_event($_POST['eid'])) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
        } else {
            echo json_encode(["success" => false, "cause" => "Forbidden"]);
        }

    } else {
        echo json_encode(["success" => false]);
    }
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

function set_planned_time() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    $studyHours = $_POST['studyHours'];
    $entertainHours = $_POST['entertainHours'];
    $db = new DB();
    if ($db->set_planned_time($_SESSION['uid'], $studyHours, $entertainHours)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}

function unsubscribe() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    $eid = $_POST['eid'];
    $db = new DB();
    if (!$db->events_belong_to($eid, $_SESSION['uid'])) {
        if ($db->unsbuscribe($eid, $_SESSION['uid'])) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => true, "cause" => "forbidden"]);
        }
    } else {
        echo json_encode(["success" => true]);
    }
}

function invite() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    $email = $_POST['email'];
    $db = new DB();
    $uid = $_SESSION['uid'];
    if ($email == $db->get_user_with_id($uid)['email']) {
        echo json_encode(["success" => false, "error" => "self"]);
        return;
    }
    $user = $db->get_user_with_id($uid)['username'];
    $event = $db->get_event($_POST['eid'])['name'];
    $eid = $_POST['eid'];
    if ($db->account_exists($email)) {
        $r = $db->notify($email, "Someone invited you to an event!",
            "You've been invited by $user to '$event'", "viewactivity.php?eid=$eid", $eid);
        echo json_encode(["success" => true, "debug" => $r]);
    } else {
        echo json_encode(["success" => false]);
    }
}

function get_active_notifications() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    if (!isset($_SESSION['uid'])) {
        echo json_encode(array());
        return;
    }
    $uid = $_SESSION['uid'];
    $db = new DB();
    $r = $db->get_active_notifications($uid);
    $notifications = [];
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
        $notifications[] = $row;
    }
    echo json_encode($notifications);
}

function get_study_start_time() {
    if (isset($_SESSION['timer'])) {
        echo $_SESSION['timer'];
    } else {
        header("Content-Type: application/json");
        echo json_encode(["fail" => true]);
    }

}

function set_study_start_time() {
    $_SESSION['timer'] = $_POST['timer'];
    $_SESSION['tag'] = $_POST['tag'];
}

function unset_study_start_time() {
    unset($_SESSION['timer']);
}

function add_study_session() {
    $tag = $_SESSION['tag'];
    $time = $_POST['time'];
    unset($_SESSION['tag']);
    unset($_SESSION['timer']);
    include "../php/DB.php";
    $db = new DB();
    $db->add_study_session($_SESSION['uid'], $tag, $time);
}

function get_random_event() {
    header("Content-Type: application/json");
    include "../php/DB.php";
    $db = new DB();
    echo json_encode($db->random_event());
}

function insert_random_event() {
    $uid = $_SESSION['uid'];
    include '../php/DB.php';
    $db = new DB();
    $event = $db->get_random_event($_POST['rid']);
    $db->insert_event($event['name'], $event['description'], 'private', date("Y-m-d H:i:s"), 7200, 0, 0, "../random/" . $_POST['rid'] . '.png');
}

?>

