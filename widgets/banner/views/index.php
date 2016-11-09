<?php
/**
 * Created by PhpStorm.
 * User: jsparrow
 * Date: 16-11-8
 * Time: 下午3:57
 */
 ?>
 <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width: 850px; margin: auto;">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <?php foreach ($data['items'] as $item) : ?>
    <li data-target="#carousel-example-generic" data-slide-to="0"<?= isset($item['active']) && $item['active'] ? 'class="active"' : '' ?>></li>
      <?php endforeach; ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
      <?php foreach ($data['items'] as $item) : ?>
        <div class="item <?= isset($item['active']) && $item['active'] ? 'active' : '' ?>">
            <img src="<?= $item['image_url'] ?>" alt="<?= $item['label'] ?>">
            <div class="carousel-caption">
            <?= $item['html'] ?>
            </div>
        </div>
      <?php endforeach; ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>