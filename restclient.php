<?php
   /*
   Plugin Name: Rest Client
   Plugin URI: http://my-awesomeness-emporium.com
   Description: gets data from the fogg api
   Version: 1.2
   Author: Tinashe Tsvigu
   Author URI: http://mrtotallyawesome.com
   License: GPL2
   */
   class Task_crud{
    private function __construct(){
          wp_register_script( 'my_plugin_script', plugins_url('form.js', __FILE__), array('jquery'),'1.12.4',TRUE);
wp_enqueue_script( 'my_plugin_script' );
      add_action('the_content',array($this,'form_add'));
      add_action('the_content',array($this,'get_rest'));
 

    }
    private static $instance;
    public function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    } // end get_instance
 
  

   public function row_delete()
      {
        
           $response = wp_remote_post( 'http://localhost/fogg/admin/up/6', array(
                  'method' => 'DELETE',
                  'timeout' => 45,
                  'redirection' => 5,
                  'httpversion' => '1.0',
                  'blocking' => true,
                  'headers' => array(),
                  'body' => array('task_id'=>$_POST['task_id']),
                  'cookies' => array()
                    )
                );

                if ( is_wp_error( $response ) ) {
                   $error_message = $response->get_error_message();
                   echo "Something went wrong: $error_message";
                } else {
                   echo 'Response:<pre>';
                echo $response['body'];
                   echo '</pre>';
                }
             
      }
     public  function row_edit($value='')
      {
        # code...
      }
     public  function form_add()
      {
        
        $form= '<div style="padding:10px;margin-top:50px;" id="edit"><button id="cls">close form X</button><form name="task" method="POST" id="task" >';
         $form.=' <label>Task Name: </label><input type="text" id="cf-name" name="cf-name" required />';
         $form.='  <label>Task Description: </label><input type="text" id="desc" name="desc" required/>';
          $form.=' <label>Task Due Date </label><input type="text" name="due_date" id="due_date" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="12/12/2006" required>';
          $form.=' <label id="idse">User id</label><input type="number" id="user_id" name="user_id" required />';
          $form.=' <input type="hidden"  name="task_submit" id="task_submit" value="3" style="border-radius:10px;" />';
          $form.=' <input type="hidden"  name="task_id" id="task_id" value="0" style="border-radius:10px;" />';
           $form.=' <input type="submit"  name="task_submits" value="add task" style="border-radius:10px;" />';
          $form.=' </form></div>';
           echo $form;

           if($_POST['task_submit']==3){
                print_r($_POST);
                echo $_POST["due_date"]."\t".$_POST["desc"];
                $data = array('task_name' =>esc_attr( $_POST["cf-name"]), 'user_id' =>esc_attr( $_POST["user_id"]), 'task_desc' => $_POST["desc"], 'task_dueDate' =>$_POST["due_date"]);
                $response = wp_remote_post( 'http://localhost/fogg/admin/up/6', array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => $data,
                'cookies' => array()
                  )
              );

              if ( is_wp_error( $response ) ) {
                 $error_message = $response->get_error_message();
                 echo "Something went wrong: $error_message";
              } else {
                 echo 'Response:<pre>';
              echo $response['body'];
                 echo '</pre>';
              }
           }
           if ($_POST['del']) {
           $response = wp_remote_post( 'http://localhost/fogg/admin/up/6', array(
                  'method' => 'DELETE',
                  'timeout' => 45,
                  'redirection' => 5,
                  'httpversion' => '1.0',
                  'blocking' => true,
                  'headers' => array(),
                  'body' => array('task_id'=>$_POST['task_id']),
                  'cookies' => array()
                    )
                );

                if ( is_wp_error( $response ) ) {
                   $error_message = $response->get_error_message();
                   echo "Something went wrong: $error_message";
                } else {
                   echo 'Response:<pre>';
                echo $response['body'];
                   echo '</pre>';
                }
             }
              if($_POST['task_id'] && !$_POST['del']){
                //print_r($_POST);
               // echo $_POST["due_date"]."\t".$_POST["desc"];
                $data = array('task_name' =>esc_attr( $_POST["cf-name"]), 'user_id' =>esc_attr( $_POST["user_id"]), 'task_desc' => $_POST["desc"], 'task_dueDate' =>$_POST["due_date"],'task_id'=>$_POST['task_id']);
                $response = wp_remote_post( 'http://localhost/fogg/admin/up/6', array(
                'method' => 'PUT',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => $data,
                'cookies' => array()
                  )
              );

           }

      }
     public function get_rest(){
        // create curl resource
             /* $ch = curl_init();

              // set url
              curl_setopt($ch, CURLOPT_URL, "http://localhost/fogg/admin/up/6");

              //return the transfer as a string
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

              // $output contains the output string
              $output = curl_exec($ch);*/
               $response = wp_remote_get( 'http://localhost/fogg/admin/up/6' );
        try {
 
            // Note that we decode the body's response since it's the actual JSON feed
            $output= json_decode( $response['body'] );
 
        } catch ( Exception $ex ) {
            $output = null;
        } // end try/catch
 



              //print_r($output);
             // $output = json_decode($output);
              if ($output != NULL) {
              //  if ( is_single() ) {
                    $style = "<style>";
                    $style.= "table{ width:100%;}";
                    $style.= "td{ width:100%;}";
                    $style.= "button{ border-radius:5px;height:3px;background:maroon;line-height:2px;width:100%;}";
                    $style.= "button:hover{ background:purple;}";
                    $style.= "</style>";
                    echo $style;
                    echo "<div id='frm'></div><div ><button id='nw'>Add</button><table id='tbl'> <tr> <th> Task id</th> <th> Task</th> <th> Description</th> <th> Due Date</th> <th> user id</th> <th> create date</th> <th colspan='3'>action </th></tr>";
                    foreach ($output as $key => $value ) {
                    echo "<tr><td>".$value->task_id."</td><td>".$value->task_name."</td><td>".$value->task_desc."</td><td>".$value->task_dueDate."</td><td>".$value->user_id."</td><td>".$value->task_createDate."</td><td ><button name='task_btn' id='".$value->task_id."' onclick='getid(".$value->task_id.")'>  delete</button></td><td ><button id='del' onclick='getform(".$value->task_id.")' >edit</button></td></tr>";
                    }
                    echo "</table></div>";
                  }else{
                    echo "curl error";
                  }
              
             // }
              // close curl resource to free up system resources
             // curl_close($ch);
        }



   }
 Task_crud::get_instance();
      //add_action('the_content',array($this,'row_delete'));
?>
