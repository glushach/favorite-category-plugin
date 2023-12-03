<?php
/*
 * Plugin Name:       Избранные рубрики
 * Description:       Плагин создает виджет, позволяющий вывести последние записи из выбранных рубрик.
 * Plugin URI:        https://webformyself.com/
 * Author:            Александр
 * Author URI:        https://webformyself.com/
 * Version:           1.0.0
 */

add_action('widgets_init', 'wfm_cats');

function wfm_cats()
{
  register_widget('WFM_Cats');
}

class WFM_Cats extends WP_Widget
{
  public function __construct()
  {
    $args = array(
      'name' => 'Избранные рубрики',
      'description' => 'Виджет выводит последние записи выбранных рубрик'
    );
    parent::__construct('wfm-cats', '', $args);
  }

  public function form($instance)
  {
    $count = isset($instance['count']) ? $instance['count'] : 5;
    ?>
      <p>
        <label for="<?php echo $this->get_field_id('count') ;?>">Кол-во записей для вывода:</label>
        <input type="text" name="<?php echo $this->get_field_name('count') ;?>" id="<?php echo $this->get_field_id('count') ;?>" value="<?php echo $count ;?>" class="widefat">
      </p>
    <?php
  }

  public function widget($args, $instance)
  {
  }

/*   public function update()
  {

  } */
}
