<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];


	include 'library/config.php';
    include 'library/opendb.php';

    // declaring variables
    $groupname = "";
    $value = "";
    $operator = "";
    $attribute = "";

	$groupname = $_REQUEST['groupname'];
	$value = $_REQUEST['value'];

        // fill-in nashost details in html textboxes
        $sql = "SELECT * FROM radgroupreply WHERE GroupName='$groupname' AND Value='$value'";
        $res = mysql_query($sql) or die('Query failed: ' . mysql_error());
        $row = mysql_fetch_array($res);		// array fetched with values from $sql query

        if (isset($_POST['submit'])) {
	        $groupname = $_POST['groupname'];
	        $value = $_POST['value'];;
	        $valueOld = $_POST['valueOld'];;			
	        $operator = $_POST['operator'];;
	        $attribute = $_POST['attribute'];;

                include 'library/config.php';
                include 'library/opendb.php';

                $sql = "SELECT * FROM radgroupreply WHERE GroupName='$groupname' AND Value='$value'";
                $res = mysql_query($sql) or die('Query failed: ' . mysql_error());

                if (mysql_num_rows($res) == 1) {

                        if (trim($groupname) != "" and trim($value) != "" and trim($operator) != "" and trim($attribute) != "") {

                            $sql = "UPDATE radgroupreply SET Value='$value', op='$operator', Attribute='$attribute' WHERE GroupName='$groupname' AND Value='$valueOld'";
                            $res = mysql_query($sql) or die('Query failed: ' . mysql_error());
                        
			echo "<font color='#0000FF'>success<br/></font>";

			}

                } else {
                        echo "<font color='#FF0000'>error: more than one instance of $groupname and $value <br/></font>";
			echo "
                                <script language='JavaScript'>
                                <!--
                                alert('The group $groupname already exists in the database with value $value.\\nPlease check that there are no duplicate entries in the database.');
                                -->
                                </script>
                                ";
                } 

                include 'library/closedb.php';
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<SCRIPT TYPE="text/javascript">
<!--
function toggleShowDiv(pass) {

        var divs = document.getElementsByTagName('div');
        for(i=0;i<divs.length;i++) {
                if (divs[i].id.match(pass)) {
                        if (document.getElementById) {                                         
                                if (divs[i].style.display=="inline")
                                        divs[i].style.display="none";
                                else
                                        divs[i].style.display="inline";
                        } else if (document.layers) {                                           
                                if (document.layers[divs[i]].display=='visible')
                                        document.layers[divs[i]].display = 'hidden';
                                else
                                        document.layers[divs[i]].display = 'visible';
                        } else {
                                if (document.all.hideShow.divs[i].visibility=='visible')     
                                        document.all.hideShow.divs[i].visibility = 'hidden';
                                else
                                        document.all.hideShow.divs[i].visibility = 'visible';
                        }
                }
        }
}



// -->
</script>


<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
 
<?php
	include ("menu-mng-rad-groupreply.php");
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#">Edit Group Reply Mapping for Group: <?php echo $groupname ?></a></h2>
				
				<p>

                                <form name="newuser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                                <input type="hidden" value="<?php echo $groupname ?>" name="groupname" /><br/>

                                                <?php if (trim($attribute) == "") { echo "<font color='#FF0000'>";  }?>
	                                        <b>Attribue</b>
                                                <input value="<?php echo $attribute ?>" name="attribute" />
                                                </font><br/>

                                                <?php if (trim($operator) == "") { echo "<font color='#FF0000'>";  }?>
	                                        <b>Operator</b>
                                                <input value="<?php echo $operator ?>" name="operator" /> 
                                                </font><br/>
												
                                                <?php if (trim($valueOld) == "") { echo "<font color='#FF0000'>";  }?>
	                                        <b>Current Value</b>
                                                <input value="<?php echo $valueOld ?>" name="valueOld" /> (Old/Current Value)
                                                </font><br/>

                                                <input type="submit" name="submit" value="Apply"/>

                                </form>



				</p>
				
		</div>
		
		<div id="footer">
		
								<?php
        include 'page-footer.php';
?>

		
		</div>
		
</div>
</div>


</body>
</html>