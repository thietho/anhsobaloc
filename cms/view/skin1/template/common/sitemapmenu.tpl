<div class="section">

	<div class="content">
    
    	<ul id="menu">
            <?php echo $menu?>
        </ul>
    
    </div>
</div>

<div class="section">

	<div class="section-title"><?php echo $menu_addons?></div>
    
	<div class="content">
   		<ul>
        	 <?php echo $addon?>
        </ul>
    </div>
</div>

<div class="section">

	<div class="section-title">Management</div>
    
	<div class="content">
   		<ul>
        	<?php foreach($addonmodule as $key => $item){?>
            <li><a href="?route=<?php echo $key?>"><?php echo $item?></a></li>
            <?php }?>
        </ul>
    </div>
</div>
<div class="section">

	<div class="section-title">Quản lý biên nhận</div>
    
	<div class="content">
   		<ul class="nicelist">
        	<li><a href="index.php?route=addon/dichvu">Dịch vu</a></li>
            <li><a href="index.php?route=addon/biennhan">Biên nhận</a></li>
        </ul>
    </div>
</div>
<div class="section">

	<div class="section-title"><?php echo $menu_myaccount?></div>
    
	<div class="content">
   		<ul class="nicelist">
        	<li><a href="index.php?route=common/dashboard">Dashboard</a></li>
            <li><a href="index.php?route=common/sitebar">Site bar</a></li>
        	<li><a href="index.php?route=common/profile"><?php echo $button_myprofile?></a></li>
            <li><a href="index.php?route=common/changepassword"><?php echo $button_change_password?></a></li>
            <li><a href="logout.php"><?php echo $button_logout?></a></li>
        </ul>
    </div>
</div>

<?php if($safemode) {?>
<div class="section">

	<div class="section-title"><?php echo $menu_admin?></div>
    
	<div class="content">
   		<ul class="nicelist">
        	<li><a href="index.php?route=core/site">Web Multi-Site</a></li>
            <li><a href="index.php?route=core/sitemap">Sitemap Management</a></li>
            <li><a href="index.php?route=core/module">Module Management</a></li>
        </ul>
    </div>
</div>
<?php } ?>