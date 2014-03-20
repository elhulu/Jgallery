

<ul id="albumlist" class="kwicks kwicks-horizontal">

    <?php if(isset($parent_album['Album']['parent_album'])){ ?>

    <li id="album<?php echo $parent_album['Album']['parent_album']; ?>">
        <div class="albumdisplayprev" id="albumdisplay1">
        <i class="glyphicon glyphicon-arrow-left"></i>
            </div>
    </li>

    <?php $iAlbums = 2; }else{ $iAlbums = 1; } ?>

<?php

foreach($UserAlbums as $fields): ?>
    <li id="album<?php echo $fields['Album']['id']; ?>">
        <div class="albumdisplay" id="albumdisplay<?php echo $iAlbums; ?>">
            <?php
            App::uses('String', 'Utility');
            echo String::truncate($fields['Album']['name'], 22,array('ellipsis' => ' ...','exact' => true) );
            ?>
        </div>
    </li>
    <?php
    $iAlbums++;
endforeach; ?>
</ul>
