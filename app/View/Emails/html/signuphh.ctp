<p>
    <strong>Bienvenue</strong> <?php echo $username; ?>
</p>

<p>Pour activer votre compte cliquez sur le lien suivant : </p>
<p><?php echo $this->Html->link('Aciver mon compte',$this->Html->url($link,true)); ?></p>


<p>A bientôt sur Picflow !</p>