<?php

class Event {
    private $name;
    private $desc;
    private $who;
    private $date;
    private $img;
    private $eid;

    public function __construct($_eid, $_name, $_desc, $_who, $_date, $_img) {
        global $eid, $name, $desc, $who, $date, $img;
        $eid = $_eid;
        $name = $_name;
        $desc = $_desc;
        $date = $_date;
        $img = $_img;
    }

    public function get() {
        global $eid, $name, $desc, $who, $date, $img;
        if ($img == null) {
            $img = '../images/ic_entertainment.png';
        }
        $uid = $_SESSION['uid'];
        $db = new DB();
        if ($db->events_belong_to($eid, $uid)) {
            return "<div class='event'>
                <img style='object-fit: cover' height='250px' width='250px' src='$img'>
                <div>
                <h2 style='max-height: 40px; overflow: hidden'>$name</h2>
                <p>$desc</p>
                <a href='viewactivity.php?eid=$eid'><button>See More</button></a>
                <a onclick='deleteEvent($eid)' id='delete' style='text-decoration: underline; cursor: pointer; color: red'>delete</a>
                </div>
            </div>";
        } else {
            return "<div class='event'>
                <img style='object-fit: cover' height='250px' width='250px' src='$img'>
                <div>
                <h2 style='max-height: 40px; overflow: hidden'>$name</h2>
                <p>$desc</p>
                <a href='viewactivity.php?eid=$eid'><button>See More</button></a>
                <a onclick='unsubscribe($eid)' id='delete' style='text-decoration: underline; cursor: pointer; color: red'>unsubscribe</a>
                </div>
            </div>";
        }

        // "<article name='event' class='event'>
        //     <div style='flex-direction: row; display: flex'>
        //         <img style='align-self: center' src='../images/ic_entertainment.png' width='100px' height='100px' />
        //         <div>
        //             <header>
        //                 <h1 style='margin: 1px'>$name</h1>
        //                 <caption>
        //                     $date
        //                 </caption>
        //             </header>
        //             <p class='eventDesc'>
        //                 <small class='eventDesc'>$desc</small>
        //             </p>
        //         </div>
        //     </div>
        // </article>";
    }
}

?>