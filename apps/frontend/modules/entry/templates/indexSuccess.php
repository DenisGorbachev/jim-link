<?php use_helper('Date', 'Short') ?>
<h1><?php echo __('Take a short!') ?></h1>
<form id="shortenForm" method="post" action="<?php echo url_for('@homepage') ?>">
  <div id="shortenResult">
  <?php if (isset($shrt)): ?>
  <h3><?php echo link_self($shrt) ?><br/><small><?php echo __('for').' '.link_self($url) ?></small></h3>
  <?php $url = null ?>
  <?php elseif (isset($error)): ?>
  <h4 class="error"><?php echo __('Bad Url format') ?></h4>
  <?php else: ?>
  <?php $url = null ?>
  <?php endif ?>
  </div>
  <?php echo tag('input', array('type' => 'url', 'name' => 'url', 'value' => $url, 'maxlength' => 1024)) ?>
  <button type="submit"><?php echo __('Shorten') ?></button>
</form>
<div id="freshList">
  <h2><?php echo __('Fresh list') ?></h2>
  <table>
    <thead>
      <tr>
        <th class="short"><?php echo __('Short') ?></th>
        <td class="long"><?php echo __('Long') ?></td>
        <td class="date"><?php echo __('Time ago') ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($symlinks as $i => $symlink): ?>
      <tr<?php echo $i % 2 ? ' class="odd"' : '' ?>>
        <th><?php echo short_link($symlink['id']) ?></th>
        <td><?php echo $symlink['url'] ?></a></td>
        <td><?php echo distance_of_time_in_words(strtotime($symlink['created_at'])) ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<?php echo javascript_include_tag('lang/'.$sf_user->getCulture()) ?>
<?php echo javascript_include_tag('main') ?>