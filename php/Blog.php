<?php
class Blog {
    private $title = null;
    private $content = null;
    private $date = null;

    public function __construct($_title, $_content, $_date) {
        global $title, $content, $date;
        $title = $_title;
        $content = $_content;
        $date = $_date;
    }

    public function render() {
        global $title, $content, $date;
        echo "<article class='user_review'>
                <h1>$title</h1>
                <p class='content'>$content</p>
                <footer>
                    <div>
                        Posted on $date
                        by Admin.
                    </div>
                </footer>
            </article>";
    }
}
?>
<!-- end -->
