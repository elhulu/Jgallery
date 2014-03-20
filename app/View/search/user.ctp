<div class="mainwell">

    <h3><?php echo count($searchres); ?> Utilisateur<?php if(count($searchres) > 0) {echo 's';}?> correspondant<?php if(count($searchres) > 0) {echo 's';}?></h3>
    <?php foreach($searchres as $res): ?>
    <div class="well well-lg">
        <strong><a href="/pepi/my_jGallery/pics/userflow/<?php echo $res['User']['id']; ?>"><?php echo $res['User']['username']; ?></a></strong>
        <div class="thumbwall">
            <ul class="thumbminiwall">
                <?php $ipic=0; foreach($res['Pic'] as $pic):
                    if($ipic <= 12) { ?>
                <li><img src="/pepi/my_jGallery/img/users/picstock/upload/<?php echo $pic['user_id']; ?>/thumbnail/<?php echo basename($pic['url_thumb']); ?>" alt=""/></li>
                <?php } $ipic++; endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>




    <h3><?php echo count($searchresalbum); ?> Album<?php if(count($searchresalbum) > 0) {echo 's';}?> correspondant<?php if(count($searchresalbum) > 0) {echo 's';}?></h3>
    <?php foreach($searchresalbum as $res): ?>
        <div class="well well-lg">
            <strong><a href="/pepi/my_jGallery/pics/userflow/<?php echo $res['Album']['user_id']; ?>"><?php echo $res['Album']['name']; ?></a></strong>

        </div>
    <?php endforeach; ?>


</div>

