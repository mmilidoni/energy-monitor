<?php
	switch($state) {
		case true:
			$icon = 'on-icon.png';
			$href = $this->Html->url(array('controller' => 'Persone', 'action' => 'disattiva', $id));
			break;
		case false:
			$icon = 'lock-icon.png';
			$href = 'javascript:void(0)';
			break;
	}
	echo '<a href="'.$href.'">'.$this->Html->image($icon, array('width' => 25)).'</a>';
?>
