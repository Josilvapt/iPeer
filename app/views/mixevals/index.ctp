<div class="content-container">
  <?php echo $this->element('evaltools/tools_menu', array());?>
  <div class="list-add">
    <?php echo $html->link(__('Add Mix Evaluation', true), '/mixevals/add', array('class' => 'add-button')); ?>
  </div>

  <div><?php echo $this->element("list/ajaxList", array ("paramsForList" =>$paramsForList)); ?></div>
</div>
