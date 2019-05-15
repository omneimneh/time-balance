<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/home.js"></script>
    <link rel="stylesheet" href="../styles/homeStyle.css">
    <title>Time Balance | Home</title>

</head>

<body>

    <?php
include '../php/DB.php';

@session_start();
$current_user = "Sign In/Register";

$dbcon = new DB();

if (isset($_SESSION['uid'])) {
    $current_user = 'Welcome ' . $dbcon->get_user_with_id($_SESSION['uid'])['username'];
}
?>

        <header>
            <nav>
                <img class="logo" width="30px" height="30px" id="headerTitle" src="../images/sand-clock.svg">
                <span style="width: 40px"></span>
                <h2 id="headerTitle">Time Balance</h2>
                <ul>
                    <a href="home.php">
                        <li>Home</li>
                    </a>
                    <a href="study.php">
                        <li>Study</li>
                    </a>
                    <a href="myactivities.php">
                        <li>Entertain</li>
                    </a>
                    <a href="dashboard.php" class="dashboardOption">
                        <li class="dashboardOption">Dashboard</li>
                    </a>
                    <a href="login.php?logout=true">
                        <li>Logout</li>
                    </a>
                    <a href="login.php">
                        <li>
                            <?php echo $current_user; ?>
                        </li>
                    </a>
                </ul>
            </nav>
            <div class="moreOption">
                <img width="20px" height="20px" src="../images/ic_menu_dashes.png">
            </div>
            <ul class="mobileOptions">
                <a href="home.php">
                    <li>Home</li>
                </a>
                <a href="study.php">
                    <li>Study</li>
                </a>
                <a href="myactivities.php">
                    <li>Entertain</li>
                </a>
                <a href="dashboard.php" class="dashboardOption">
                    <li class="dashboardOption">Dashboard</li>
                </a>
                <a href="login.php?logout=true">
                    <li>Logout</li>
                </a>
                <a href="login.php">
                    <li>
                        <?php echo $current_user; ?>
                    </li>
                </a>
            </ul>

            <h1 class="introQuote">A single app for all of your lifestyle</h1>
            <h3 class="introQuote">Here you can find time for everything!</h3>
            <button onclick="window.location = 'dashboard.php'" class="startButton">Start Organizing Now</button>
            <br>
            <br>

            <div class="introTabsContainer">
                <div class="tabContainer">

                    <div style="opacity: 1;" id="tablinks" class="tablinks" onmouseover="showTab(event, 0, this)">
                        <a class="introAnchor" href="study.php">
                            <h3 style="flex: 1">Study</h3>
                        </a>
                    </div>

                    <div id="tablinks" class="tablinks" onmouseover="showTab(event, 1, this)">
                        <a class="introAnchor" href="myactivities.php">
                            <h3 style="flex: 1">Entertain</h3>
                        </a>
                    </div>
                </div>
                <div class="tabsContentContainer">
                    <div style="display: block" id="tabcontent" class="tabcontent">
                        <img style="float: right; margin: 10px" height="200px" width="200px" src="../images/ic_study.png" alt="">
                        <br>
                        <h1 style="font-weight: normal">Study</h1>
                        <ul style="font-size: 14pt; font-weight: normal">
                            <li>Find all the time needed for you to study</li>
                            <li>Ultimate productivity planner</li>
                        </ul>
                    </div>
                    <div id="tabcontent" class="tabcontent">
                        <img style="float: right; margin: 10px" height="200px" width="200px" src="../images/ic_entertainment.png" alt="">
                        <br>
                        <h1 style="font-weight: normal">Entertain</h1>
                        <ul style="font-size: 14pt; font-weight: normal">
                            <li>Find fun whenever you go!</li>
                            <li>Have a great time with friends</li>
                            <li>Discover and learn while having fun</li>
                        </ul>
                    </div>
                </div>
            </div>

        </header>

        <div class="header">
            <nav>
                <img class="logo" width="30px" height="30px" id="headerTitle" src="../images/sand-clock.svg">
                <span style="width: 40px"></span>
                <h2 id="headerTitle">Time Balance</h2>
                <ul>
                    <a href="home.php">
                        <li>Home</li>
                    </a>
                    <a href="study.php">
                        <li>Study</li>
                    </a>
                    <a href="myactivities.php">
                        <li>Entertain</li>
                    </a>
                    <a href="dashboard.php" class="dashboardOption">
                        <li class="dashboardOption">Dashboard</li>
                    </a>
                    <a href="login.php?logout=true">
                        <li>Logout</li>
                    </a>
                    <a href="login.php">
                        <li>
                            <?php echo $current_user; ?>
                        </li>
                    </a>
                </ul>
            </nav>
        </div>

        <br>
        <div class="blogTitle">
            <h1>Blogs</h1>
            <div class="blogsContainer">

                <?php
include '../php/Blog.php';
$blogs = $dbcon->get_blogs();
$zero = true;
while ($row = $blogs->fetch(PDO::FETCH_ASSOC)) {
    $blog = new Blog($row['title'], $row['content'], $row['date']);
    $blog->render();
    $zero = false;
}

if ($zero) {
    echo "<br><big>No Blogs yet!</big><br>";
}
?>

            </div>
            <br>
        </div>



        <footer>
            <div>
                <a href="https://www.facebook.com">
                    <img class="footer-icon" src="../images/facebook.svg" alt="">
                </a>
                <a href="https://www.twitter.com">
                    <img class="footer-icon" src="../images/twitter.svg" alt="">
                </a>
                <a href="https://www.youtube.com">
                    <img class="footer-icon" src="../images/youtube.svg" alt="">
                </a>
                <a href="https://www.linkedin.com">
                    <img class="footer-icon" src="../images/linkedin.svg" alt="">
                </a>
            </div>
            <div class="authors">
                <h2>Copyrights 2018</h2>
                <h3>Developers</h3>
                <h4>Omar Mneimneh</h4>
                <h4>Omar Orabi</h4>
                <h4>Hasan Hajj Hasan</h4>
                <br>
                <h4>Instructor: Dr. Islam El Kabani</h4>
                <h4>CMPS246 - Web Programing</h4>
            </div>
        </footer>

        <script type="text/javascript">
            function showTab(evt, tabName, tablink) {
                var tablinks = $('.tablinks');
                var tabcontent = $('.tabcontent');
                for (var i = 0; i < tabcontent.length; i++) {
                    tabcontent.eq(i).stop();
                    tabcontent.eq(i).hide();
                    tablinks.eq(i).css('opacity', '0.3');
                }
                $(tablink).css('opacity', '1');
                tabcontent.eq(tabName).fadeIn(400);
            }

            $(document).ready(function () {
                $(window).scroll(function (event) {
                    if ($(window).scrollTop() != 0) {
                        $('.header').css('display', 'flex');
                    } else {
                        $('.header').hide();
                    }
                });
            });
        </script>

</body>

</html>