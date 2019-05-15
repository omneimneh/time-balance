<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/adminStyle.css">
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/admin.js"></script>
    <title>Time Balance | Admin</title>
    <style>
        html,
        body {
            height: 100%;
            background-color: #F2F2F2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            height: 100%;
            max-width: 1200px;
        }

        .blogWrite {
            width: 100%;
            height: 200px;
            resize: none;
            font-family: monospace;
        }

        .div1 {
            flex: 1;
        }

        .div2 {
            flex: 1;
        }

        .section {
            background-color: white;
            margin: 12px;
            padding: 30px;
            box-shadow: #26262650 0px 0px 4px;
        }

        #left {
            margin-right: 6px;
        }

        #right {
            margin-left: 6px;
        }

        #created_activities {
            min-height: 500px;
        }

        @media only screen and (max-width: 720px) {
            .container {
                flex-direction: column;
            }
            #left {
                margin: 12px;
            }

            #right {
                margin: 12px;
            }
        }
    </style>
</head>

<body>
    <?php include '../templates/header.html';?>
    <?php

$db = new DB();
if (!isset($_SESSION['uid'])) {
    header('Location: login.php');
} else if ($db->get_user_with_id($_SESSION['uid'])['admin'] != 'true') {
    header('Location: login.php');
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
    case 'delete_user':
        $db->delete($_GET['uid']);
        break;
    case 'delete_event':
        $db->delete_event($_GET['eid']);
        break;
    }

    header('Location: admin.php');
}

if (isset($_POST['title'])) {
    echo $db->add_blog($_POST['title'], $_POST['message']);
    header('Location: home.php');
}
?>
    <div class="container" style="display: flex">
        <div class="div1">
            <div id="left" class="section">
                <h2>Upload a Blog</h2>
                <form action="admin.php" method="post">
                    <input required placeholder="Blog Title" type="text" name="title">
                    <br>
                    <br>
                    <textarea required name="message" placeholder="Write down your blog.." class="blogWrite" name=""
                    id=""></textarea>
                    <span style="font-family: monospace; color: green">Hint: normal text *!<b> bold text </b>!* _!<i> italic text </i>!_</span>
                    <br>
                    <br>
                    <input type="submit">
                </form>
            </div>
            <div id="left" class="section">
            <h2>Users</h2>
            <div id="users">
                <?php

$users = $db->get_users();
echo "<table border='border'>";
echo "<td>User ID</td></td><td>Username</td><td>Email</td><td>Ban User</td>";
while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr><td>"
        . $row['uid']
        . "</td><td>"
        . $row['username']
        . "</td><td>"
        . $row['email']
        . "</td><td>"
        . "<a style='cursor: pointer; color: red; text-decoration: underline'
        onclick=\"confirmLink('admin.php?action=delete_user&uid=" . $row['uid'] . "')\")'>
        Delete This User
        </a></td></tr>";
}
echo "</table>";
?>
                </div>
            </div>
        </div>
            <div class="div2">
                <div id="right" class="section">
                    <h2>Review Events</h2>
                    <div id="created_activities"></div>
                </div>
            </div>
            <br>
        </div>
    </div>
</body>

</html>