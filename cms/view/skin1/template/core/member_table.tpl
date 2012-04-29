			<table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        
                        <th>Tên đăng nhập</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Trang thái</th>
                        <?php if($_GET['dialog'] != 'true'){ ?>                 
                        <th width="10%">Control</th>                                  
                        <?php } ?>
                    </tr>
                    
        
        
        <?php
            foreach($users as $user)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $user['id']?>]" value="<?php echo $user['id']?>" ></td>
                        
                        <td><?php echo $user['username']?></td>
                        <td><?php echo $user['fullname']?></td>
                        <td><?php echo $user['phone']?></td>
                        <td><?php echo $user['address']?></td>
                        <td><?php echo $user['email']?></td>
                		<td><?php echo $this->document->userstatus[$user['status']]?></td>
                        <?php if($_GET['dialog'] != 'true'){ ?>
                        <td class="link-control">
                            <input type="button" class="button" value="<?php echo $user['text_edit']?>" onclick="window.location='<?php echo $user['link_edit']?>'"/>
                            <input type="button" class="button" value="<?php echo $user['text_active']?>" onclick="activeUser('<?php echo $user['id']?>')"/>
                            
                        </td>
                        <?php } ?>
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
			</table>
            <?php echo $pager?>