<?php use_helper('Date') ?>
<h1><?php echo __('Take a short') ?></h1>
<?php echo form_tag(url_for('@homepage')) ?>
<?php echo tag('input', array('type' => 'text', 'name' => 'url', 'maxlength' => 1024)) ?>
<button type="submit"><?php echo __('Shorten') ?></button>
</form>
<h2><?php echo __('Fresh list') ?></h2>
<table>
  <thead>
    <tr>
      <td><?php echo __('Short') ?></td>
      <td><?php echo __('Long') ?></td>
      <td><?php echo __('Date') ?></td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($symlinks as $symlink): ?>
    <tr>
      <?php $short = url_for('@redirect?short='.$symlink['id'], array('absolute' => true)) ?>
      <th><a href="<?php echo $short ?>"><?php echo $short ?></a></th>
      <td><a href="<?php echo $symlink['url'] ?>"><?php echo $symlink['url'] ?></a></td>
      <td><?php echo distance_of_time_in_words(strtotime($symlink['created_at'])) ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>