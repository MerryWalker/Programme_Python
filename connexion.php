<?php
session_start();

if($_POST['submit']){
    $ScName=strip_tags($_POST['ScName']);
    $fname=strip_tags($_POST['fname']);
    $lname=strip_tags($_POST['lname']);
    $email=strip_tags($_POST['email']);
    $password=strip_tags($_POST['password']);
    $password2=strip_tags($_POST['password2']);

    $error = array();

        if(empty($email) or !filter_var($email,FILTER_SANITIZE_EMAIL))
        {
          $error[] = "Email id is empty or invalid";
        }
        if(empty($password)){
          $error[] = "Please enter password";
        }
        if(empty($password2)){
          $error[] = "Please enter Confirm password";
        }
        if($password != $password2){
           $error[] = "Password and Confirm password are not matching";
        }
        if(empty($fname)){
            $error[] = "Enter first name";
        }
        if(empty($lname)){
            $error[] = "Enter last name";
        }

        if(count($error == 0)){
            //database configuration
            $host = 'localhost';
            $database_name = 'mongo1';
            $database_user_name = '';  
            $database_password = '';  


             $conntionZ = new SQL('localhost:3306+')
             $connection=new Mongo('localhost');

             if($connection){

                 //connecting to database
                 $database=$connection->$database_name;

                 //connect to specific collection
                 $collection=$databse->user;

                 $query=array('email'=>$email);
                 //checking for existing user
                 $count=$collection->findOne($query);

                 if(!count($count)){
                     //Save the New user
                     $user=array('fname'=>$fname,'lname'=>$lname,'ScName'=>$ScName,'email'=>$email,'password'=>md5($password),'password'=>$password2);             
                     $collection->save($user);
                     echo "You are successfully registered.";
                 }else{
                     echo "Email is already existed.Please register with another Email id!.";
                 }

             }else{

                  die("Database are not connected");
             }

        }else{
            //Displaying the error
            foreach($error as $err){
                echo $err.'</br>';
            }
        }
        }

?>
