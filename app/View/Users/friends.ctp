
            <h4>Amis</h4>

            <ul id="friendlist" class="nav nav-pills nav-stacked" style="max-width: 168px;">
                <?php foreach($friends as $friend): ?>
                <li>
                    <a href="/pepi/my_jGallery/pics/userflow/<?php echo $friend[0]["User"]["id"]; ?>"><?php echo $friend[0]["User"]["username"]; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>

