<?php 
include 'config.php';
if(isset($_POST['submit'])){
    /*echo '<pre>';
        print_r($_POST); echo '</pre>';*/
    $f_name = strtolower(trim($_POST['form_name']));
    $f_id = strtolower(trim($_POST['form_id']));
    $f_method = trim($_POST['form_method']);
    $f_action = trim($_POST['form_action']);
    $_css_template = trim($_POST['form_css_template']);
    $sql = "INSERT INTO forms(name,form_id,method,action_uri,css_template) VALUES('$f_name','$f_id','$f_method','$f_action','$_css_template')";
    if(mysql_query($sql)){
        $success_msg= 'Form Created Successfully';
    }else{
        $error_msg= mysql_error();
    }
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Form Generator</title>
        <style type="text/css">
            body{
                font-family: Trebuchet MS,Georgia,Arial;
                line-height: 17px;
                padding: 0;
                margin: 0;
            }
             .site_title{
                background: burlywood;
                padding: 15px;
                color:#fff;
                margin: 0;
            }
            .menu-div{
                float:left;
                width:80%;
                border:1px solid burlywood;
                border-radius: 4px;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                background-color: buttonface;
            }
            .menu{
                list-style: none;
                padding: 0px;
            }
            .menu li{
                display: inline;
                width: 100%;
                }
            .menu li a{
                text-decoration: none;
                padding: 5px;
                width: 95%;
                float: left;
            }
            .menu li a.active{
                background: burlywood;
                color: #fff;
            }
            table td{
                vertical-align: top;
            }
            .form-field{
                float: left;
                width: 100%;
                margin-bottom: 10px;
            }
            .content{
                float:left;
                width:98%;
                border:1px solid burlywood;
                border-radius: 4px;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                padding:10px;
            }
            input[type="text"]{
                 border:1px solid burlywood;
                border-radius: 4px;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                width: 280px;
                height: 25px;                
            }
            select{
               border:1px solid burlywood;
                border-radius: 4px;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                width: 285px;
                height: 30px;   
            }
            .submit,.reset{
                 border:1px solid burlywood;
                border-radius: 4px;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                padding:5px 10px;
                font-family: Trebuchet MS,Georgia,Arial;
                font-weight: bold;
              }
            .submit:hover,.reset:hover{
                background: burlywood;
                color:#fff;
            }
            table th{
                text-align: left;
            }
            label.error{
                color: red;
            }
            .success_msg{
                color: green;
                font-weight: bold;
                padding:3px;
                background-color:beige;
                margin: 0;
            }
            .forms-list th{
                background: burlywood;
                padding: 5px;
            }
            .forms-list td{
                padding: 5px;
            }
            .forms-list tr.odd td{
                background: buttonface;
                
            }
            .forms-list tr.even td{
                background: burlywood;
            }
        </style>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){    
                $('ul.tabs').each(function(){
                    // For each set of tabs, we want to keep track of
                    // which tab is active and it's associated content
                    var active, content, links = $(this).find('a');

                    // If the location.hash matches one of the links, use that as the active tab.
                    // If no match is found, use the first link as the initial active tab.
                    active = $(links.filter('[href="'+location.hash+'"]')[0] || links[0]);
                    active.addClass('active');
                    content = $(active.attr('href'));

                    // Hide the remaining content
                    links.not(active).each(function () {
                        $($(this).attr('href')).hide();
                    });

                    // Bind the click event handler
                    $(this).on('click', 'a', function(e){
                        // Make the old tab inactive.
                        active.removeClass('active');
                        content.hide();

                        // Update the variables with the new link and content
                        active = $(this);
                        content = $($(this).attr('href'));

                        // Make the tab active.
                        active.addClass('active');
                        content.show();

                        // Prevent the anchor's default click action
                        e.preventDefault();
                    });
                });
                //Validate
                jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
  return this.optional(element) || /^[a-z0-9\-_\s]+$/i.test(value);
}, "Letters and (hyphon, underscore)");
                $('#addForm').validate();
                
                $('.success_msg').fadeOut(2000);
            });
           
        </script>
    </head>
    <body>
        <h1 class="site_title">Form Generator</h1>
        <table align="left" width="100%">
            <tbody>
                <tr>
                    <td width="15%">
                        <h2>Menu</h2>
                        <div class="menu-div">
                        <ul class="menu tabs">
                            <li><a href="#all_forms">All Forms</a></li>
                            <li><a href="#add_form">Add Form</a></li>
                        </ul>
                        </div>
                    </td>
                    <td width="85%">
                        <h2>Form</h2>
                        <div class="content">
                         <div class="ui-tabs-panel" id="all_forms">
                            <table width="100%" class="forms-list">
                                <tbody>
                                      <?php
                                    $fetch_sql = "SELECT * FROM forms";
                                    $result = mysql_query($fetch_sql);
                                    if(mysql_num_rows($result)){
                                    ?>
                                    <tr>
                                        <th>Form Name</th>
                                        <th>Form ID</th>
                                        <th>Form Action Method</th>
                                        <th>Form Action URI</th>
                                        <th>Action</th>
                                    </tr>
                                  <?php 
                                  $i=1;
                                  while ($row = mysql_fetch_assoc($result)): ?>
                                    <tr class="<?php if(($i++)%2==0){?>even<?php }else{?>odd<?php }?>">
                                        <td><a href="editForm.php?id=<?php echo $row['id']; ?>"><?php echo $row['name'];?></a></td>
                                        <td><?php echo $row['form_id'];?></td>
                                        <td><?php echo $row['method'];?></td>
                                        <td><?php echo $row['action_uri'];?></td>
                                        <td><a href="addfields.php?id=<?php echo $row['id']; ?>">Add/Edit Fields</a> | <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                                         | <a href="mail-template.php?id=<?php echo $row['id']; ?>">Download Mail Code</a> | <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="confirm('Are you sure to delete this form?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endwhile;
                                    }else{?>
                                    <tr>
                                        <td><p style="color:red;">There is no form generated still now</p></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="ui-tabs-panel" id="add_form">
                           <?php if(isset($success_msg)){?><p class="success_msg"><?php echo $success_msg; ?></p><?php }?>  
                            <form action="" name="addForm" id="addForm" method="post">
                                <div class="form-field">
                                <label>Form Name</label><br/><input type="text" name="form_name" value="" class="required letterswithbasicpunc"/>
                                </div>
                                <div class="form-field"> 
                                <label>Form ID<br/><input type="text" name="form_id" value="" class="letterswithbasicpunc"/></label><br/>
                                </div>
                                <div class="form-field">
                                <label>Form Action Method<br/> 
                                    <select name="form_method">
                                        <option value="GET">GET</option>
                                        <option value="POST">POST</option>
                                    </select>
                                </label>
                                </div>
                                <div class="form-field">
                                <label>Form Action URI<br/> <input type="text" name="form_action" value="" class="url"/></label>
                                </div>
                                <div class="form-field">
                                <label>Form CSS Template<br/> 
                                <?php 
                                $templates = get_dirs();
                                ?><select name="form_css_template">
                                <?php     
                                foreach ($templates as $template){
                                    ?>
                                    <option value="<?php echo $template;?>"><?php echo $template;?></option>
                                   <?php
                                }
                                ?>
                                </select>    
                                </label>
                                </div>
                                <div>
                                    <input type="submit" class="submit" name="submit" value="Add New"/>
                                    <input type="reset" class="reset" name="reset" value="Reset"/>
                                </div>
                            </form>
                        </div>     
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>  
    </body>
</html>   
