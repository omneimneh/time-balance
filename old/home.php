<!DOCTYPE html>
<html lang="en">

<head>
    <title>Time Balance - Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/home.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>

    <style>
        body {
            display: block;
        }

        img:hover.zoomable {
            transform: scale(1.2) translate(0pt, -20pt);
            transition: all 2s;
            transition-timing-function: cubic-bezier(0, .6, .2, 1);
        }

        img.zoomable {
            -webkit-filter: drop-shadow(5px 5px 5px #222);
            filter: drop-shadow(5px 5px 5px #222);
            border-radius: 100%;
            transition: all 2s;
            transition-timing-function: cubic-bezier(0, .6, .2, 1);
        }

        .container {
            position: relative;
            top: 46pt;
            user-select: none;
            width: 100%;
            height: calc(100% - 46pt - 16pt);
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: stretch;
            background-color: transparent;
        }

        .leftPanel,
        .rightPanel {
            position: relative;
            top: 0;
            left: 0;
            overflow: hidden;
            flex: 1;
            cursor: pointer;
            transition: all 0.7s ease;
            transition-timing-function: cubic-bezier(0, .6, .2, 1);
        }

        .leftPanel .inside,
        .rightPanel .inside {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            background-repeat: no-repeat;
            text-shadow: #ddd6 1pt 1pt 2pt;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
            flex: 1;
            cursor: pointer;
        }

        .leftPanel:before,
        .rightPanel:before {
            overflow: hidden;
            content: "";
            position: relative;
            left: 0;
            right: 0;
            display: block;
            background-size: cover;
            width: 100%;
            height: 100%;
            transition: all 0.7s;
        }

        .leftPanel:hover:before,
        .rightPanel:hover:before {
            transition: all 0.7s;
            -webkit-filter: blur(5px);
            -moz-filter: blur(5px);
            -o-filter: blur(5px);
            -ms-filter: blur(5px);
            filter: blur(5px);
        }

        .rightPanel:before {
            background-image: url("../images/ic_entertainment_background.png");
        }

        .leftPanel:before {
            background-image: url("../images/ic_study_background.png");
        }

        .leftPanel p,
        .rightPanel p {
            color: rgb(225, 230, 236);
            font-size: 14pt;
        }

        .leftPanel h1,
        .rightPanel h1 {
            font-size: 25pt;
        }

        @media only screen and (max-height: 480px) {
            html,
            body {
                height: auto;
            }
            .container {
                height: auto;
            }

            .leftPanel,
            .rightPanel {
                min-height: 720px;
            }

            .leftPanel:before,
            .rightPanel:before {
                min-height: 720px;
            }
        }

        @media only screen and (max-width: 720px) {
            .container {
                flex-direction: column;
            }

            .zoomable {
                width: 86pt;
                height: 86pt;
                padding: 8pt;
            }

            h1 {
                margin: 2pt;
                font-size: 14pt;
            }

            i {
                font-size: 8pt;
            }

            .leftPanel p,
            .rightPanel p {
                color: white;
                font-size: 9pt;
            }

            .leftPanel h1,
            .rightPanel h1 {
                font-size: 16pt;
            }
        }
    </style>
</head>

<body>
    <div class="container" id="container">
        <div class="leftPanel">
            <div class="inside">
                <a href="../web/study.php">
                    <img class="zoomable" style="align-self: center" width="220pt" height="220pt" src="../images/ic_study.png" />
                </a>
                <h1 style="min-width: 80pt;">Stay focused, Study, Produce...</h1>
                <p>
                    <i>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut placerat, magna vel facilisis ultrices, libero
                        dui sodales eros, in iaculis quam tellus in velit. Pellentesque ut sollicitudin dolor. Donec quam
                        nunc, pharetra vel lacinia nec, facilisis et libero. Phasellus dapibus finibus enim id viverra.</i>
                </p>
            </div>
        </div>
        <div class="rightPanel">
            <div class="inside">
                <a href="../web/myactivities.php">
                    <img class="zoomable" style="align-self: center" width="220pt" height="220pt" src="../images/ic_entertainment.png" />
                </a>
                <h1 style="min-width: 80pt;">Play, Entertain, Find activities...</h1>
                <p>
                    <i>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut placerat, magna vel facilisis ultrices, libero
                        dui sodales eros, in iaculis quam tellus in velit. Pellentesque ut sollicitudin dolor. Donec quam
                        nunc, pharetra vel lacinia nec, facilisis et libero. Phasellus dapibus finibus enim id viverra.</i>
                </p>
            </div>
        </div>
    </div>

    <?php include "../templates/header.html";?>
    <?php include "../templates/menu.html";?>
    <?php include "../templates/loginBox.html";?>
    <?php include "../templates/footer.html";?>

</body>

</html>