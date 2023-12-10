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
    $cats = get_categories();
    ?>
      <p>
        <label for="<?php echo $this->get_field_id('count') ;?>">Кол-во записей для вывода:</label>
        <input type="text" name="<?php echo $this->get_field_name('count') ;?>" id="<?php echo $this->get_field_id('count') ;?>" value="<?php echo $count ;?>" class="widefat">
      </p>
    <?php
    echo '<p>';
    foreach($cats as $cat) {
      ?>
        <input type="checkbox" name="<?php echo $this->get_field_name('inc');?>[]" id="<?php echo $this->get_field_id('inc') . $cat->cat_ID ;?>" value="<?= $cat->cat_ID ;?>" <?php if(is_array($instance['inc']) && in_array($cat->cat_ID, $instance['inc'])) echo "checked" ?>>
        <label for="<?php echo $this->get_field_id('inc') . $cat->cat_ID ;?>"><?php echo $cat->name ;?></label> </br>
      <?php
    }
    echo '</p>';
  }

  public function widget($args, $instance)
  {
    if(!empty($instance['inc'])) {
      foreach($instance['inc'] as $cat_id) {
        $cat = get_category($cat_id);
        global $post;
        $posts = get_posts(
          array(
            'category' => $cat_id,
            'numberposts' => $instance['count']
          )
        );
        echo '<div class="widget" style="margin-bottom: 25px">';
          echo "<h2>{$cat->name}</h2>";
          echo '<ul style="list-style-type: none;">';
          foreach($posts as $post) {
            setup_postdata($post);
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
          }
          wp_reset_postdata();
          echo '</ul>';
        echo '</div>';
      }
    }
  }

/*   public function update()
  {

  } */
}
