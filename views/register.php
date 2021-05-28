<h1>Register</h1>

<?php $form = App\Core\Form\Form::begin(['action' => '', 'method' => 'POST']); ?>

<?php echo $form->field($model, 'firstName'); ?>
<?php echo $form->field($model, 'lastName'); ?>
<?php echo $form->field($model, 'email'); ?>
<?php echo $form->field($model, 'password')->passwordField(); ?>
<?php echo $form->field($model, 'passwordConfirm')->passwordField(); ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php App\Core\Form\Form::end(); ?>