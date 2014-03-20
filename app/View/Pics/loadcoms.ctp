<?php foreach($PicComs as $com): ?>

<div class="ComMain">
    <div class="ComHead"><span><?php echo $com['User']['username']; ?></span> ৹ <?php echo $com['Com']['created']; ?> </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="ComContent"><?php echo $com['Com']['content']; ?></div>

        </div>
    </div>
</div>

<?php endforeach; ?>


<div class="FScomaddmain">



                <form class="bs-example form-horizontal" method="POST" id="login_form">

                <div class="form-group">
                    <label class="col-lg-2 formlabel addcomlabel" for="inputUsername">Nouveau commentaire</label>
                    <div class="col-lg-11 forminput whitebox-input-input">
                        <textarea class="form-control comtextarea" name="FScomcontent" id="FScomcontent<?php echo $picid; ?>" cols="30" rows="3"></textarea>
                    </div>
                </div>

            </form>

            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-8 ">
                    <button id="FScombutt<?php echo $picid; ?>" class="btn btn-primary btncomsubmit" type="submit" id="submitbutt">Envoyer</button>
                </div>
            </div>


</div>