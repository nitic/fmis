<div id="left">
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>เมนูย่อย</span></a>
				</div>
				<ul class="subnav-menu">
					<?php 
					     foreach($submenu as $url => $value): ?>
						<li>
						    <a href="<?php echo base_url().$url;?>"><?php echo $value;?></a>
					    </li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>