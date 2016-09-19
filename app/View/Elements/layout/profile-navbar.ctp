<ul class="nav navbar-nav navbar-right">   
        <li class="dropdown navbar-profile">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
			<?php
				if ($avatarData && file_exists(IMAGES.'persone'.DS.'persona'.$idUtenteLoggato.DS.$avatarData->nomeFile)) {
					$urlToAvatar = DS.'app'.DS.'webroot'.DS.'img'.DS.'persone'.DS.'persona'.$idUtenteLoggato.DS.$avatarData->nomeFile;
					$endx = $avatarData->x + $avatarData->width;
					$endy = $avatarData->y + $avatarData->height;
					$options = array(
						'crop' => true,
						'cropvars' => array(
							0 => $avatarData->x,
							1 => $avatarData->y,
							2 => $endx,
							3 => $endy
						)
					);
				}
				else {
					$urlToAvatar = DS.'app'.DS.'webroot'.DS.'img'.DS.'persone'.DS.'avatar-missing.png';
					$options = array('crop' => false);
				}
				$options['width'] = 30;
				$options['height'] = 30;
				$options['htmlAttributes'] = array(
					'class' => 'navbar-profile-avatar'
				);
				echo $this->Image->resize($urlToAvatar,$options);
			?>
            <span class="navbar-profile-label">rod@rod.me &nbsp;</span>
            <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu" role="menu">
			<?php foreach ($profilemenu as $menuitem): ?>
				<li class="<?php if($menuitem['li-class']) echo $menuitem['li-class']; ?>" style="<?php if($menuitem['li-style']) echo $menuitem['li-style']; ?>">
				  <a href="<?php echo $this->Html->url($menuitem['url']); ?>">
					<i class="fa fa-<?php echo $menuitem['icon']; ?>"></i> 
					&nbsp;&nbsp;<?php echo $menuitem['title']; ?>
				  </a>
				</li>
			<?php endforeach ?>
          </ul>
        </li>
</ul>
