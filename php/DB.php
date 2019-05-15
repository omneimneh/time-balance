<?php

class DB {
    const HOST = '127.0.0.1';
    const USERNAME = 'root';
    const PASSWORD = '';
    const DB_NAME = 'time_balance';

    private $myPDO;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        global $myPDO;
        $myPDO = new PDO("mysql:host=" . DB::HOST . ";dbname=" . DB::DB_NAME, DB::USERNAME, DB::PASSWORD);
        return $myPDO != null;
    }

    public function is_connected() {
        global $myPDO;
        return $myPDO != null;
    }

    public function disconnect() {
        global $myPDO;
        $myPDO = null;
    }

    public function get_blogs() {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `blogs` LIMIT 8");
        $query->execute();
        return $query;
    }

    public function get_error() {
        global $myPDO;
        return $myPDO->errorInfo();
    }

    public function get_user_with_id($uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `users` WHERE `uid` = :id");
        $query->execute([':id' => $uid]);
        return $query->fetch(PDO::FETCH_ASSOC);

    }

    public function get_user_with_email($email) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $query->execute([':email' => $email]);
        return $query->fetch(PDO::FETCH_ASSOC);

    }

    public function sign_in_with($email, $password) {
        global $myPDO;
        if (empty($email) || empty($password)) {
            return false;
        }
        $query = $myPDO->prepare("SELECT * FROM `users` WHERE `email` LIKE :email AND `password` LIKE :pass");
        $query->bindParam(':email', $email);
        $query->bindParam(':pass', $password);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function account_exists($email) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `users` WHERE :email LIKE `email`");
        $query->execute([':email' => $email]);
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function create_account($username, $password, $email) {
        global $myPDO;
        if (empty($username) || empty($password) || empty($email)) {
            return false;
        }
        if (!$this->account_exists($email)) {
            $query = $myPDO->prepare("INSERT INTO `users` (`username`, `password`, `email`) VALUES (:username, :pass, :email)");
            $query->execute([':username' => $username, ':pass' => $password, ':email' => $email]);
            return $myPDO->lastInsertId();
        }
        return false;
    }

    public function get_public_events($long, $lat, $limit) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `events` WHERE `type` LIKE 'public' AND `date` >= NOW()
        ORDER BY POWER(`longitude` - '$long', 2) + POWER(`latitude` - '$lat', 2) LIMIT $limit");
        if ($query->execute()) {
            return $query;
        }
        return false;
    }

    public function get_event($eid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `events` WHERE `eid` = $eid");
        if ($query->execute() && ($event = $query->fetch(PDO::FETCH_ASSOC))) {
            return $event;
        }
        return false;
    }

    public static function intToTime($int) {
        return str_pad((string) (int) ($int / 3600), 2, '0', STR_PAD_LEFT)
        . ":"
        . str_pad((string) (int) ($int / 60 % 60), 2, '0', STR_PAD_LEFT)
        . ":"
        . str_pad((string) ($int % 60), 2, '0', STR_PAD_LEFT);
    }

    public function insert_event($name, $desc, $type, $start, $duration, $longitude, $latitude, $image) {
        global $myPDO;
        $query = $myPDO->prepare("INSERT INTO `events`
        (`name`, `description`, `type`, `date`, `duration`, `longitude`, `latitude`, `uid`, `image`)
        VALUES (:n, :d, :t, :s, :dur, :lng, :lat, :id, :img)");
        if ($query->execute([
            ":n" => $name,
            ":d" => $desc,
            ":t" => $type,
            ":s" => $start,
            ":dur" => $duration,
            ":lng" => $longitude,
            ":lat" => $latitude,
            ":id" => $_SESSION['uid'],
            ":img" => $image])) {
            $this->subscribe_to_event($myPDO->lastInsertId(), $_SESSION['uid']);
            return true;
        } else {
            return false;
        }
    }

    public function get_study_sessions($uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `study_sessions` WHERE `uid` LIKE :id");
        if ($query->execute([":id" => $uid])) {
            return $query;
        }
        return false;
    }

    public function subscribe_to_event($eid, $uid) {
        global $myPDO;
        $query = $myPDO->prepare("INSERT INTO `subscriptions` (`eid`, `uid`) VALUES (:eid, :id)");
        if ($query->execute([":eid" => $eid, ":id" => $uid])) {
            return $query;
        }
        return false;
    }

    public function is_subscribed($eid, $uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `subscriptions` WHERE `eid` = :eid AND `uid` = :id");
        if ($query->execute([":eid" => $eid, ":id" => $uid])) {
            return $query->rowCount() > 0;
        } else {
            return false;
        }
    }

    public function get_subscribed_events($uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `events` WHERE `eid` IN (SELECT `eid` FROM `subscriptions` WHERE `uid` = :id)");
        if ($query->execute([":id" => $uid])) {
            return $query;
        }
        return false;
    }

    public function delete_event($eid) {
        global $myPDO;
        $query1 = $myPDO->prepare("DELETE FROM `events` WHERE `eid` = :eid");
        $query2 = $myPDO->prepare("DELETE FROM `subscriptions` WHERE `eid` = :eid");
        $query3 = $myPDO->prepare("DELETE FROM `notifications` WHERE `eid` = :eid");
        $v = [":eid" => $eid];
        if ($query1->execute($v) && $query2->execute($v) && $query3->execute($v)) {
            return true;
        }
        return false;
    }

    public function events_belong_to($eid, $uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT `uid` FROM `events` WHERE `eid` = :eid");
        if ($query->execute([":eid" => $eid])) {
            if ($uid == $query->fetch(PDO::FETCH_ASSOC)['uid']) {
                return true;
            }
        }
        return false;
    }

    public function set_planned_time($uid, $studyHours, $entertainHours) {
        global $myPDO;
        $query = $myPDO->prepare("UPDATE `users` SET `studyHours` = :sh, `entertainHours` = :eh WHERE `uid` LIKE :id");
        if ($query->execute([":sh" => $studyHours, ":eh" => $entertainHours, ":id" => $uid])) {
            return true;
        }
        return false;
    }

    public function unsbuscribe($eid, $uid) {
        global $myPDO;
        $query = $myPDO->prepare("DELETE FROM `subscriptions` WHERE `eid` = :eid AND `uid` = :id");
        if ($query->execute([":eid" => $eid, ":id" => $uid])) {
            return true;
        }
        return false;
    }

    public function actual_study_hours($uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT `duration` FROM `study_sessions` WHERE yearweek(`date`) = yearweek(now()) AND `uid` = :id");
        if ($query->execute([":id" => $uid])) {
            $secs = 0;
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $secs += $row['duration'];
            }
            return $secs / 3600;
        }
        return false;
    }

    public function actual_entertain_hours($uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT `duration` FROM `events` WHERE yearweek(`date`) = yearweek(now())
        AND `eid` IN (SELECT `eid` FROM `subscriptions` WHERE `uid` = :id)");
        if ($query->execute([":id" => $uid])) {
            $secs = 0;
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $secs += $row['duration'];
            }
            return $secs / 3600;
        }
        return false;
    }

    public function notify($email, $title, $message, $url, $eid) {
        global $myPDO;
        $uid = $this->get_user_with_email($email)['uid'];
        $exists = $myPDO->prepare("SELECT * FROM `invitations` WHERE `eid` LIKE :eid AND `uid` = :id");
        $exists->execute([":id" => $_SESSION['uid'], ":eid" => $eid]);
        if ($exists->rowCount() > 0) {
            return true;
        }
        $exists = $myPDO->prepare("SELECT * FROM `notifications` WHERE `title` = :title AND `uid` = :id");
        $exists->execute([":id" => $_SESSION['uid'], ":title" => $title]);
        if ($exists->rowCount() > 0) {
            return true;
        }
        $query = $myPDO->prepare("INSERT INTO `notifications` (`uid`, `title`, `message`, `url`, `eid`) VALUES (:id, :title, :msg, :link, :eid)");
        $query2 = $myPDO->prepare("INSERT INTO `invitations` (`uid`, `eid`) VALUES (:id, :eid)");
        if ($query->execute(["id" => $uid, ":title" => $title, ":msg" => $message, ":link" => $url, ":eid" => $eid])) {
            $query2->execute(["id" => $uid, ":eid" => $eid]);
            return $myPDO->lastInsertId();
        }
        return false;
    }

    public function get_active_notifications($uid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `notifications` WHERE `uid` = :id");
        if ($query->execute([":id" => $uid])) {
            return $query;
        }
        return false;
    }

    public function dismiss_notifications($uid) {
        global $myPDO;
        $query = $myPDO->prepare("DELETE FROM `notifications` WHERE `uid` = :id");
        if ($query->execute([":id" => $uid])) {
            return $query;
        }
        return false;
    }

    public function is_allowed($uid, $eid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT `type` FROM `events` WHERE `eid` = :eid AND `type` LIKE 'public'");
        if ($query->execute([":eid" => $eid])) {
            if ($query->fetch(PDO::FETCH_ASSOC)) {
                if ($query->rowCount() > 0) {
                    return true;
                }
            }
        }
        $query = $myPDO->prepare("SELECT null FROM `subscriptions` WHERE `uid` = :id AND `eid` = :eid");
        if ($query->execute([":id" => $uid, ":eid" => $eid])) {
            if ($query->rowCount() > 0) {
                return true;
            }
        }
        $query = $myPDO->prepare("SELECT null FROM `invitations` WHERE `uid` = :id AND `eid` = :eid");
        if ($query->execute([":id" => $uid, ":eid" => $eid])) {
            if ($query->rowCount() > 0) {
                return true;
            }
        }
        return false;
    }

    public function get_users() {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `users` WHERE `admin` LIKE 'false'");
        if ($query->execute()) {
            return $query;
        }
        return false;
    }

    public function delete($uid) {
        global $myPDO;
        $query = $myPDO->prepare("DELETE FROM `users` WHERE `uid` = :id");
        if ($query->execute([":id" => $uid])) {
            return true;
        }
        return false;
    }

    public function add_blog($title, $message) {
        $message = htmlentities($message);
        $message = str_replace("*!", "<b>", $message);
        $message = str_replace("!*", "</b>", $message);
        $message = str_replace("_!", "<i>", $message);
        $message = str_replace("!_", "</i>", $message);
        $title = htmlentities($title);
        $message = $this->closetags($message);

        global $myPDO;
        $query = $myPDO->prepare("INSERT INTO `blogs` (`title`, `content`) VALUES (:title, :content)");
        if ($query->execute([":title" => $title, ":content" => $message])) {
            return true;
        }
        return false;
    }

    private function closetags($html) {
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</' . $openedtags[$i] . '>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    public function add_study_session($uid, $name, $duration) {
        global $myPDO;
        $query = $myPDO->prepare("INSERT INTO `study_sessions` (`uid`, `name`, `duration`) VALUES (:id, :tag, :duration)");
        if ($query->execute([":id" => $uid, ":tag" => $name, ":duration" => $duration])) {
            return true;
        }
        return false;
    }

    public function random_event() {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `random_events` ORDER BY RAND() LIMIT 1");
        if ($query->execute()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function get_random_event($rid) {
        global $myPDO;
        $query = $myPDO->prepare("SELECT * FROM `random_events` WHERE `rid` = :rid");
        if ($query->execute([":rid" => $rid])) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}

?>