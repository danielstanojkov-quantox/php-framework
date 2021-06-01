<?php

/**@var \App\Models\User $model */
?>

<h1>Login</h1>

<?php $form = App\Core\Form\Form::begin(['action' => '', 'method' => 'POST']); ?>

<?php echo $form->field($model, 'email'); ?>
<?php echo $form->field($model, 'password')->passwordField(); ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php App\Core\Form\Form::end(); ?>