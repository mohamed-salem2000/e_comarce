<?php
session_start();

class Connection{
public $host = "localhost";
public $user = "root";
public $password = "";
public $db_name = "perif_project";
public $con;

    public function __construct(){
    $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
}
}

class Register extends Connection{
public function registration($name , $email , $address , $password , $confirmpassword ,$image){
    $duplicate = mysqli_query($this->con, "SELECT * FROM user WHERE name = '$name' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
return 10;

    }
    else{
      if($password == $confirmpassword){
        $query = "INSERT INTO `user` (name, email, address, password, confirmpassword) VALUES ('$name', '$email', '$address', '$password', '$confirmpassword')";
                 
      
        mysqli_query($this->con, $query);
        return 1;
        // Registration successful
      }
      else{
        return 100;
        // Password does not match
      }
    }
  }
}

class Login extends Connection{
  public $id;
  public function login($usernameemail, $password){
    $result = mysqli_query($this->con, "SELECT * FROM user WHERE name = '$usernameemail' OR email = '$usernameemail'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
      if($password == $row['password']){
        $this->id = $row["id"];
        return 1;
        // Login successful
      }
      else{
        return 10;
        // Wrong password
      }
    }
    else{
      return 100;
      // User not registered
    }
  }

  public function idUser(){
    return $this->id;
  }
}

class Select extends Connection{
  public function selectUserById($id){
    $result = mysqli_query($this->con, "SELECT * FROM user WHERE id = '$id'");
    return mysqli_fetch_assoc($result);
  }
}

