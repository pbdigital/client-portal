<div class="card" style="margin-top:20px">
    <div class="card-header">
        <div class="pull-right"><button type="button" class="btn btn-primary btn-sm btn-with-act" data-act="add_user">Add User</button></div>
        <div class="card-title">Users</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>AsanaProjectID</th>
                <th>QuickbooksClientID</th>
                <th>EverhourClientID</th>
                <th></th>
            </thead>
            <tbody>
                <?php 
                $fields = array("first_name", "last_name", "email", "asana_project_id", "quickbooks_client_id", "everhour_client_id");
                
                foreach($users as $user):

                    ?>
                    <tr>
                        <?php 
                        foreach($fields as $field):
                        ?>
                        <td style="position:relative;">
                            <input type="text" class="form-control listen-on-change" 
                                data-act="update_user_field" 
                                data-userid="<?php echo $user->user_id;?>"
                                data-field="<?php echo $field;?>" 
                                value="<?php echo $user->$field;?>" />
                        </td>
                        <?php 
                        endforeach;
                        ?>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm btn-with-act" data-act="delete_user" data-userid="<?php echo $user->user_id;?>"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        
        </table>
    </div>
</div>
