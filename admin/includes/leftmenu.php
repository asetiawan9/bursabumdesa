<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main" style="height:100%">
            <li class=" navigation-header"><span>General</span><i data-toggle="tooltip" data-placement="right" data-original-title="General" class=" ft-minus"></i></li>
			<?php
			$db->query("select * from menu where parent_id='0' and status='1'");
			$result=$db->fetchAll();
			foreach($result as $row):
			$menuname=$row['name'];
			/** link identification **/
			if($row['filename']=="index.php") $menulink=$baseUrl."";
			else if($row['filename']=="javascript:;") $menulink="javascript:;";
			else $menulink=$baseUrl.str_replace(".php", "", $row['filename'])."/";
			/** list of filenames **/
			$flnames=$db->extractCol("select filename from menu where parent_id='$row[id]'");
			$flnames=explode(",", $flnames);
			$flnames[]=$row['filename'];
			if($user->canAccess=="all" || in_array($row['id'],$user->canAccess)) {
			?>
            <li class="nav-item <?php if(in_array($curFilename, $flnames) && $general->hasSubmenu($row['id'])) { echo "open active"; } else if(in_array($curFilename, $flnames)) { echo "active"; } ?>"><a href="<?php echo $menulink; ?>"><i class="fa fa-<?php echo $row['icon']; ?>"></i><span class="menu-title"><?php echo $menuname; ?></span></a>
			<?php
			$db->query("select * from menu where status='1' and parent_id='$row[id]'");
			$subresult=$db->fetchAll();
			if(count($subresult)>0) { echo '<ul class="menu-content">';
			foreach($subresult as $subrow):
			$submenuname=$subrow['name'];
			/** link identification **/
			if($subrow['filename']=="index.php") $submenulink=$baseUrl."";
			else if($subrow['filename']=="javascript:;") $submenulink="javascript:;";
			else $submenulink=$baseUrl.str_replace(".php", "", $subrow['filename'])."/";
			?>
			<li><a href="<?php echo $submenulink; ?>" class="menu-item"><i class="fa fa-genderless"></i><?php echo $submenuname; ?></a></li>
			<?php endforeach; echo '</ul>'; } } endforeach; ?>
			</li>
        </ul>
    </div>
</div>