<?php
 
    $q = $_GET['q'];
    
    $s = $_GET['s'];
    
    $result = "";
    
    // lookup all result from array if $q is different from ""
    if ($s == 'membername') {
        if ($q !== "") {
            $query = strtolower($q);
            $len=strlen($query);
            
            $results = $mysqli->query("SELECT * FROM members WHERE CONCAT_WS(\" \", firstname, lastname) LIKE  '%$query%' ORDER BY firstname ASC");
            while($name = $results->fetch_object()) {
                $username = $name->firstname + " " + $name->lastname;
                if (stristr($query, substr($username, 0, $len))) {
                    if ($result === "") {
                        $result = $username;
                    } else {
                        $result .= "<br /> $username";
                    }
                }
            }
        }
    }
    
   else if ($s == 'threadtitle') {
        if ($q !== "") {
            $query = strtolower($q);
            $len=strlen($query);
            
            if ($userLEVEL < 4) {
                $results = $mysqli->query("SELECT * FROM forum_threads WHERE title LIKE '%$query%' AND fid != '0' ORDER BY dateline");
            }
            else {
                $results = $mysqli->query("SELECT * FROM forum_threads WHERE title LIKE '%$query%' AND deleted != '1' AND fid != '0' ORDER BY dateline");
            }
            while($name = $results->fetch_object()) {
                
                if (getForumName($name->fid) != "") {
                
                    if (stristr($query, substr($name->title, 0, $len))) {
                        if ($result === "") {
                            $result = "<p style=\"margin-top: 0.25%; margin-bottom: 0.25%\"> <u>".getForumName($name->fid)."</u> >> <a href=\"/forum-view.php?fid=$name->fid&tid=$name->tid\" target=\"_blank\">$name->title</a></p>";
                        } else {
                            $result .= "<br /> <p style=\"margin-top: 1%; margin-bottom: 1%\"> <u>".getForumName($name->fid)."</u> >> <a href=\"/forum-view.php?fid=$name->fid&tid=$name->tid\" target=\"_blank\">$name->title</a></p>";
                        }
                    }
                }
            }
        }
    }
    
   else if ($s == 'forumtitle') {
        if ($q !== "") {
            $query = strtolower($q);
            $len=strlen($query);
            
            if ($userLEVEL < 4) {
                $results = $mysqli->query("SELECT * FROM forum WHERE title LIKE '%$query%'");
            }
            else {
                $results = $mysqli->query("SELECT * FROM forum WHERE title LIKE '%$query%' AND private != '1' AND closed != '1' AND archive != '1'");
            }
            while($name = $results->fetch_object()) {
                if (stristr($query, substr($name->title, 0, $len))) {
                    if ($result === "") {
                        $result = "<a href=\"/forum.php?fid=$name->id\" target=\"_blank\">$name->title</a>";
                    } else {
                        $result .= "<br /> <a href=\"/forum.php?fid=$name->id\" target=\"_blank\">$name->title</a>";
                    }
                }
            }
        }
    }

    
    // Output "no suggestion" if no hint was found or output correct values
    echo $result === "" ? " nothing found" : $result;
    ?>
