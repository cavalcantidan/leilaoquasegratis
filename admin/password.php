<?
	session_start();
    $usuario_admin=isset($_SESSION['UsErOfAdMiN'])?$_SESSION['UsErOfAdMiN']:'';

   include("admin.config.inc.php");
   include("connect.php");
   
  $query="select * from admin where username='".$_POST["name"]."' and pass='".$_POST["pass"]."'";
  $result=mysql_query($query,$db);
  $row=mysql_fetch_array($result);
  $total = mysql_num_rows($result);
  $name=$_POST['name'];
  $pass=$_POST['pass'];
  $ADMIN_USERNAME=$row["username"];
  $ADMIN_PASSWORD=$row["pass"];
  
  if($total>0){	  
	  if($name==$ADMIN_USERNAME && $pass==$ADMIN_PASSWORD){
		  if($usuario_admin!='') $_SESSION['UsErOfAdMiN']="";
          $_SESSION["UsErOfAdMiN"] = $name;
          $_SESSION['logedin'] = true;
          $_SESSION["type"] = $row["type"];
          $_SESSION["usrname"] = $name;
          $_SESSION["logid"] = $row["id"];
          header("Location:innerhome.php");
	  }
  } else {
    header("Location:index.php?id=1");
  }
?>